<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

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
   // return view('welcome');
});

Route::get('/auth/login', [UserController::class, 'Userlogin']);
Route::get('/auth/callback', [UserController::class, 'UserCallback']);
Route::get('/users', [UserController::class, 'UsersDetails']);
Route::get('/userStore_listening', [UserController::class, 'UserStore_listening']);
Route::get('/user_listening', [UserController::class, 'UserListening']);
//Route::get('/UpdateToken', [UserController::class, 'UpdateToken']);
Route::get('/logout', [AuthController::class, 'logout']);
