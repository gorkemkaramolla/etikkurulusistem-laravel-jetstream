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
        ->select('name', 'lastname', 'email',"ogrenci_no","created_at","path_basvuru_form","path_olcek_izinleri_form","path_anket_form"
        ,"path_gonullu_onam_form") // Replace with the actual column names you want
        ->get();

        

        // Check the 'access-dashboard' gate before showing the dashboard
        if (Gate::allows('access-dashboard')) {
            return view('dashboard', compact('forms'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
