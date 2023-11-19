<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Models\Form;

class FormController extends Controller
{
    public function index()
    {
        $form = Form::all();
        return view('form.index', compact('form'));

    }

  
    public function create()
    {
        return view('form.create');
    }

    
    public function store(StoreFormRequest $request)
    {
        Form::create($request->validated());
 
        return redirect()->route('form.index');
    }

   
    public function show(Form $form)
    {
    }

    public function edit(Form $form)
    {
        return view('form.edit', compact('form'));
    }

   
    public function update(UpdateFormRequest $request, Form $form)
    {
        $form->update($request->validated());
 
        return redirect()->route('form.index');
    }
   
    public function destroy(Form $form)
    {
        $form->delete();
 
        return redirect()->route('form.index');
    }
}
