<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthLogic\AuthController;
use App\Http\Controllers\policy\PolicyController;

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

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'registration'])->name('registeruser');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('loginuser');

Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');




Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
