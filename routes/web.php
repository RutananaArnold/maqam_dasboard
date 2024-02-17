<?php

use App\Http\Controllers\Adverts\AdvertController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthLogic\AuthController;
use App\Http\Controllers\MaqamExp\MaqamExperienceController;
use App\Http\Controllers\Packages\PackageController;

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
Route::get('/view-packages', [PackageController::class, 'showPackages'])->middleware(['auth'])->name('packagesList');
Route::get('/add-packages', [PackageController::class, 'showAddPackage'])->middleware(['auth'])->name('toAddPackage');
Route::post('/save-package', [PackageController::class, 'addNewPackage'])->middleware(['auth'])->name('createPackage');
Route::get('/edit/{packageId}/package', [PackageController::class, 'viewPackageDetail'])->middleware(['auth'])->name('packageDetails');
Route::post('/update-packagse', [PackageController::class, 'updatePackage'])->middleware(['auth'])->name('packageUpdate');
Route::get('/delete/{packageId}/package', [PackageController::class, 'showDeletePackagePage'])->middleware(['auth'])->name('showDeletePage');
Route::post('/delete-package', [PackageController::class, 'deletePackage'])->middleware(['auth'])->name('packageDelete');


// maqam experience
Route::get('/add-maqam-experiesnce', [MaqamExperienceController::class, 'showAddMaqamExp'])->middleware(['auth'])->name('showAddMaqamExp');
Route::post('/save-maqam-experience', [MaqamExperienceController::class, 'saveMaqamExp'])->middleware(['auth'])->name('saveMaqamExp');
Route::get('/maqam-experience-list', [MaqamExperienceController::class, 'showMaqamExperiences'])->middleware(['auth'])->name('maqamExpList');
Route::get('/maqam-experience-details/{expId}', [MaqamExperienceController::class, 'displayMaqamDetails'])->middleware(['auth'])->name('maqamExpDetail');
Route::post('/edit-maqam-experience', [MaqamExperienceController::class, 'updateMaqamExperience'])->middleware(['auth'])->name('editMaqamExp');
Route::get('/delete/{expId}/experience', [MaqamExperienceController::class, 'showDeletePage'])->middleware(['auth'])->name('toDeleteExp');
Route::post('/delete-experience', [MaqamExperienceController::class, 'deleteMaqamExperience'])->middleware(['auth'])->name('deleteMaqamExp');



Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
