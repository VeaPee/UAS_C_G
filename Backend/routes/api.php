<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerifyController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

  
Route::get('email/verify/{id}', [VerifyController::class, 'verify'])->name('verification.verify');
Route::get('email/resend', [VerifyController::class, 'resend'])->name('verification.resend');

/* New Added Routes */
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/profile', [UserController::class, 'show']);

    Route::put('/profile', [UserController::class, 'update']);

    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/logout', [AuthController::class, 'logout']);
});