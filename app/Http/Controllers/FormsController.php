<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreFormRequest;
use App\Models\ApplicationInformations;
use App\Models\ResearcherInformations;
use App\Models\Form;
use App\Models\User;
use App\Models\EtikKurulOnayi;
use App\Models\ResearchInformations;
use Exception;
use App\Mail\FormApproved;

class FormsController extends Controller
{
    public function index()
    {
        return view('forms.index');
    }

    public function store(StoreFormRequest $request)
    {

        try {
            $validated = $request->validated();
            //create form


            $form = new Form();
            $form->document_number = $validated['document_number'];
            $form->save();
            // //create researcher informations
            $researcher = new ResearcherInformations();
            $researcher->form_id = $form->id;
            $researcher->name = trim($validated['name']);
            $researcher->lastname = trim($validated['lastname']);
            $researcher->advisor = trim($validated['advisor']);
            $researcher->gsm = trim($validated['gsm']);
            $researcher->email = trim($validated['email']);
            $researcher->major = trim($validated['major']);
            $researcher->department = trim($validated['department']);
            $researcher->student_no = trim($validated['student_no']);
            $researcher->save();
            // //create application informations
            $applicationInfo = new ApplicationInformations();
            $applicationInfo->form_id = $form->id;
            $applicationInfo->application_semester = $validated['application_semester'];
            $applicationInfo->temel_alan_bilgisi = trim($validated['temel_alan_bilgisi']);
            $applicationInfo->academic_year = trim($validated['academic_year']);
            $applicationInfo->application_type = trim($validated['application_type']);
            $applicationInfo->work_qualification = trim($validated['work_qualification']);
            $applicationInfo->research_type = trim($validated['research_type']);
            $applicationInfo->institution_permission = trim($validated['institution_permission']);
            $applicationInfo->research_end_date = $validated['research_end_date'];
            $applicationInfo->research_start_date = $validated['research_start_date'];
            $applicationInfo->save();
            //create research informations
            $research = new ResearchInformations();
            $research->form_id = $form->id;
            $research->research_title = trim($validated['research_title']);
            $research->research_subject_purpose = trim($validated['research_subject_purpose']);
            $research->research_unique_value = trim($validated['research_unique_value']);
            $research->research_hypothesis = trim($validated['research_hypothesis']);
            $research->research_method = trim($validated['research_method']);
            $research->research_universe = trim($validated['research_universe']);
            $research->research_forms = trim($validated['research_forms']);
            $research->research_data_collection = trim($validated['research_data_collection']);
            $research->research_restrictions = trim($validated['research_restrictions']);
            $research->research_place_date = trim($validated['research_place_date']);
            $research->research_literature_review = trim($validated['research_literature_review']);

            $research->save();

            $fieldNameMappings = [
                'document_number' => 'Evrak Numarası',
                'name' => 'Araştırmacı Adı',
                'lastname' => 'Araştırmacı Soyadı',
                'advisor' => 'Danışman Adı',
                'gsm' => 'Araştırmacı GSM',
                'email' => 'Araştırmacı Email',
                'major' => 'Araştırmacı Ana Bilim Dalı',
                'department' => 'Araştırmacı Departman',
                'student_no' => 'Araştırmacı Öğrenci Numarası',
                'application_semester' => 'Başvuru Dönemi',
                'temel_alan_bilgisi' => 'Temel Alan Bilgisi',
                'academic_year' => 'Akademik Yıl',
                'application_type' => 'Başvuru Türü',
                'work_qualification' => 'Çalışma Niteliği',
                'research_type' => 'Araştırma Türü',
                'institution_permission' => 'Kurum İzni',
                'research_end_date' => 'Araştırmanın Bitiş Tarihi',
                'research_start_date' => 'Araştırmanın Başlangıç Tarihi',
                'research_title' => 'Araştırma Başlığı',
                'research_subject_purpose' => 'Araştırma Konusu ve Amacı',
                'research_unique_value' => 'Araştırmanın Benzersiz Değeri',
                'research_hypothesis' => 'Araştırma Hipotezi',
                'research_method' => 'Araştırma Yöntemi',
                'research_universe' => 'Araştırma Evreni',
                'research_forms' => 'Araştırma Formları',
                'research_data_collection' => 'Araştırma Veri Toplama Yöntemleri',
                'research_restrictions' => 'Araştırma Kısıtlamaları',
                'research_place_date' => 'Araştırma Yapılacak Yer ve Tarih',
                'research_literature_review' => 'Araştırma Literatür Taraması',

                // Add more mappings as needed for other sections
            ];

            Mail::send('emails.form-submitted', ['formFields' => $validated, 'fieldNameMappings' => $fieldNameMappings], function ($message) use ($researcher) {
                $message->to($researcher->email, $researcher->name . ' ' . $researcher->lastname)
                    ->subject('Application Confirmation');
            });

            return redirect()->route('forms.index')->with('success', 'Başvurunuz alınmıştır. Bilgilendirme için e-posta adresinizi kontrol ediniz.');
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function approveSekreterlik($formid)
    {
        $form = Form::find($formid);
        $this->startSekreterlikApprovalProcess($form);
        return redirect()->route('dashboard')->with('success', 'Redirected to the dashboard successfully.');
    }

    private function startSekreterlikApprovalProcess(Form $form)
    {
        $form->stage = "etik_kurul";
        $form->save();
        $etikKurulUyeler = User::where('role', 'etik_kurul')->get();

        foreach ($etikKurulUyeler as $etikKurulUye) {
            $etikKurulOnayi = new EtikKurulOnayi([
                'form_id' => $form->id,
                'user_id' => $etikKurulUye->id,
                'onay_durumu' => 'bekleme',
            ]);

            $etikKurulOnayi->save();
        }
    }
    public function approveEtikkurul($formid)
    {
        $form = Form::find($formid);
        $this->startEtikkurulApprovalProcess($form);
        $form->approveFormByEtikKurul(); // Call the new method
        return redirect()->route('dashboard')->with('success', 'Redirected to the dashboard successfully.');
    }

    private function startEtikkurulApprovalProcess(Form $form)
    {
        // Assuming there is only one EtikKurulOnayi entry for each Form
        $etikKurulOnayi = $form->etik_kurul_onayi;

        // Check if the form is already approved to avoid redundant updates
        if ($form->stage !== 'onaylandi') {
            // Find the current user's approval entry
            $currentUserApproval = $etikKurulOnayi->where('user_id', auth()->user()->id)->first();

            // Check if the current user has not approved yet
            if ($currentUserApproval && $currentUserApproval->onay_durumu !== 'onaylandi') {
                $currentUserApproval->onay_durumu = 'onaylandi';
                $currentUserApproval->save();
            }

            // Check if all users with etik_kurul role have approved
            if ($etikKurulOnayi->where('onay_durumu', 'bekleme')->count() === 0) {
                $form->stage = 'onaylandi';
                $form->save();
                $researcherEmail = $form->researcher_informations->email;

                // Send an email to the researcher using the FormApproved Mailable class
                Mail::to($researcherEmail)->send(new FormApproved());
            }
        }
    }
}
