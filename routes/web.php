<?php

use App\Http\Controllers\Adverts\AdvertController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthLogic\AuthController;

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

Route::get('/dashboard', [AuthController::class, 'showDashboard'])->middleware(['auth'])->name('dashboard');

//adverts
Route::get('/view-adverts', [AdvertController::class, 'showAdverts'])->middleware(['auth'])->name('advertsList');
Route::get('/add-advert', [AdvertController::class, 'showAddAdvert'])->middleware(['auth'])->name('toAddAdvert');
Route::post('/save-advert', [AdvertController::class, 'addNewAdvert'])->middleware(['auth'])->name('createAdvert');
Route::get('/edit/{advertId}/advert', [AdvertController::class, 'viewAdvertDetail'])->middleware(['auth'])->name('viewAdDetail');
Route::post('/update-advert', [AdvertController::class, 'updateAdvert'])->middleware(['auth'])->name('updateAdvert');
Route::get('/delete/{advertId}/advert', [AdvertController::class, 'showDeletePage'])->middleware(['auth'])->name('showDeleteView');
Route::post('/delete-advert', [AdvertController::class, 'deleteAdvert'])->middleware(['auth'])->name('deleteAdvert');


// packages


// maqam experience



Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
