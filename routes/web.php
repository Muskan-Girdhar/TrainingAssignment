<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OurController;
use App\Http\Controllers\AlreadyLoggedin;
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
Route::view('/','Home');

Route::controller(OurController::class)->group(function () {

    Route::middleware('AlreadyLoggedin')->group(function () {
    Route::get('/login', 'loginget');
    Route::get('/registration','registrationget');
    });
    Route::get('/addpost', 'addpostget')->middleware('loggedin');;

    Route::post('/registration','registrationpost')->name('registrationpost');
    Route::post('/login','loginpost')->name('loginpost');
    
    Route::get('/email', 'email');
    Route::get('/dashboard', 'dashboard');
    Route::get('/logout','logout');
    Route::post('/addpost', 'addpost')->name('addpostpost');

});

