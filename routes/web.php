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

    Route::get('/formshow/{student_no}', [DashboardController::class, 'getFormSlug'])->name('forms.get');




    Route::post('/approve-sekreterlik/{formid}', [FormsController::class, 'approveSekreterlik'])->name('approve.sekreterlik');
    Route::post('/approve-etikkurul/{formid}', [FormsController::class, 'approveEtikkurul'])->name('approve.etikkurul');

    Route::get('/dil-degistir', [DashboardController::class, 'changeLanguageToTurkish']);


    Route::get('/show-pdf/{path}', function ($path) {
        $filePath = base_path("storage/app/{$path}");

        if (file_exists($filePath)) {
            return response()->file($filePath);
        } else {
            abort(404, 'File not found');
        }
    })->where('path', '.*');

    Route::post('/forms/approve/{formid}', [FormsController::class, 'approveSekreterlik']);
    Route::get('/pdf/{slug}', [DashboardController::class, 'generatePdf']);
});
Route::get('/form', [FormsController::class, 'index'])->name('forms.index');
Route::view('/', 'root.index')->name('root.index');

Route::post('store-form', [FormsController::class, 'store']);
Route::get('/seed-database', [DatabaseSeedController::class, 'seed']);
Route::get('generate', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
});
Route::get('migrate', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed');

    echo 'ok';
});
