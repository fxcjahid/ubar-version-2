<?php

use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\Driver;
use App\Http\Controllers\Api\FeedBackApiController;
use App\Http\Controllers\Api\RideController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\SmsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Driver Apps API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('driver_doc/{driver_id}', [Driver::class, 'driverDoc']);
Route::post('upload/document', [Driver::class, 'driverUploadDocument']);


Route::get('driver_profile_get/{driver_id}', [Driver::class, 'getDriverData']);
Route::post('profile_update', [Driver::class, 'profileUpdate']);
Route::post('promo_code', [Driver::class, 'promoCode']);
Route::post('referral_code', [Driver::class, 'refferalCode']);

Route::get('get_promo_code/{driver_id}', [Driver::class, 'getPromoCode']);
Route::get('get_referral_code/{driver_id}', [Driver::class, 'getRefferalCode']);

Route::get('booking_pending_list/{driver_id}', [Driver::class, 'getPendingList']);

Route::post('accept_booking', [Driver::class, 'acceptBooking']);
Route::post('booking_cancelled', [Driver::class, 'cancelledBooking']);

Route::post('otp_check', [Driver::class, 'otpCheck']);

Route::post('confirm_booking', [Driver::class, 'confirmBooking']);

Route::get('rating/{driver_id}', [Driver::class, 'rating']);
Route::post('give_rating_to_user', [Driver::class, 'giveRatingToUser']);

Route::post('driver_profile_update', [Driver::class, 'driverProfileUpdate']);

Route::get('previous_booking_list/{driver_id}', [Driver::class, 'getPriviousBookingList']);


Route::post("feedback/create", [FeedBackApiController::class, 'driver_store']);