<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\AdminFeaturesController;
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
    Route::middleware('CheckUserEtikKurulMember')->group(function () {
        Route::post('/send-email', [EmailController::class, 'handleSendEmail']);
        Route::post('/edit-user/{userId}', [AdminFeaturesController::class, 'editUser'])->name('adminfeatures.editUser');
        Route::post('/add-new-user', [AdminFeaturesController::class, 'addNewUser'])->name('adminfeatures.addNewUser');
    });
});
