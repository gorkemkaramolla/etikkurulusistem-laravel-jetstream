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
        // Check if the 'onaylandi' parameter is present in the query string
        $whichForms = request()->query('onaylandi');

        if ($whichForms === null) {
            $forms = Form::with([
                'research_informations',
                'application_informations',
                'researcher_informations',
                'etik_kurul_onayi'
            ])
                ->where('stage', Auth::user()->role)
                ->get();
        } elseif ($whichForms === "true") {
            $forms = Form::with([
                'research_informations',
                'application_informations',
                'researcher_informations',
                'etik_kurul_onayi'
            ])
                ->where('stage', 'onaylandi')
                ->get();
        }

        // Check the 'access-dashboard' gate before showing the dashboard
        if (Gate::allows('access-dashboard')) {
            return view('dashboard', compact('forms'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }


    public function getFormSlug($studentNo, $formattedDate)
    {
        try {
            // Separate the formatted date into its components
            $createdAt = \Carbon\Carbon::createFromFormat('d-m-Y-His', $formattedDate);
    
            $forms = Form::with(['research_informations', 'application_informations', 'researcher_informations'])
                ->where('stage', Auth::user()->role)
                ->join('researcher_informations', 'forms.id', '=', 'researcher_informations.form_id')
                ->where('researcher_informations.student_no', $studentNo)
                ->where('forms.created_at', '=', $createdAt)  // Explicitly specify the table for created_at
                ->get();
    
            if ($forms->isEmpty()) {
                abort(404, 'Forms not found.');
            }
    
            // Format the created_at date for the URL
            $formattedDate = urlencode($forms->first()->created_at->format('Ymd-His'));
    
            // Generate the URL using student_no and formatted created_at
            $url = "/forms/{$forms->first()->researcher_informations->student_no}/{$formattedDate}";
    
            // Check the 'access-dashboard' gate before showing the dashboard
            if (Gate::allows('access-dashboard')) {
                return view('forms.display-form', compact('forms', 'url'));
            } else {
                abort(403, 'Unauthorized action.');
            }
        } catch (\Exception $e) {
            // Handle the exception here
            // You can log the error, redirect the user, or display a custom error page
            return response()->view('errors.500', ['error' => $e->getMessage()], 500);
        }
    }
    
}