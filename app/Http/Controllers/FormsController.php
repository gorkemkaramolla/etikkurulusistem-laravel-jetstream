<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormRequest;
use App\Mail\FormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Forms;
use App\Models\User;
use App\Models\EtikKurulOnayi;
use Illuminate\Support\Facades\Mail;

use Exception;

class FormsController extends Controller
{
    public function index()
    {
        return view('forms.index');
    }

    public function store(Request $request)
    {

        try {
            // Validate the request data
            // $validated = $request->validated();

            // $form = new Forms();
            // $form->name = trim($request->input('name'));
            // $form->lastname = trim($request->input('lastname'));
            // $form->ogrenci_no = trim($request->input('ogrenci_no'));
            // $form->email = trim($request->input('email'));
            // // Form folderı oluşturma
            // $folderPath = 'public/forms/' . $form->ogrenci_no;
            // Storage::makeDirectory($folderPath);
            // Storage::setVisibility($folderPath, 'public');
            // // Dosya yükleme ve dosya yolları
            // $onamFormName = $form->ogrenci_no . '_onam_formu.pdf';
            // $anketFormName = $form->ogrenci_no . '_anket_formu.pdf';
            // $olcekIzinleriFormName = $form->ogrenci_no . '_olcek_izinleri_formu.pdf';
            // $basvuruFormName = $form->ogrenci_no . '_basvuru_formu.pdf';

            // $form->path_basvuru_form = $request->file('path_gonullu_onam_form')->storeAs($folderPath, $basvuruFormName);
            // $form->path_gonullu_onam_form = $request->file('path_gonullu_onam_form')->storeAs($folderPath, $onamFormName);
            // $form->path_olcek_izinleri_form = $request->file('path_olcek_izinleri_form')->storeAs($folderPath, $olcekIzinleriFormName);
            // $form->path_anket_form = $request->file('path_anket_form')->storeAs($folderPath, $anketFormName);
            // // Mail::to($form->email)->send(new FormSubmitted());

            // $form->save();
            echo $request->input('lastname');


            // return redirect()->route('forms.index')->with('success', 'Başvurunuz alınmıştır. Bilgilendirme için e-posta adresinizi kontrol ediniz.');
        } catch (Exception $e) {
            // return redirect()->back()->with('error', $e->getMessage());

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