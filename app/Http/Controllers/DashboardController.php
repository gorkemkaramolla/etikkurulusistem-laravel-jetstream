<?php

namespace App\Http\Controllers;

use App\Models\Forms;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch $forms directly in this controller
        $forms = Forms::all(); // Adjust the query based on your database structure

        // Check the 'access-dashboard' gate before showing the dashboard
        if (Gate::allows('access-dashboard')) {
            return view('dashboard', compact('forms'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
