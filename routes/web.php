<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormsController;



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
        
    })->name('dashboard');
});
Route::get('forms', [FormsController::class, 'index'])->name('forms.index');

Route::post('store-form', [FormsController::class, 'store']);


