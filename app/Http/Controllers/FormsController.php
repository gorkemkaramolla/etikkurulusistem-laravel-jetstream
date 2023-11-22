<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Forms;
use App\Models\User;
use App\Models\EtikKurulOnayi;

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
            // Validate the request data
            $validated = $request->validated();

            $form = new Forms();
            $form->name = trim($request->input('name'));
            $form->lastname = trim($request->input('lastname'));
            $form->ogrenci_no = trim($request->input('ogrenci_no'));
            $form->email = trim($request->input('email'));

            // Form folderı oluşturma
            $folderPath = 'public/forms/' . $form->ogrenci_no;
            Storage::makeDirectory($folderPath);

            // Dosya yükleme ve dosya yolları
            $onamFormName = $form->ogrenci_no . '_onam_formu.pdf';
            $anketFormName = $form->ogrenci_no . '_anket_formu.pdf';
            $olcekIzinleriFormName = $form->ogrenci_no . '_olcek_izinleri_formu.pdf';
            $basvuruFormName = $form->ogrenci_no . '_basvuru_formu.pdf';

            $form->path_basvuru_form = $request->file('path_gonullu_onam_form')->storeAs($folderPath, $basvuruFormName);
            $form->path_gonullu_onam_form = $request->file('path_gonullu_onam_form')->storeAs($folderPath, $onamFormName);
            $form->path_olcek_izinleri_form = $request->file('path_olcek_izinleri_form')->storeAs($folderPath, $olcekIzinleriFormName);
            $form->path_anket_form = $request->file('path_anket_form')->storeAs($folderPath, $anketFormName);

            $form->save();

            // Trigger the approval process
            $this->startApprovalProcess($form);

            return redirect()->route('forms.index')->with('success', 'Form successfully stored.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Başvurunuz alınmıştır. Bilgilendirme için e-posta adresinizi kontrol ediniz.');
        }
    }

    
    private function startApprovalProcess(Forms $form)
    {
  

        $etikKurulUyeler = User::where('role', 'etik_kurul')->get();

        foreach ($etikKurulUyeler as $etikKurulUye) {
            $etikKurulOnayi = new EtikKurulOnayi([
                'form_id' => $form->id,
                'user_  id' => $etikKurulUye->id,
                'onay_durumu' => 'bekleme', 
            ]);

            $etikKurulOnayi->save();
        }
    }
}