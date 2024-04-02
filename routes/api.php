<?php

use App\Http\Controllers\API\MobileAppController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/create-booking', [MobileAppController::class, 'createBooking']);
Route::post('/user-bookings', [MobileAppController::class, 'getUserBookings']);
Route::post('/update-booking-payment', [MobileAppController::class, 'updateBookingPayment']);
Route::get('/get-packages', [MobileAppController::class, 'getPackages']);
Route::post('/payment-history', [MobileAppController::class, 'getPaymentHistory']);
Route::post('/get-client-travel-doc', [MobileAppController::class, 'fetchClientTravelDoc']);
Route::post('/login-client', [MobileAppController::class, 'loginClientInApp']);
