<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\Forms;
use Exception;

class FormsController extends Controller
{
    public function index()
    {
        $forms = Forms::all();
        return view('forms.index', compact('forms'));

    }

  
    public function create()
    {
        return view('forms.create');
    }

    
    public function store(Request $request)
    {
        try{
            $form = new Forms();
            $form->name = $request->input('name');
            $form->lastname = $request->input('lastname');
            $form->ogrenci_no = $request->input('ogrenci_no');
            $form->email = $request->input('email');
        
            $folderPath = 'public/forms/' . $form->ogrenci_no;
        
            $onamFormName = $form->ogrenci_no . '_onam_formu.pdf';
            $anketFormName = $form->ogrenci_no . '_anket_formu.pdf';
            $olcekIzinleriFormName = $form->ogrenci_no . '_olcek_izinleri_formu.pdf';
        
            // Handle file uploads and store them in the created folder with custom names
            $form->path_gonullu_onam_form = $request->file('path_gonullu_onam_form')->storeAs($folderPath, $onamFormName);
            $form->path_olcek_izinleri_form = $request->file('path_olcek_izinleri_form')->storeAs($folderPath, $olcekIzinleriFormName);
            $form->path_anket_form = $request->file('path_anket_form')->storeAs($folderPath, $anketFormName);
        
            $form->save();
        
            return redirect()->route('forms.index')->with('success', 'Form successfully stored.');
        }
        catch (Exception $e) {
            
            return redirect()->back()->with('error', 'Başvurunuz alınmıştır. Bilgilendirme için e-posta adresinizi kontrol ediniz.');
        }
    
    }
    


   
 
}
