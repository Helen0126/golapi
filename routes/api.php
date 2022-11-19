<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\Tutor\TutorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('logout', [AuthController::class, 'logout'])
        ->middleware(['auth:sanctum'])
        ->name('auth.logout');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::post('user/upload-avatar', 'uploadAvatar');
        Route::get('user/profile', 'showProfile');
    });

    Route::apiResource('tutors', TutorController::class)->only(['index', 'store', 'update']);

    Route::apiResource('schools', SchoolController::class)->only(['index']);
});
