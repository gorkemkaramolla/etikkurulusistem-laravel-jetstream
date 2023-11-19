<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
        
    })->name('dashboard');
});
Route::resource('form', FormController::class)->middleware(['web']);


