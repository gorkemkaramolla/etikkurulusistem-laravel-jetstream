<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\NewUserAdded;
use App\Events\UserInActivated;
use Illuminate\Support\Facades\Validator;

class AdminFeaturesController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == "admin") {
            $users = User::select('id', 'name', "lastname", 'email', "username", "role", "is_user_active")->get(); // Specify the fields you want

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
    public function setUserStatus($status, $user_id)
    {
        if (auth()->user()->role == "admin") {
            $user = User::find($user_id);
            if ($user) {
                if ($status === "inactivate") {
                    $user->is_user_active = 0;
                    $user->save();
                    event(new UserInActivated($user));
                } else {
                    $user->is_user_active = 1;
                    $user->save();
                }
                $status === 'activate' ? 'aktif' : 'inaktif';

                return response()->json(['success' => "ID'si $user->id olan kullanıcı {$status} edildi"], 200);
            } else {
                return response()->json(['error' => 'Kullanıcı bulunamadı.'], 404);
            }
        } else {
            return response()->json(['error' => 'Bu işlemi yapmaya yetkiniz yok.'], 401);
        }
    }
    public function editUser(Request $request, $userId)
    {
        // Check if the user is an admin
        if (!auth()->user()->role === "admin") {
            return response()->json(['error' => 'Bu işlemi yapmaya yetkiniz yok.'], 401);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'username' => 'max:255',
            'role' => 'required',
            'email' => 'required|email|max:255',
            "password" => "min:8",
        ], [
            'required' => ':attribute alanı gereklidir.',
            'max' => ':attribute alanı en fazla :max karakter olabilir.',
            'unique' => ':attribute alanı zaten kayıtlı.',
            'min' => ':attribute alanı en az :min karakter olmalıdır.',
            'email' => ':attribute alanı geçerli bir e-posta adresi olmalıdır.',
            "password.min" => "Şifre en az :min karakter olmalıdır.",
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode(' ', $errors);
            return response()->json([$errorMessage], 400);
        }
        // Update the user
        $user = User::find($userId);
        if ($user) {
            $user->name = $request['name'];
            $user->lastname = $request['lastname'];
            $user->username = $request['username'];
            $user->role = $request['role'];
            $user->email = $request['email'];
            $user->password = bcrypt($request['password']);
            $user->save();
            return response()->json(['success' => 'Kullanıcı başarıyla güncellendi.'], 200);
        } else {
            return response()->json(['error' => 'Kullanıcı bulunamadı.'], 404);
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
            "username" => $request['username'] === "" ? null : $request['username'],
            "role" => $request['role'],
            "email" => $request['email'],
            "password" => bcrypt($request['password']),
        ]);
        event(new NewUserAdded($user));
        return response()->json(['success' => 'Kullanıcı başarıyla oluşturuldu'], 200);
    }
}
