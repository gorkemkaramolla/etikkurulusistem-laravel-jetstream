<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Requests\StoreFormRequest;
use App\Models\ApplicationInformations;
use App\Models\ResearcherInformations;
use App\Models\Form;
use App\Models\User;
use App\Models\EtikKurulOnayi;
use App\Models\ResearchInformations;
use Exception;
use App\Mail\FormApproved;
use App\Mail\FormDeclined;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\LOG;

class FormsController extends Controller
{
    public function index()
    {
        return view('forms.index');
    }
    // /FORMS SUBMIT REQUEST CONTROLLER
    public function store(StoreFormRequest $request)
    {

        try {
            DB::beginTransaction();

            $validated = $request->validated();
            // Create form
            $form = new Form();
            $form->save();

            // Create a directory based on the researcher's student number
            $studentNumber = $validated['student_no'];
            $directory = "public/forms/{$studentNumber}";

            // Create the directory with 755 permissions
            Storage::makeDirectory($directory, 0755, true);

            // Explicitly set the permissions for the created directory
            chmod(storage_path("app/{$directory}"), 0755);

            // Save the files in the specified directories
            $form->onam_path = Storage::putFileAs($directory, $validated["onam_path"], 'onam.pdf', 'public');
            $form->anket_path = Storage::putFileAs($directory, $validated["anket_path"], 'anket.pdf', 'public');

            // Check if 'kurum_izinleri_path' is present and not empty before attempting to save it
            if ($request->hasFile('kurum_izinleri_path') && $request->file('kurum_izinleri_path')->isValid()) {
                $form->kurum_izinleri_path = Storage::putFileAs($directory, $validated["kurum_izinleri_path"], 'kurum_izinleri.pdf', 'public');
            }

            // Save the form after handling file uploads
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
            DB::commit();

            $fieldNameMappings = [
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

            ];
            $sekreterlikRecipients = User::where('role', 'sekreterlik')->pluck('email')->toArray();

            Mail::send('emails.form-submitted', ['formFields' => $validated, 'fieldNameMappings' => $fieldNameMappings], function ($message) use ($researcher, $sekreterlikRecipients) {
                $message->to($researcher->email, $researcher->name . ' ' . $researcher->lastname)
                    ->subject('Application Confirmation')
                    ->cc($sekreterlikRecipients); // Add all users with role "sekreterlik" to CC
            });
            $linkPath = "/query-etikkurul/{$researcher->student_no}";
            $successMessage = 'Başvurunuz alınmıştır. Bilgilendirme için e-posta adresinizi kontrol ediniz.';

            return redirect()->route('forms.index')->with('successMessage', $successMessage)->with('linkPath', $linkPath);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Form patladi: ' . $e->getMessage() . ' Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()->withErrors($validated)->withInput();
        }
    }
    public function approveSekreterlik($formid, Request $request)
    {
        $form = Form::find($formid);
        $decide_reason = $request->input('decide_reason');
        $decide = $request->input('decide');

        $this->startSekreterlikApprovalProcess($form, $decide, $decide_reason);
        return redirect()->route('dashboard')->with('success', 'Redirected to the dashboard successfully.');
    }

    private function startSekreterlikApprovalProcess(Form $form, $decide, $decide_reason)
    {
//SEKRETER ONAY DURUMU
        if ($decide === "onaylandi") {
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
            $etikKurulRecipients = User::where('role', 'etik_kurul')->pluck('email')->toArray();

            $researcherEmail=$form->researcher_informations->email;
            Mail::send('emails.form-sekreter-approved', ['decide_reason' => $decide_reason], function ($message) use ($researcherEmail, $etikKurulRecipients) {
                $message->to($researcherEmail)
                    ->cc($etikKurulRecipients) // Add CC recipients
                    ->subject('Başvurunuz Sekreterlik Tarafından Onaylanmıştır.');
            });
        } else if ($decide === "duzeltme") {
            $ccRecipients = User::pluck('email')->toArray();
//SEKRETER DUZELTME
            $form->stage = "duzeltme";
            $form->decide_reason = $decide_reason;
            $form->save();
            $researcherEmail = $form->researcher_informations->email;

            Mail::send('emails.form-corrected', ['decide_reason' => $decide_reason], function ($message) use ($researcherEmail, $ccRecipients) {
                $message->to($researcherEmail)
                    ->cc($ccRecipients) // Add CC recipients
                    ->subject('Başvurunuz Sekreterlik tarafından düzeltme aşamasına geçmiştir.');
            });
            $form->delete();
        }
    }
    public function approveEtikkurul($formid, Request $request)
    {
        $form = Form::find($formid);
        $decide_reason = $request->input('decide_reason');
        $decide = $request->input('decide');


        // Use $decide_reason as needed in your approval process
        $this->startEtikkurulApprovalProcess($form, $decide, $decide_reason);

        return redirect()->route('dashboard')->with('success', 'Redirected to the dashboard successfully.');
    }

    private function startEtikkurulApprovalProcess(Form $form,  $decide, $decide_reason)
    {

        $etikKurulOnayi = $form->etik_kurul_onayi;


        $currentUserApproval = $etikKurulOnayi->where('user_id', auth()->user()->id)->where("form_id", $form->id)->first();

        $currentUserApproval->onay_durumu = $decide;
        $currentUserApproval->decide_reason = $decide_reason;
        $currentUserApproval->save();
        $ccRecipients = User::pluck('email')->toArray();

        if ($decide === "duzeltme" || $decide === "reddedildi") {
//DUZELTME VEYA RED
            $form->stage = $decide;
            $form->decide_reason = $decide_reason;
            $form->save();
            $researcherEmail = $form->researcher_informations->email;


            // Use the Mail facade to send an email
            Mail::send('emails.form-declined', ['decide_reason' => $decide_reason], function ($message) use ($researcherEmail, $ccRecipients) {
                // Set the recipient's email address and name
                $message->to($researcherEmail)
                    ->subject('Etik Kurulu Başvurunuz Reddedildi')->cc($ccRecipients);
            });
            $form->delete();
        } else {
            if ($etikKurulOnayi->whereNotIn('onay_durumu', ['bekleme', 'duzeltme', 'reddedildi'])->count() === $etikKurulOnayi->count()) {
//ONAYLANMA DURUMU
                $form->stage = 'onaylandi';
                $form->save();
                $researcherEmail = $form->researcher_informations->email;

                Mail::send('emails.form-etik-approved', ['decide_reason' => $decide_reason], function ($message) use ($researcherEmail, $ccRecipients) {
                    $message->to($researcherEmail)
                        ->cc($ccRecipients) // Add CC recipients
                        ->subject('Etik kurulu başvurunuz onaylandı.');
                });
            }
        }
    }

    public function generateQueryStageForm($studentNo)
    {
        try {
            $form = Form::select('forms.created_at', 'forms.stage') // Include 'forms.stage' in the select statement
                ->join('research_informations', 'forms.id', '=', 'research_informations.form_id')
                ->join('researcher_informations', 'forms.id', '=', 'researcher_informations.form_id')
                ->where('researcher_informations.student_no', $studentNo)
                ->select(
                    'forms.created_at',
                    'forms.stage', // Include 'forms.stage' here
                    'research_informations.research_title',
                    'researcher_informations.name',
                    'researcher_informations.lastname',
                    'researcher_informations.major',
                    'researcher_informations.department'
                )
                ->first();


            return view('forms.display-querystage', compact('form'));
        } catch (\Exception $e) {
            return response()->view('errors.500', ['error' => $e->getMessage()], 500);
        }
    }
}
