<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\DatabaseSeedController;
use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataVisualizationController;

use App\Http\Controllers\AppliedFormController;
use App\Http\Controllers\TestController;

use App\Http\Controllers\ExportController;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/visualize', [DataVisualizationController::class, 'index'])->name('visualize');

    Route::get('/formshow/{student_no}', [DashboardController::class, 'getFormSlug'])->name('forms.get');

    Route::get('/export-to-excel', 'YourController@exportToExcel')->name('export.to.excel');

    Route::get('export/array', [ExportController::class, 'array'])->name('export.array');


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





Route::get('/query-etikkurul/{student_no}', [FormsController::class, 'generateQueryStageForm'])->name('forms.get');

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
Route::get('/test', [TestController::class, 'index'])->name('test');
Route::get('/jwt', function () {

    $jwtToken = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjE0MDE1NjEiLCJzdWIiOiIxNDAxNTYxOjIzNCIsIm5hbWUiOiJHw5ZSS0VNIiwiZ2l2ZW5uYW1lIjoiMjAyMDIwMjIwNDMiLCJmYW1pbHluYW1lIjoiS0FSQU1PTExBIiwiZW1haWxhZGRyZXNzIjoiMjAyMDIwMjIwNDNAc3RkLm5pc2FudGFzaS5lZHUudHIiLCJpc3NpbXVsYXRlIjoiRmFsc2UiLCJSb2xlIjoiOCIsInBlcm1pc3Npb25fY29udGVudCI6InBRVUFBQitMQ0FBQUFBQUFBQU50MUVseXhEQUlCZEFMWmNId21Yei9nMFdlQTA1MUwxUzhCa3N5TklQWW5EZmVSTEhKOXNOWHdMR3hBN2JoamVYRzVPVHNheldEcHY4RmJRYlRqV1ZWdml0TmpIclFkR0x5aTlhd2t1b3N5MnlBZEt6TU9OR1ZvMlV5TVpBSFNsb21OenhxalNPc0ltNTBaS0FReUlhS1REdlFoTVRSTVJFM01nZDFMTWlEb0JobzlLSzI4NjJsQkc0TTdtV1JzQ3NUSHRWM2UxekhQRjhHOXArdmIrbDZybllzdjk1ZmdhcGZOQmRGMElVc3FJNzd6ZDJvcVFQVkhrU01USUhyalNudENMSzZ3WTlucnBVR1ZVZmV1L3JDekluNlpwYmFRQys3RUFRTVRNS0RQc3FLNUYwV1FuMjNsaWJIVVVSQ28zaWduMzI2NDdxdWppWFhobmJzVGJ3UVR5YWt2MlJ4VnNHRnBqRVJlQkRlM3VjNUVLTTlsT3grMXBwV0p3eTA0Z2Q3aCt1YTIzTTJkc3lLaWZWZ3piSU9wZ3VUZWtzcXhkcjNqY0I3YmV2enJQNW1uR003em5XTzZ5ZTRqK2szdU1iem42RE92NHB6SEVmd25KdFBjSitYYjNCMSsxcjlBcnVsKy9XbEJRQUEiLCJjdXN0b21fcGVybWlzc2lvbl9jb250ZW50IjoiQUFBQUFCK0xDQUFBQUFBQUFBTURBQUFBQUFBQUFBQUEiLCJvcmdhbml6YXRpb25faWQiOiIyMzQiLCJ1c2VyX3RpbWV6b25lIjoiIiwib3JnYW5pemF0aW9uX3RpbWV6b25lIjoiRXVyb3BlL01vc2NvdyIsImxvZ2luX2F1ZGl0X2lkIjoiMTAwMzM0ODQyIiwiY2x1X3R5cGUiOiI0IiwiY3VsdHVyZSI6ImVuLVVTIiwiZm9yY2VfY2hhbmdlX3Bhc3N3b3JkIjoiZmFsc2UiLCJ0cmFja2luZ19ndWlkIjoiZjI3NjM0OTAtOGJkOS00NWJhLTgwMjItYWJmNGU4ZGJmMDI4IiwiZXhwIjoxNzAzOTA2MTEwLCJpc3MiOiJodHRwczovL2FsbXNwLXByb2QtYXV0aC5hbG1zY2xvdWQuY29tLyIsImF1ZCI6Imh0dHBzOi8vYWxtc3AtcHJvZC1hdXRoLmFsbXNjbG91ZC5jb20vIn0.LYjzzSLdDW0jdFBcMmwih1F8NsupyxsDUlIwBlmNeYc";
    try {
        $decoded = JWTAuth::getPayload($jwtToken)->toArray();
        // $decoded is an associative array containing your payload data
        print_r($decoded);
    } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
        echo $e;
    } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
        echo $e;
    } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
        echo $e;
    }
});
