<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
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



Route::controller(BlogController::class)->group(function () {

    Route::middleware('AlreadyLoggedin')->group(function () {
    Route::get('/login', 'loginGet');
    Route::get('/registration','registrationGet');
    Route::get('/userdata', 'userDataGet');
    });
    Route::get('/','home');
    
    Route::get('/addpost', 'addPostGet')->middleware('loggedin');;

    Route::post('/registration','registrationPost')->name('registrationpost');
    Route::post('/login','loginPost')->name('loginpost');
    
    Route::get('/email', 'email');
    Route::get('/dashboard', 'dashboard');
    Route::get('/logout','logout');
    Route::post('/addpost', 'addpost')->name('addpostpost');
    Route::get('/all', 'all');
    Route::get('/dance', 'dance');
    Route::get('/singing', 'singing');
    Route::get('/speaking', 'publicSpeaking');
    Route::get('/userall', 'userAll');
    Route::get('/userdance', 'userDance');
    Route::get('/usersinging', 'userSinging');
    Route::get('/userspeaking', 'userPublicSpeaking');
    Route::get('/yourpost', 'yourPost');
    Route::get('/yourdraft','yourDraft');
});

