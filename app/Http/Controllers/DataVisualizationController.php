<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DataVisualizationController extends Controller
{
    public function index()
    {
        $forms = Form::all();

        if (Gate::allows('access-dashboard')) {

            // return view('dashboard', compact('forms'));
            if (Auth::user()->role === "student" || Auth::user()->role === "academic") {
                abort(403, 'Unauthorized action.');
            } else {
                return view("visualize.index", compact('forms'));
            }
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
