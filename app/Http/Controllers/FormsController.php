<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Forms;

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

        $form = new Forms();
        $form->fill($request->all());
        $form->save();
        return redirect()->route('forms.index')->with('success', 'Form successfully stored.');

    }


   
 
}
