<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\AdminFeaturesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnumController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Admin ve Etik Kurul üyelerine açık olan api routeları
    // Admin and Etik Kurul members' routes
    Route::middleware('CheckUserEtikKurulMember')->group(function () {
        Route::post('/send-email', [EmailController::class, 'handleSendEmail']);
        Route::controller(AdminFeaturesController::class)->group(function () {
            Route::post('/edit-user/{userId}', 'editUser');
            Route::post('/add-new-user', 'addNewUser');
            Route::post('/set-user-status/{status}/{user_id}', 'setUserStatus');
            Route::get('/getUsers/{userRole}',  'getUsers')->name('adminfeatures.getUsers');
        });

        Route::controller(EnumController::class)->group(function () {
            Route::post('/enums',  [EnumController::class, 'store']);
            Route::delete('/enums', [EnumController::class, 'destroy']);
        });
        Route::controller(FormsController::class)->group(function () {
            Route::get('/user/{user_id}/pending-approval-forms',  'getPendingApprovalFormIdsByUserId');
            Route::post('/approve-sekreterlik/{formid}',  'approveSekreterlik');
            Route::post('/approve-etikkurul/{formid}',  'approveEtikkurul');
            Route::delete('/delete-form/{formid}',  'deleteFormById');
            Route::post('/restore-form/{formIds}',  'restoreFormById');
            Route::get('/getEtikKuruluOnayiByFormId/{id}',  'getEtikKuruluOnayiByFormId');
        });
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dil-degistir', [DashboardController::class, 'changeLanguageToTurkish']);
            Route::get('/pdf/{slug}', [DashboardController::class, 'generatePdf']);
        });
    });
    /*
        Başvuru yapanlara açık olan api routeları (Giriş Yapmış Üyeler)
        Public routes for applicants (Logged in users)

    */
    Route::controller(FormsController::class)->group(function () {
        Route::post('store-form/{formId?}',  'store');
        Route::post('/fix-form/{formId}',  'fixForm');
    });
});
