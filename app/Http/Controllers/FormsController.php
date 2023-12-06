<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormRequest;
use App\Mail\FormSubmitted;
use App\Models\ApplicationInformations;
use App\Models\ResearcherInformations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Forms;
use App\Models\User;
use App\Models\EtikKurulOnayi;
use App\Models\ResearchInformations;
use Illuminate\Support\Facades\Mail;

use Exception;

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
            echo $validated['document_number'];
            $form = new Forms();
            $form->name = trim($validated['document_number']);
            $form->email = trim($validated['email']);
            $form->save();
            // //create researcher informations
            // $researcher = new ResearcherInformations();
            // $researcher->form_id = $form->id;
            // $researcher->name = trim($validated['name']);
            // $researcher->lastname = trim($validated['lastname']);
            // $researcher->advisor = trim($validated['advisor']);
            // $researcher->gsm = trim($validated['gsm']);
            // $researcher->email = trim($validated['email']); 
            // $researcher->major = trim($validated['major']);
            // $researcher->department = trim($validated['department']);
            // $researcher->student_no = trim($validated['student_no']);
            // $researcher->save();
            // //create application informations
            // $applicationInfo = new ApplicationInformations();
            // $applicationInfo->form_id = $form->id;
            // $applicationInfo->application_semester = trim($validated['application_semester']);
            // $applicationInfo->temel_alan_bilgisi = trim($validated['temel_alan_bilgisi']);
            // $applicationInfo->academic_year = trim($validated['academic_year']);
            // $applicationInfo->application_type = trim($validated['application_type']);
            // $applicationInfo->work_qualification = trim($validated['work_qualification']); 
            // $applicationInfo->research_type = trim($validated['research_type']);
            // $applicationInfo->institution_permission = trim($validated['institution_permission']);
            // $applicationInfo->research_start_date = trim($validated['research_start_date']);
            // $applicationInfo->research_end_date = trim($validated['research_end_date']);
            // $applicationInfo->save();
            // //create research informations
            // $research = new ResearchInformations();
            // $research->form_id = $form->id;
            // $research->research_title = trim($validated['research_title']);
            // $research->research_subject_purpose = trim($validated['research_subject_purpose']);
            // $research->research_unique_value = trim($validated['research_unique_value']);
            // $research->research_hypothesis = trim($validated['research_hypothesis']);
            // $research->research_method = trim($validated['research_method']); 
            // $research->research_universe = trim($validated['research_universe']);
            // $research->research_forms = trim($validated['research_forms']);
            // $research->research_data_collection = trim($validated['research_data_collection']);
            // $research->research_restrictions = trim($validated['research_restrictions']);
            // $research->research_place_date = trim($validated['research_place_date']);
            // $research->research_literature_review = trim($validated['research_literature_review']);

            // $research->save();






            return redirect()->route('forms.index')->with('success', 'Başvurunuz alınmıştır. Bilgilendirme için e-posta adresinizi kontrol ediniz.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());

        }
    }
    public function approveForm($formid)
    {
        $form = Forms::find($formid);
        $this->startApprovalProcess($form);
        return redirect()->route('dashboard')->with('success', 'Redirected to the dashboard successfully.');

    }
    

    
    private function startApprovalProcess(Forms $form)
    {
        $form->stage="etik_kurul";
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
}