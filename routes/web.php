<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\DatabaseSeedController;

use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppliedFormController;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/forms/{student_no}/{created_at}', [DashboardController::class, 'getFormSlug'])->name('forms.get');

    Route::get('/approve-sekreterlik/{formid}', [FormsController::class, 'approveSekreterlik'])->name('approve.sekreterlik');
    Route::post('/approve-etikkurul/{formid}', [FormsController::class, 'approveEtikkurul'])->name('approve.etikkurul');

    Route::get('/dil-degistir', [DashboardController::class, 'changeLanguageToTurkish']);



    Route::post('/forms/approve/{formid}', [FormsController::class, 'approveSekreterlik']);
    Route::get('/pdf/{slug}', [DashboardController::class, 'generatePdf']);
});
Route::get('/form', [FormsController::class, 'index'])->name('forms.index');
Route::view('/', 'root.index')->name('root.index');

Route::post('store-form', [FormsController::class, 'store']);
Route::get('/seed-database', [DatabaseSeedController::class, 'seed']);