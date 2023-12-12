<?php

namespace App\Http\Controllers;
use App\Models\Form;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index()
    {
        $forms = Form::with(['research_informations',"application_informations","researcher_informations"])
        ->where('stage', Auth::user()->role)
        ->select("*") // Replace with the actual column names you want
        ->get();

        // Check the 'access-dashboard' gate before showing the dashboard
        if (Gate::allows('access-dashboard')) {
            return view('dashboard', compact('forms'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    
    public function getFormSlug($slug)
    {
        $forms = Form::with(['research_informations',"application_informations","researcher_informations"])
        ->where('stage', Auth::user()->role)->where('id', $slug)
        ->select("*") // Replace with the actual column names you want
        ->get();


        // Check the 'access-dashboard' gate before showing the dashboard
        if (Gate::allows('access-dashboard')) {
            return view('forms.display-form', compact(['forms',"slug"]));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
