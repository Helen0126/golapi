<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Event\EventPersonController;
use App\Http\Controllers\Gol\GolController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Reports\StudentReportController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Topic\TopicController;
use App\Http\Controllers\Tutor\TutorController;
use App\Http\Controllers\Week\WeekController;

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

Route::middleware(['auth:sanctum', 'verifygol'])->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::post('user/upload-avatar', 'uploadAvatar');
        Route::get('user/profile', 'showProfile');
        Route::post('user/reset-password', 'updatePassword');
    });

    Route::apiResource('tutors', TutorController::class)->except(['show']);
    Route::apiResource('students', StudentController::class)->except(['show']);
    Route::get('students/{id}', [StudentController::class, 'show']);
    Route::apiResource('gols', GolController::class)->except(['show']);
    Route::apiResource('weeks', WeekController::class)->except(['show', 'update']);
    Route::apiResource('topics', TopicController::class)->only(['update', 'destroy']);
    Route::apiResource('schools', SchoolController::class)->only(['index']);
    Route::apiResource('events', EventController::class)->except(['show']);
    Route::post('events/end-current-event', [EventController::class, 'finishEvent']);
    Route::apiResource('event-person', EventPersonController::class)->only(['index']);
    Route::put('event-person/{event}', [EventPersonController::class, 'update']);
});
Route::get('/reports/student/{person}', StudentReportController::class);
