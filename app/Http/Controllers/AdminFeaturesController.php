<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\NewUserAdded;
use Illuminate\Support\Facades\Validator;

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
                return response()->json(['success' => 'Kullanıcı başarıyla silindi.'], 200);
            } else {
                return response()->json(['error' => 'Kullanıcı bulunamadı.'], 404);
            }
        } else {
            return response()->json(['error' => 'Bu işlemi yapmaya yetkiniz yok.'], 401);
        }
    }
    public function addNewUser(Request $request)
    {
        // Check if the user is an admin
        if (!auth()->user()->role === "admin") {
            return response()->json(['error' => 'Bu işlemi yapmaya yetkiniz yok.'], 401);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'role' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
        ], [
            'required' => ':attribute alanı gereklidir.',
            'max' => ':attribute alanı en fazla :max karakter olabilir.',
            'unique' => ':attribute alanı zaten kayıtlı.',
            'min' => ':attribute alanı en az :min karakter olmalıdır.',
            'email' => ':attribute alanı geçerli bir e-posta adresi olmalıdır.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Create the user
        $user = User::create([
            "name" => $request['name'],
            "lastname" => $request['lastname'],
            "username" => $request['username'],
            "role" => $request['role'],
            "email" => $request['email'],
            "password" => bcrypt($request['password']),
        ]);
        event(new NewUserAdded($user));
        return response()->json(['success' => 'Kullanıcı başarıyla oluşturuldu'], 200);
    }
}