<?php

use App\Http\Controllers\Auth\AuthenticatedController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UploadController;
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

Route::post('login', [AuthenticatedController::class, 'login']);

Route::post('forgot-password', [PasswordResetLinkController::class, 'sendResetLink']);

Route::post('reset-password', [NewPasswordController::class, 'update']);

Route::get('blogs', [BlogController::class, 'index']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('me', [AuthenticatedController::class, 'me']);

    Route::post('upload/image', [UploadController::class, 'uploadImage']);
});
