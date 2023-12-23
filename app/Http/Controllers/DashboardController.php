<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\LOG;

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


    public function getFormSlug($studentNo)
    {
        try {
            $form = Form::with([
                'research_informations',
                'application_informations',
                'researcher_informations',
            ])
                ->where('stage', Auth::user()->role)
                ->whereHas('researcher_informations', function ($query) use ($studentNo) {
                    $query->where('student_no', $studentNo);
                })
                ->first();


            // Format the created_at date for the URL

            // Generate the URL using student_no and formatted created_at
            $url = "/formshow/{$form->researcher_informations->student_no}";

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
