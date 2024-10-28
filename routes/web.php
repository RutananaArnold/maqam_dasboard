<?php

use App\Http\Controllers\Adverts\AdvertController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthLogic\AuthController;
use App\Http\Controllers\Bookings\BookingsController;
use App\Http\Controllers\MaqamExp\MaqamExperienceController;
use App\Http\Controllers\Packages\PackageController;
use App\Http\Controllers\SondaMpola\SondaMpolaController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// AUTH
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->middleware(['auth'])->name('register');
Route::post('/register', [AuthController::class, 'registration'])->middleware(['auth'])->name('registeruser');

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('loginuser');

// system users
Route::get('/system-users', [AuthController::class, 'viewSystemUsers'])->middleware(['auth'])->name('system.users');

// delete user information
Route::get('/delete-user-information', function () {
    return view('auth.delete_user');
});
Route::post('/delete', [AuthController::class, 'deleteUserInformation'])->name('deleteUser');
// privacy policy
Route::get('/privacy-policy', function () {
    return view('privacy_policy');
});

// logged in user views
Route::get('/dashboard', [AuthController::class, 'showDashboard'])->middleware(['auth'])->name('dashboard');
Route::get('/profile', [AuthController::class, 'showProfile'])->middleware(['auth'])->name('profile-page');

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

//app bookings
Route::get('/bookings-list', [BookingsController::class, 'showAppBookings'])->middleware(['auth'])->name('bookingsNow');
Route::get('/client-booking/{bookingId}', [BookingsController::class, 'viewBooking'])->middleware(['auth'])->name('showUserbooking');
Route::get('/download-passport/{userId}', [BookingsController::class, 'downloadPassport'])->middleware(['auth'])->name('savePassport');
Route::post('/upload-client-document', [BookingsController::class, 'attachTravelDocument'])->middleware(['auth'])->name('uploadTravelDocument');
Route::post('/update-client-booking-payment-status', [BookingsController::class, 'updatePaymentStatus'])->middleware(['auth'])->name('update.Payment.Status');
// update booking payment
Route::post('/update-client-booking-payment', [BookingsController::class, 'updateClientBookingPayment'])->middleware(['auth'])->name('create.bookings.payment');
Route::get('/generate-booking-receipt', [BookingsController::class, 'generateBookingReceipt'])->middleware(['auth'])->name('booking.receipt.download');

// regular bookings
Route::get('/regular-bookings', [BookingsController::class, 'viewRegularBookings'])->middleware(['auth'])->name('bookings.regular');
Route::get('/redirect-to-add-regular-booking', [BookingsController::class, 'addRegularBookingView'])->middleware(['auth'])->name('add.bookings.regular');
Route::post('/save-regular-booking', [BookingsController::class, 'createRegularBooking'])->middleware(['auth'])->name('save.booking.regular');

// Sonda mpola
Route::get('/sonda-mpola-collections', [SondaMpolaController::class, 'view'])->middleware(['auth'])->name('sondaMpola.collections');
Route::get('/redirect-to-create-sonda-mpola-record', [SondaMpolaController::class, 'createSondaMpolaAccountPage'])->middleware(['auth'])->name('redirect.sondaMpola.create');
Route::post('/save-sonda-mpola-record', [SondaMpolaController::class, 'saveSondaMpolaRecord'])->middleware(['auth'])->name('sondaMpola.save');
Route::get('/view-sonda-mpola-record', [SondaMpolaController::class, 'viewSondaMpolaRecord'])->middleware(['auth'])->name('sondaMpola.view.record');
Route::post('/store-sonda-mpola-payment-record', [SondaMpolaController::class, 'createSondaMpolaPaymentRecord'])->middleware(['auth'])->name('sondaMpola.payment.save');
Route::post('/update-sonda-mpola-payment-status', [SondaMpolaController::class, 'updatePaymentStatusAndTargetAmountStatus'])->middleware(['auth'])->name('sondaMpola.payment.status.update');
Route::get('/generate-sonda-mpola-receipt', [SondaMpolaController::class, 'generateSondaMpolaReceipt'])->middleware(['auth'])->name('sondaMpola.receipt.download');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
