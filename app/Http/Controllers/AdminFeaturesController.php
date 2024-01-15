<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\NewUserAdded;

class AdminFeaturesController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == "admin") {
            $users = User::all();

            return view('adminfeatures.index', compact('users'));
        }
    }
    public function getUsers($userRole)
    {
        if (auth()->user()->role == "admin") {
            $users = User::where("role", "$userRole")->get();

            return response()->json($users);
        }
    }
    public function deleteUser($user_id)
    {
        if (auth()->user()->role == "admin") {
            $user = User::find($user_id);
            if ($user) {
                $user->delete();
                return response()->json(['success' => 'User deleted successfully'], 200);
            } else {
                return response()->json(['error' => 'User not found'], 404);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    public function addNewUser(Request $request)
    {
        // Check if the user is an admin
        if (!auth()->user()->role === "admin") {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'role' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
        ]);

        // Create the user
        $user = User::create([
            "name" => $validatedData['name'],
            "lastname" => $validatedData['lastname'],
            "username" => $validatedData['username'],
            "role" => $validatedData['role'],
            "email" => $validatedData['email'],
            "password" => bcrypt($validatedData['password']),
        ]);
        event(new NewUserAdded($user));
        return response()->json(['success' => 'Kullanıcı başarıyla oluşturuldu'], 200);
    }
}
