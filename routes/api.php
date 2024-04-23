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


Route::post('/user/ride-request', [RideController::class, 'ride_request']);
Route::post('/user/check-ride-status', [RideController::class, 'check_ride_status']);
Route::post('/driver/check_request', [RideController::class, 'check_request']);
Route::post('/driver/accept_request', [RideController::class, 'accept_request']);

// User Login

Route::any('user/register', [UserController::class, 'register']);
Route::post('user/otp_verification', [UserController::class, 'otp_verification']);
Route::any('user/login', [UserController::class, 'login']);
Route::get('user/ride-type', [UserController::class, 'rideType']);
Route::post('user/get-category', [UserController::class, 'GetCategory']);
Route::post('', [UserController::class, '']);

Route::post('user/nearby-vehicle', [UserController::class, 'nearbyVehicle']);
Route::any('driver/current/location', [Driver::class, 'driver_current_location'])->name('driver.current.location');

//Driver Route here.....
Route::post('driver/register_driver', [Driver::class, 'addDriver']);
Route::post('driver/otp_verification_driver', [Driver::class, 'otp_verification_driver']);
Route::post('driver/driver-login', [Driver::class, 'driverLogin']);
// Route::post('driver/accept-ride' , [Driver::class , 'accept_ride'])->name('accept-ride');

// Payment
Route::post('payment/manual', [PaymentController::class, 'manualPayment']);

// Category ----
Route::get('service/lists', [ServiceController::class, 'services']);
Route::get('package/lists', [ServiceController::class, 'packages']);


Route::middleware('auth:sanctum')->group(function () {
    // User
    Route::post('user/profile-update', [UserController::class, 'profileUpdate']);
    Route::get('user/user-detail/{id}', [UserController::class, 'userDetail']);
    Route::post('user/change-password', [UserController::class, 'password_update']);
    Route::get('user/user-emergency-number/{id}', [UserController::class, 'userEmergencyNumber']);
    Route::post('user/update-user-emergency_number', [UserController::class, 'updateUserEmergencyNumber']);

    Route::post('user/profile_pic_upload', [UserController::class, 'profileUpload']);

    // Car
    Route::post('car/schedule-car-list', [CarController::class, 'scheduleCarList']);
    Route::post('car/rent-car-list', [CarController::class, 'rentCarList']);
    Route::post('car/intercity-car-list', [CarController::class, 'intercityCarList']);
    Route::post('car/hourly-car-list', [CarController::class, 'hourlyCarList']);
    Route::post('car/ride-car-list', [CarController::class, 'rideCarList']);

    Route::post('car/bus-list', [CarController::class, 'busList']);
    Route::post('car/truck-list', [CarController::class, 'truckList']);
    Route::post('car/ambulance-list', [CarController::class, 'ambulnaceList']);

    // /Booking Car
    Route::post('car/ride_car_booking', [CarController::class, 'rideCarBooking']);
    Route::post('car/schedule_car_booking', [CarController::class, 'scheduleCarBooking']);
    Route::post('car/hourly_car_booking', [CarController::class, 'hourlyCarBooking']);
    Route::post('car/intecity_car_booking', [CarController::class, 'intercityCarBooking']);
    Route::post('car/rental_car_booking', [CarController::class, 'rentalCarBooking']);

    Route::post('car/bus_booking', [CarController::class, 'busBookingBooking']);
    Route::post('car/truck_booking', [CarController::class, 'truckBookingBooking']);
    Route::post('car/ambulance_booking', [CarController::class, 'ambulanceBookingBooking']);

    // Booking Cancelled
    Route::post('car/booking_cancelled', [CarController::class, 'bookingCancelled']);

    // ########### TYpe Of Car Get
    Route::get('car/get_list_type_of_Car', [CarController::class, 'typeOfCar']);




    //############### Driver Process here.....................................
    Route::post('driver/driver_documnet_upload', [Driver::class, 'driverDocUpload']);
    Route::get('driver/driver_doc/{driver_id}', [Driver::class, 'driverDoc']);
    Route::get('driver/driver_profile_get/{driver_id}', [Driver::class, 'getDriverData']);
    Route::post('driver/profile_update', [Driver::class, 'profileUpdate']);
    Route::post('driver/promo_code', [Driver::class, 'promoCode']);
    Route::post('driver/referral_code', [Driver::class, 'refferalCode']);

    Route::get('driver/get_promo_code/{driver_id}', [Driver::class, 'getPromoCode']);
    Route::get('driver/get_referral_code/{driver_id}', [Driver::class, 'getRefferalCode']);

    Route::get('driver/booking_pending_list/{driver_id}', [Driver::class, 'getPendingList']);

    Route::post('driver/accept_booking', [Driver::class, 'acceptBooking']);
    Route::post('driver/booking_cancelled', [Driver::class, 'cancelledBooking']);

    Route::post('driver/otp_check', [Driver::class, 'otpCheck']);

    Route::post('driver/confirm_booking', [Driver::class, 'confirmBooking']);

    Route::get('driver/rating/{driver_id}', [Driver::class, 'rating']);
    Route::post('driver/give_rating_to_user', [Driver::class, 'giveRatingToUser']);

    Route::post('driver/driver_profile_update', [Driver::class, 'driverProfileUpdate']);

    Route::get('driver/previous_booking_list/{driver_id}', [Driver::class, 'getPriviousBookingList']);

});

//FEEDBACK CONTROLLER
Route::post("driver/feedback/create", [FeedBackApiController::class, 'driver_store']);
Route::post("user/feedback/create", [FeedBackApiController::class, 'user_store']);


Route::get("feedback/{id?}", [FeedbackController::class, 'index']);
Route::get("feedback/edete/{id}", [FeedbackController::class, 'edete']);
Route::post("feedback/update/{id}", [FeedbackController::class, 'update']);
Route::post("feedback/delete/{id}", [FeedbackController::class, 'delete']);
Route::get("feedback/sender/{sender}/{id?}", [FeedbackController::class, 'sender']);
Route::get("feedback/reciver/{reciver}/{id?}", [FeedbackController::class, 'reciver']);

//SMS CONTROLLER
Route::post("sms/send", [SmsController::class, 'smssend']);


/**
 * User can get their registered referral history
 * @since 2.0.0
 * @author Fxc Jahid <email> 
 */
Route::prefix('referral')
    ->middleware('auth:sanctum')
    ->name('api.referral.')
    ->controller(ReferralController::class)
    ->group(function () {
        Route::get('/', 'userReferralHistory');
    });