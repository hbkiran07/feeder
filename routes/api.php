<?php

use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('validate')->group(function () {
    Route::post('register', ([\App\Http\Controllers\AccountController::class, 'register']));
});

Route::middleware('validate')->group(function () {
    Route::post('verificate/sms', ([\App\Http\Controllers\AccountController::class, 'verifyWithSms']));
});

Route::middleware('validate')->group(function () {
    Route::post('verificate/email', ([\App\Http\Controllers\AccountController::class, 'verifyWithEmail']));
});

Route::middleware('validate')->group(function () {
    Route::post('login', ([\App\Http\Controllers\AccountController::class, 'login']));
});

Route::middleware('auth.custom')->group(function () {
    Route::get('feed/all', ([\App\Http\Controllers\FeederController::class, 'getFeedData']));
});

Route::middleware('auth.custom')->group(function () {
    Route::get('feed/active', ([\App\Http\Controllers\FeederController::class, 'getActive']));
});

Route::middleware('auth.custom')->group(function () {
    Route::get('feed/passive', ([\App\Http\Controllers\FeederController::class, 'getPassive']));
});

Route::middleware('auth.custom')->group(function () {
    Route::get('feed/user', ([\App\Http\Controllers\FeederController::class, 'getOtherUser']));
});

Route::middleware('auth.custom')->group(function () {
    Route::get('feed/flow', ([\App\Http\Controllers\FeederController::class, 'getFlow']));
});

Route::middleware('auth.custom')->group(function () {
    Route::get('feed/source/import', ([\App\Http\Controllers\FeederController::class, 'getFlow']));
});

Route::middleware('validate','auth.custom')->group(function () {
    Route::post('feed/activate', ([\App\Http\Controllers\FeederController::class, 'activate']));
});

Route::middleware('validate','auth.custom')->group(function () {
    Route::post('feed/edit', ([\App\Http\Controllers\FeederController::class, 'edit']));
});
