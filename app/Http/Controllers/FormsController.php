<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema; // Add this line

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


use Illuminate\Support\Facades\Validator;

class FormsController extends Controller
{
    public function index($formId = null)
    {
        // Check if a form ID is provided
        if ($formId) {
            // Retrieve form data based on $formId
            $formData = Form::findOrFail($formId);
            if ($formData->user_id != Auth::user()->id) {
                return redirect()->route('dashboard');
            }
            // Return the form view with data
            return view('forms.index')->with('formData', $formData);
        }

        // Regular form submission, return just the index view
        return view('forms.index');
    }



    public function fixForm($formId, Request $request)
    {
        if (auth::user()->role === "admin") {
            try {
                $form = Form::find($formId);

                if (!$form) {
                    return response()->json(['error' => 'Başvuru bulunamadı.'], 404);
                }

                $changes = $request->all(); // Get all the request data

                // Check if the changes are provided
                if (!$changes) {
                    return response()->json(['error' => 'Herhangi bir değişiklik yapmadınız.'], 400);
                }

                foreach ($changes as $columnName => $newValue) {
                    // Check if the column exists
                    if (!Schema::hasColumn('forms', $columnName)) {
                        return response()->json(['error' => 'Hatalı sütun: ' . $columnName], 400);
                    }

                    // Define validation rules for each column
                    $rules = [
                        'research_end_date' => 'date_format:Y-m-d',


                        // Add other columns and their validation rules here
                    ];
                    $messages = [
                        'research_end_date.date_format' => 'Tarih formatında girilmelidir (Yıl-Ay-Gün)',

                    ];
                    $validator = Validator::make([$columnName => $newValue], [$columnName => $rules[$columnName] ?? ''], $messages);


                    if ($validator->fails()) {
                        throw new Exception($validator->errors()->first());
                    }

                    $form->$columnName = $newValue;
                }

                $form->save();

                return response()->json(['success' => 'Değişiklikler başarıyla kaydedildi.']);
            } catch (Exception $e) {
                Log::error('fixForm function hatası: ' . $e->getMessage() . ' Stack trace: ' . $e->getTraceAsString());

                return response()->json(['error' => $e->getMessage()], 400);
            }
        } else {
            return response()->json(['error' => "yetkisiz"], 401);
        }
    }
    // /FORMS SUBMIT REQUEST CONTROLLER
    public function store(StoreFormRequest $request, $formid = null)
    {

        try {
            DB::beginTransaction();

            $validated = $request->validated();
            // Create form
            if ($formid) {
                $form = Form::find($formid);

                $form->is_modified = true;
            } else {
                $form = new Form();
                // Create a directory based on the researcher's student number
            }



            if ($form->stage === 'duzeltme') {

                $form->stage = 'sekreterlik';
                $form->application_type = "duzeltme";
            }
            $form->user_id = Auth::user()->id;
            $form->name = trim($validated['name']);
            $form->lastname = trim($validated['lastname']);
            $form->advisor = trim($validated['advisor']);
            $form->gsm = trim($validated['gsm']);
            $form->email = trim($validated['email']);
            $form->ana_bilim_dali = trim($validated['ana_bilim_dali']);
            $form->program = trim($validated['program']);
            $form->student_no = trim($validated['student_no']);
            // //create application informations
            $form->application_semester = $validated['application_semester'];
            $form->temel_alan_bilgisi = trim($validated['temel_alan_bilgisi']);
            $form->academic_year = trim($validated['academic_year']);
            $form->application_type = trim($validated['application_type']);
            $form->work_qualification = trim($validated['work_qualification']);
            $form->research_type = trim($validated['research_type']);
            $form->institution_permission = trim($validated['institution_permission']);
            $form->research_end_date = $validated['research_end_date'];
            $form->research_start_date = $validated['research_start_date'];
            //create research informations
            $form->research_title = trim($validated['research_title']);
            $form->research_subject_purpose = trim($validated['research_subject_purpose']);
            $form->research_unique_value = trim($validated['research_unique_value']);
            $form->research_hypothesis = trim($validated['research_hypothesis']);
            $form->research_method = trim($validated['research_method']);
            $form->research_universe = trim($validated['research_universe']);
            $form->research_forms = trim($validated['research_forms']);
            $form->research_data_collection = trim($validated['research_data_collection']);
            $form->research_restrictions = trim($validated['research_restrictions']);
            $form->research_place_date = trim($validated['research_place_date']);
            $form->research_literature_review = trim($validated['research_literature_review']);
            $form->save();
            $directory = "public/forms/" . Auth::user()->username . "/{$form->id}";


            // Create the directory with 755 permissions if it doesn't exist
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory, 0755, true);
                // Explicitly set the permissions for the created directory
                chmod(storage_path("app/{$directory}"), 0755);
            } else if ($formid) {
                // If the form already exists, delete the existing files
                $pathsToDelete = array_filter([$form->onam_path, $form->anket_path, $form->kurum_izinleri_path]);
                Storage::delete($pathsToDelete);
            }

            $form->onam_path = Storage::putFileAs($directory, $validated["onam_path"], "{$validated['student_no']}_onam.pdf", 'public');
            $form->anket_path = Storage::putFileAs($directory, $validated["anket_path"], "{$validated['student_no']}_anket.pdf", 'public');

            // Check if 'kurum_izinleri_path' is present and not empty before attempting to save it
            if ($request->hasFile('kurum_izinleri_path') && $request->file('kurum_izinleri_path')->isValid()) {
                $form->kurum_izinleri_path = Storage::putFileAs($directory, $validated["kurum_izinleri_path"], "{$validated['student_no']}_kurum_izinleri.pdf", 'public');
            }
            $form->save();

            DB::commit();


            try {
                $sekreterlikRecipients = User::where('role', 'sekreterlik')->pluck('email')->toArray();
                $emailMessageTr = config('email-messages.confirmation.tr');
                $emailMessageEn = config('email-messages.confirmation.en');

                Mail::send('emails.generic', ['emailMessageTr' => $emailMessageTr, 'emailMessageEn' => $emailMessageEn], function ($message) use ($form, $sekreterlikRecipients) {
                    $message->to($form->email, $form->name . ' ' . $form->lastname)
                        ->subject('Başvurunuz tarafımıza ulaşmıştır.');
                });
            } catch (\Exception $e) {
                Log::error('Email sending failed: ' . $e->getMessage());
            }
            $linkPath = "/query-etikkurul/{$form->student_no}";
            $successMessage = 'Başvurunuz alınmıştır. Bilgilendirme için e-posta adresinizi kontrol ediniz. Kısa süre içerisinde anasayfaya yönlendirileceksiniz.';

            return redirect()->route('forms.index')->with('successMessage', $successMessage)->with('linkPath', $linkPath);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Store Form Hatası: ' . $e->getMessage() . ' Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()->withErrors($validated)->withInput();
        }
    }

    public function approveSekreterlik($formid, Request $request)
    {
        try {
            $form = Form::find($formid);
            $decide_reason = $request->input('decide_reason');
            $decide = $request->input('decide');

            $this->startSekreterlikApprovalProcess($form, $decide, $decide_reason);
            return redirect()->route('dashboard')->with('success', 'Talebiniz Başarıyla Onaylandı.');
        } catch (\Exception $e) {
            Log::error('approveSekreterlik function hatası: ' . $e->getMessage() . ' Stack trace: ' . $e->getTraceAsString());
        }
    }

    private function startSekreterlikApprovalProcess(Form $form, $decide, $decide_reason)
    {
        try {
            //SEKRETER ONAY DURUMU
            if ($decide === "onaylandi") {
                if ($form->etik_kurul_onayi) {
                    $form->etik_kurul_onayi()->delete();
                }
                $form->stage = "etik_kurul";

                $form->save();

                $etikKurulUyeler = User::where('role', 'etik_kurul')->where('is_user_active', 1)->get();
                foreach ($etikKurulUyeler as $etikKurulUye) {
                    $etikKurulOnayi = new EtikKurulOnayi([
                        'form_id' => $form->id,
                        'user_id' => $etikKurulUye->id,
                        'onay_durumu' => 'bekleme',
                    ]);

                    $etikKurulOnayi->save();
                }
                try {
                    $etikKurulRecipients = User::where('role', 'etik_kurul')->pluck('email')->toArray();
                    $emailMessageTr = config('email-messages.approved-sekreterlik.tr');
                    $emailMessageEn = config('email-messages.approved-sekreterlik.en');

                    $researcherEmail = $form->email;
                    Mail::send('emails.generic', ['emailMessageTr' => $emailMessageTr, 'emailMessageEn' => $emailMessageEn], function ($message) use ($researcherEmail, $etikKurulRecipients) {
                        $message->to($researcherEmail)
                            ->subject('Başvurunuz Sekreterlik Tarafından Onaylanmıştır.');
                    });
                } catch (Exception $e) {
                    Log::error('Mail sending failed', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                }
            } else if ($decide === "duzeltme") {
                $ccRecipients = User::pluck('email')->toArray();
                //SEKRETER DUZELTME
                $form->stage = "duzeltme";
                $form->decide_reason = $decide_reason;
                $form->save();
                $researcherEmail = $form->email;

                $fixMessageTr = config('email-messages.fix.tr');
                $fixMessageEn = config('email-messages.fix.en');

                $decideReason = $form->decide_reason;

                $messageTr = $fixMessageTr . ' ' . $decideReason;
                $messageEn = $fixMessageEn . ' ' . $decideReason;

                Mail::send('emails.generic', ['messageTr' => $messageTr, 'messageEn' => $messageEn], function ($message) use ($researcherEmail, $ccRecipients) {
                    $message->to($researcherEmail)
                        ->subject('Başvurunuz Sekreterlik tarafından düzeltme aşamasına geçmiştir.');
                });
            }
        } catch (Exception $e) {
            Log::error('startSekreterlikApprovalProcess function hatası: ' . $e->getMessage() . ' Stack trace: ' . $e->getTraceAsString());
        }
    }
    public function approveEtikkurul($formid, Request $request)
    {
        $form = Form::find($formid);
        $decide_reason = $request->input('decide_reason');
        $decide = $request->input('decide');


        // Use $decide_reason as needed in your approval process
        $this->startEtikkurulApprovalProcess($form, $decide, $decide_reason);

        return redirect()->route('dashboard')->with('success', 'Talebiniz Başarıyla Onaylandı.');
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
            $form->stage = $decide;
            $form->decide_reason = $decide_reason;
            $form->conclusion_date = now();
            $form->save();

            $decideReason = $form->decide_reason;

            if ($decide == 'duzeltme') {
                $emailMessageTr = config('email-messages.fix.tr') . ' ' .  $decideReason;
                $emailMessageEn = config('email-messages.fix.en') . ' ' .  $decideReason;
                $subject = 'Etik Kurul başvurunuzu düzeltmeniz gerekmektedir.';
            } else if ($decide == 'reddedildi') {
                $emailMessageTr = config('email-messages.declined.tr') . ' ' .  $decideReason;
                $emailMessageEn = config('email-messages.declined.en') . ' ' .  $decideReason;
                $subject = 'Etik Kurulu Başvurunuz Reddedildi';
            }

            try {
                $researcherEmail = $form->email;
                Mail::send('emails.generic', ['emailMessageTr' => $emailMessageTr, 'emailMessageEn' => $emailMessageEn], function ($message) use ($researcherEmail, $ccRecipients, $subject) {
                    $message->to($researcherEmail)
                        ->subject($subject);
                });
            } catch (Exception $e) {
                Log::error('Mail sending failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        } else {
            if ($etikKurulOnayi->whereNotIn('onay_durumu', ['bekleme', 'duzeltme', 'reddedildi'])->count() === $etikKurulOnayi->count()) {
                //ONAYLANMA DURUMU
                $form->stage = 'onaylandi';
                $form->conclusion_date = now();


                $form->save();
                try {
                    $researcherEmail = $form->email;
                    $emailMessageTr = config('email-messages.approved-etikkurul.tr');
                    $emailMessageEn = config('email-messages.approved-etikkurul.en');

                    Mail::send('emails.generic', ['emailMessageTr' => $emailMessageTr, 'emailMessageEn' => $emailMessageEn], function ($message) use ($researcherEmail, $ccRecipients) {
                        $message->to($researcherEmail)
                            ->subject('Etik kurulu başvurunuz onaylandı.');
                    });
                } catch (Exception $e) {
                    Log::error('Mail sending failed', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                }
            }
        }
    }
    public function getEtikKuruluOnayiByFormId($formId)
    {
        try {
            $form = Form::with('etik_kurul_onayi')->where("id", $formId)->first();

            if (!$form) {
                return response()->json(['error' => 'Başvuru bulunamadı.'], 404);
            }

            $etikKurulOnaylari = $form->etik_kurul_onayi;

            if (!$etikKurulOnaylari) {
                return response()->json(['error' => 'Etik kurul onayı bulunamadı.'], 404);
            }

            $response = [];

            foreach ($etikKurulOnaylari as $etikKurulOnayi) {
                $user = User::find($etikKurulOnayi->user_id);

                if (!$user) {
                    return response()->json(['error' => 'Kullanıcı bulunamadı'], 404);
                }

                $response[] = [
                    "user_id" => $etikKurulOnayi->user_id,
                    "form_id" => $etikKurulOnayi->form_id,
                    'username' => $user->name,
                    'lastname' => $user->lastname,
                    'onay_durumu' => $etikKurulOnayi->onay_durumu,
                    'decide_reason' => $etikKurulOnayi->decide_reason
                ];
            }

            return response()->json($response);
        } catch (Exception $e) {
            Log::error('getEtikKuruluOnayiByFormId function hatası: ' . $e->getMessage() . ' Stack trace: ' . $e->getTraceAsString());

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getPendingApprovalFormIdsByUserId($user_id)
    {
        try {
            $userEtikKurulOnaylari = EtikKurulOnayi::all();
            $formIds = $userEtikKurulOnaylari->pluck('form_id')->unique();

            Log::error($userEtikKurulOnaylari);

            $waitingForApproval = [];

            foreach ($formIds as $formId) {
                $formOnaylari = $userEtikKurulOnaylari->where('form_id', $formId);

                $currentUserOnay = $formOnaylari->where('user_id', $user_id)->first();
                $otherUsersOnay = $formOnaylari->where('user_id', '!=', $user_id);

                if (
                    $currentUserOnay && $currentUserOnay->onay_durumu == 'bekleme' &&
                    $otherUsersOnay->whereIn('onay_durumu', ['reddedildi', 'duzeltme'])->count() == 0
                ) {
                    $waitingForApproval[] = $formId;
                }
            }
            return response()->json($waitingForApproval);
        } catch (Exception $e) {
            Log::error('getEtikKuruluOnayiByUserId function hatası: ' . $e->getMessage() . ' Stack trace: ' . $e->getTraceAsString());

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function deleteFormById($formIds)
    {
        try {
            $formIds = explode(',', $formIds);
            $user = auth()->user();

            if ($user && $user->role === 'admin') {
                $forms = Form::whereIn('id', $formIds)->get();

                if (!$forms->isEmpty()) {
                    Form::destroy($formIds);

                    return redirect()->route('dashboard')->with('success', 'Başvurular başarıyla silindi.');
                } else {
                    return redirect()->route('dashboard')->with('error', 'Başvuru bulunamadı.');
                }
            } else {
                return redirect()->route('dashboard')->with('error', 'Bu işlemi yapmaya yetkiniz yok.');
            }
        } catch (Exception $e) {
            Log::error('deleteFormById function hatası: ' . $e->getMessage() . ' Stack trace: ' . $e->getTraceAsString());
        }
    }
    public function generateQueryStageForm($formid)
    {
        try {
            $form = Form::where('id', $formid)->first();
            if ($form)
                return view('forms.display-querystage', compact('form'));
            else {
                abort(404);
            }
        } catch (Exception $e) {
            Log::error('generateQueryStageForm function hatası: ' . $e->getMessage() . ' Stack trace: ' . $e->getTraceAsString());
        }
    }
}
