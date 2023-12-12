<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormsController;

use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppliedFormController;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/forms/{slug}', [DashboardController::class, 'getFormSlug'],)->name('forms.get');

    Route::post('/forms/approve/{formid}', [FormsController::class, 'approveForm']);
    Route::get('/pdf/{slug}', [DashboardController::class, 'generatePdf']);

});
Route::get('/', [FormsController::class, 'index'])->name('forms.index');

Route::post('store-form', [FormsController::class, 'store']);

