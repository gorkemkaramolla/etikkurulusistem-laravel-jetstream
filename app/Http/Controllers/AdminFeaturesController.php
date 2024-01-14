<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use Illuminate\Http\Request;

class AdminFeaturesController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('adminfeatures.index', compact('users'));
    }
    public function getUsers($userRole)
    {
        if (auth()->user()->role == "admin") {
            $users = User::where("role", "$userRole")->get();

            return response()->json($users);
        }
    }
}
