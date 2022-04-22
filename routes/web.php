<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
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
    return view('welcome');
});

Route::get('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/callback', [AuthController::class, 'callback']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/users', [AuthController::class, 'users']);
Route::get('/userStore_listening', [AuthController::class, 'userStore_listening']);
Route::get('/user_listening', [AuthController::class, 'user_listening']);
Route::get('/UpdateToken', [AuthController::class, 'UpdateToken']);
