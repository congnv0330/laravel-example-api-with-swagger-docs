<?php

use App\Http\Controllers\Auth\AuthenticatedController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SlugController;
use App\Http\Controllers\TagController;
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

Route::get('slug/{slug}', [SlugController::class, 'show']);

Route::get('tag/{tag}/blogs', [TagController::class, 'blogs']);
Route::get('tag/{tag}', [TagController::class, 'show']);
Route::get('tags', [TagController::class, 'index']);

Route::get('blog/{blog}', [BlogController::class, 'show']);
Route::get('blogs', [BlogController::class, 'index']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('me', [AuthenticatedController::class, 'me']);

    Route::post('upload/image', [UploadController::class, 'uploadImage']);

    Route::delete('tag/{tag}', [TagController::class, 'destroy']);
    Route::put('tag/{tag}', [TagController::class, 'update']);
    Route::post('tag', [TagController::class, 'store']);

    Route::delete('blog/{blog}', [BlogController::class, 'destroy']);
    Route::put('blog/{blog}', [BlogController::class, 'update']);
    Route::post('blog', [BlogController::class, 'store']);
});
