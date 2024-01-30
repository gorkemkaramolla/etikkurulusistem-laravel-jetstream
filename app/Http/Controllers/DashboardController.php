<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\LOG;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index($formStatus = null)
    {
        if ($formStatus === "duzeltme") {
            $forms = Form::all()->where('stage', "duzeltme");
        } else if ($formStatus === "reddedildi") {
            $forms = Form::all()->where('stage', "reddedildi");
        } else if (Auth::user()->role === "admin") {
            $forms = Form::with('etik_kurul_onayi')->get();
        } else if (auth()->user()->role === "sekreterlik") {
            $forms = Form::where('stage', '!=', 'etik_kurul')->get();
        } else if (auth()->user()->role === "etik_kurul") {
            $forms = Form::where('stage', '!=', 'sekreterlik')->get();
        } else {
        }


        // Check the 'access-dashboard' gate before showing the dashboard
        if (Gate::allows('access-dashboard')) {
            // return view('dashboard', compact('forms'));
            if (Auth::user()->role === "student" || Auth::user()->role === "academic") {
                $forms = Form::where('user_id', Auth::user()->id)->get();
                return view('student_dashboard', compact('forms'));
            } else if (Auth::user()->role === "admin") {


                return view('admin_dashboard', compact('forms'));
            } else {
                return view('dashboard', compact('forms'));
            }
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
    public function getFormSlug($formid)
    {
        try {
            $form = Form::where("id", $formid)
                ->first();

            $url = "/formshow/{$form->id}";

            // Check the 'access-dashboard' gate before showing the dashboard
            if (Gate::allows('access-dashboard')) {
                return view('forms.display-form', compact('form', 'url'));
            } else {
                abort(403, 'Unauthorized action.');
            }
        } catch (\Exception $e) {
            // Handle the exception here
            // You can log the error, redirect the user, or display a custom error page
            Log::error('Form creation failed: ' . $e->getMessage() . ' Stack trace: ' . $e->getTraceAsString());

            return response()->view('errors.500', ['error' => $e->getMessage()], 500);
        }
    }
}
