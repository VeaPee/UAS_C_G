<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});
// Route Resource
Route::resource('/team', \App\Http\Controllers\TeamController::class);
Route::get('/team', 'App\Http\Controllers\TeamController@index')->name('team.index');

Route::resource('/teammember', \App\Http\Controllers\TeamMemberController::class);
Route::get('/teammember', 'App\Http\Controllers\TeamMemberController@index')->name('teammember.index');

Route::resource('/tournament', \App\Http\Controllers\TournamentController::class);
Route::get('/tournament', 'App\Http\Controllers\TournamentController@index')->name('tournament.index');

Route::resource('/user', \App\Http\Controllers\UserController::class);
Route::get('/user', 'App\Http\Controllers\UserController@index')->name('user.index');
