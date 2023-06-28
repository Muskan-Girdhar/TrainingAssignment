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



Route::controller(OurController::class)->group(function () {

    Route::middleware('AlreadyLoggedin')->group(function () {
    Route::get('/login', 'loginget');
    Route::get('/registration','registrationget');
    Route::get('/userdata', 'userdataget');
    });
    Route::get('/','home');
    
    Route::get('/addpost', 'addpostget')->middleware('loggedin');;

    Route::post('/registration','registrationpost')->name('registrationpost');
    Route::post('/login','loginpost')->name('loginpost');
    
    Route::get('/email', 'email');
    Route::get('/dashboard', 'dashboard');
    Route::get('/logout','logout');
    Route::post('/addpost', 'addpost')->name('addpostpost');
    Route::get('/all', 'all');
    Route::get('/dance', 'dance');
    Route::get('/singing', 'singing');
    Route::get('/speaking', 'publicspeaking');
    Route::get('/userall', 'userall');
    Route::get('/userdance', 'userdance');
    Route::get('/usersinging', 'usersinging');
    Route::get('/userspeaking', 'userpublicspeaking');
    Route::get('/yourpost', 'yourpost');
    Route::get('/yourdraft','yourdraft');
});

