<?php

namespace App\Http\Controllers;

use App\Models\Forms;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index()
    {
        // Fetch $forms directly in this controller
        $forms = Forms::where('stage', Auth::user()->role)
        ->select("id") // Replace with the actual column names you want
        ->get();

        

        // Check the 'access-dashboard' gate before showing the dashboard
        if (Gate::allows('access-dashboard')) {
            return view('dashboard', compact('forms'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
