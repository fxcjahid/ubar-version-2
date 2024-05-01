<?php

/** Dev: fxcjahid **/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Manager;
use App\Http\Controllers\Admin\Withdraw;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Admin\CityAdmin;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Permission;
use App\Http\Controllers\Admin\SuperAdmin;
use App\Http\Controllers\BulkSmsController;
use App\Http\Controllers\ReferalController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\Admin\AssignToDriver;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\FareController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\VehicleControllers;
use App\Http\Controllers\BookingInvoiceController;
use App\Http\Controllers\Admin\CityAdminPermission;
use App\Http\Controllers\Admin\CityAgentController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\VehiclesDiscountController;
use App\Http\Controllers\Admin\FareCategoryController;
use App\Http\Controllers\Admin\ManualBookingController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "auth" middleware group. Now create something great!
|
*/


Route::get('dashboard', [Dashboard::class, 'index'])->name('admin.dashboard');
Route::get('cate-dashboard/{data}', [Dashboard::class, 'dashboard'])->name('admin.cate-dashboard');

// role section
Route::resource('roles', RoleController::class);

Route::get('vehicle-location', [Dashboard::class, 'vehicleLocation'])->name('admin.vehicle-location');
Route::get('get-category/{id}', [CategoryController::class, 'getCategory']);

// Type Route


Route::post('delete-type', [TypeController::class, 'delete'])->name('admin.type.destroy');
Route::get('type-list-data', [TypeController::class, 'typeAjaxList'])->name('admin.type.list_ajax');
Route::post('update-type', [TypeController::class, 'update1'])->name('admin.type.update');
Route::get('edit-type/{id}', [TypeController::class, 'edit1'])->name('admin.category.edit1');
Route::resource('type', TypeController::class);


// Category Route
Route::get('category', [CategoryController::class, 'index'])->name('admin.category');
Route::get('category-list-data', [CategoryController::class, 'categoryListAjax'])->name('admin.category.list_ajax');
Route::get('add-category', [CategoryController::class, 'create'])->name('admin.category.create');
Route::post('store-category', [CategoryController::class, 'store'])->name('admin.category.store');
Route::post('delete-category', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
Route::get('edit-category/{categoryId}', [CategoryController::class, 'edit'])->name('admin.category.edit');
Route::post('update-category', [CategoryController::class, 'update'])->name('admin.category.update');

// Fare Category section
Route::get('fare-category-list-data', [FareCategoryController::class, 'fareCategoryAjaxList'])->name('admin.fare-category.list_ajax');
Route::post('delete-fare-category', [FareCategoryController::class, 'delete'])->name('fare-category.delete');
Route::post('update-fare-category', [FareCategoryController::class, 'update'])->name('fare-category.update1');
Route::resource('fare-category', FareCategoryController::class);

// City Route
Route::get('city', [CityController::class, 'index'])->name('admin.city');
Route::get('city-list-data', [CityController::class, 'cityAjaxList'])->name('admin.city.list_ajax');
Route::post('store-city', [CityController::class, 'store'])->name('admin.city.store');
Route::post('delete-city', [CityController::class, 'destroy'])->name('admin.city.destroy');
Route::post('city-status-change', [CityController::class, 'statusChange'])->name('admin.city.status_change');
Route::post('update-city', [CityController::class, 'update'])->name('admin.city.update');

// Manager Route
Route::get('manager', [Manager::class, 'index'])->name('admin.manager');
Route::get('manager-list-ajax', [Manager::class, 'managerListAjax'])->name('admin.manager.list');
Route::get('create-manager', [Manager::class, 'create'])->name('admin.manager.create');
Route::post('store-manager', [Manager::class, 'store'])->name('admin.manager.store');
// Route::post('user-status-change' , [Manager::class , 'statusChange'])->name('admin.manager.status_change');
Route::post('manager_status_change', [Manager::class, 'statusChange'])->name('admin.manager.manager_status_change');
Route::post('delete-manager', [Manager::class, 'reomveManager'])->name('admin.manager.remove');
Route::get('edit-manager/{managerId}', [Manager::class, 'edit'])->name('admin.manager.edit');
Route::post('update-manager', [Manager::class, 'update'])->name('admin.manager.update');

// User Route
Route::get('user', [UserController::class, 'index'])->name('admin.user');
Route::get('user-list-ajax', [UserController::class, 'userListAjax'])->name('admin.user.list');
Route::get('create-user', [UserController::class, 'create'])->name('admin.user.create');
Route::post('store-user', [UserController::class, 'store'])->name('admin.user.store');
Route::post('userdata-status-change', [UserController::class, 'statusChange'])->name('admin.user.status_change');
Route::post('delete-user', [UserController::class, 'reomveUser'])->name('admin.user.remove');
Route::get('edit-user/{userId}', [UserController::class, 'edit'])->name('admin.user.edit');
Route::get('view-user/{userId}', [UserController::class, 'view'])->name('admin.user.view');
Route::post('update-user', [UserController::class, 'update'])->name('admin.user.update');
Route::get('new-user', [UserController::class, 'newUserView'])->name('admin.user.new-user-list');
Route::get('new-user-list-ajax', [UserController::class, 'newUserListAjax'])->name('admin.user.ajaxListNewUser');

// Driver Route
Route::get('driver', [DriverController::class, 'index'])->name('admin.driver');
Route::get('driver-list-ajax', [DriverController::class, 'driverListAjax'])->name('admin.driver.list');
Route::get('driver/document/{id}/view', [DriverController::class, 'documentView'])->name('admin.driver.document.view');
Route::get('create-driver', [DriverController::class, 'create'])->middleware('can:driver-create')->name('admin.driver.create');
Route::post('store-driver', [DriverController::class, 'store'])->middleware('can:driver-create')->name('admin.driver.store');
Route::post('driver-status-change', [DriverController::class, 'statusChange'])->name('admin.driver.status_change');
Route::post('delete-driver', [DriverController::class, 'reomveDriver'])->name('admin.driver.remove');
Route::get('edit-driver/{driverId}', [DriverController::class, 'edit'])->name('admin.driver.edit');
Route::get('edit-driver/{driverId}/docs', [DriverController::class, 'docs'])->name('admin.driver.docs');
Route::post('update-driver/{user}', [DriverController::class, 'update'])->name('admin.driver.update');
Route::post('update-driver-docs/{user}', [DriverController::class, 'updateDocs'])->name('admin.driver.update.docs');
Route::get('new-driver', [DriverController::class, 'newDriver'])->name('admin.driver.new-driver');
Route::get('get-new-driver-list-ajax', [DriverController::class, 'newDriverListAjax'])->name('admin.driver.newDriverListAjax');

// Vehicle Route
Route::get('vehicle', [VehicleControllers::class, 'index'])->name('admin.vehicle');
Route::get('vehicle-list-ajax', [VehicleControllers::class, 'vehicleAjaxList'])->name('admin.vehicle.list');
Route::get('create-vehicle', [VehicleControllers::class, 'create'])->name('admin.vehicle.create');
Route::post('store-vahicle', [VehicleControllers::class, 'store'])->name('admin.vehicle.store');
Route::post('vehicle-status-change', [VehicleControllers::class, 'statusChange'])->name('admin.vehicle.status-change');
Route::get('edit-vehicle/{vehicleId}', [VehicleControllers::class, 'edit'])->name('admin.vehicle.edit');
Route::post('update-vehicle', [VehicleControllers::class, 'update'])->name('admin.vehicle.update');
Route::post('delete-vehicle', [VehicleControllers::class, 'vehicleRemove'])->name('admin.vehicle.remove');
Route::post('delete-image', [VehicleControllers::class, 'deleteImage'])->name('admin.vehicle.image');

// Permission Route
Route::get('permission', [Permission::class, 'index'])->name('admin.permission.index');
Route::get('list-manage-for-permission', [Permission::class, 'listManagerPermission'])->name('admin.list.manager-permission');
Route::get('permission-view/{userId}', [Permission::class, 'permissionView'])->name('admin.permission.permission-view');
Route::post('staff_management', [Permission::class, 'addPrivilage'])->name('admin.permission.staff_management');

// Offer Route
Route::get('offer', [OfferController::class, 'index'])->name('admin.offer.index');
Route::get('offer-list', [OfferController::class, 'offerList'])->name('admin.offer.offer-list');
Route::post('store-offer', [OfferController::class, 'store'])->name('admin.offer.store');
Route::post('offer-status', [OfferController::class, 'offerStatus'])->name('admin.offer.offer-status');
Route::post('offer-remove', [OfferController::class, 'offerRemove'])->name('admin.offer.offer-remove');
Route::post('offer-update', [OfferController::class, 'update'])->name('admin.offer.offer-update');

// Coupon Route

Route::get('coupon', [CouponController::class, 'index'])->name('admin.coupon.index');
Route::get('coupon-list', [CouponController::class, 'couponList'])->name('admin.coupon.coupon-list');
Route::post('store-coupon', [CouponController::class, 'store'])->name('admin.coupon.store');
Route::post('coupon-status', [CouponController::class, 'couponStatus'])->name('admin.coupon.coupon-status');
Route::post('coupon-remove', [CouponController::class, 'couponRemove'])->name('admin.coupon.coupon-remove');
Route::post('coupon-update', [CouponController::class, 'update'])->name('admin.coupon.coupon-update');

// Fare Route
Route::get('fare', [FareController::class, 'index'])->name('admin.fare.index');
Route::get('fare-list-data', [FareController::class, 'fareAjaxList'])->name('admin.fare.list_ajax');
Route::post('store-fare', [FareController::class, 'store'])->name('admin.fare.store');
Route::post('delete-fare', [FareController::class, 'destroy'])->name('admin.fare.destroy');
Route::post('fare-status-change', [FareController::class, 'statusChange'])->name('admin.fare.status_change');
Route::post('update-fare', [FareController::class, 'update'])->name('admin.fare.update');

// Route For Assign to driver
Route::get('assign', [AssignToDriver::class, 'index'])->name('admin.assign.index');
Route::post('assign-to-driver', [AssignToDriver::class, 'store'])->name('admin.assign.assign-to-driver');
Route::post('assign-driver', [AssignToDriver::class, 'store'])->name('admin.assign.store');
Route::get('assign-list-ajax', [AssignToDriver::class, 'AssignListAjax'])->name('admin.assign.assign-list-ajax');
Route::post('delete-assign-car', [AssignToDriver::class, 'destroy'])->name('admin.assign.delete-assign-car');

// Route for City Admin
Route::get('city-admin', [CityAdmin::class, 'index'])->name('admin.cityadmin');
Route::get('city-admin-list-ajax', [CityAdmin::class, 'cityAdminListAjax'])->name('admin.cityadmin.list');
Route::get('create-city-admin', [CityAdmin::class, 'create'])->name('admin.cityadmin.create');
Route::post('store-city-admin', [CityAdmin::class, 'store'])->name('admin.cityadmin.store');
Route::post('user-status-change-city-admin', [CityAdmin::class, 'statusChange'])->name('admin.cityadmin.status_change');
Route::post('delete-city-admin', [CityAdmin::class, 'reomveCity'])->name('admin.cityadmin.remove');
Route::get('edit-city-admin/{managerId}', [CityAdmin::class, 'edit'])->name('admin.cityadmin.edit');
Route::post('update-city-admin', [CityAdmin::class, 'update'])->name('admin.cityadmin.update');


// Route for City Agent
Route::get('city-agent', [CityAgentController::class, 'index'])->name('admin.cityagent');
Route::get('city-agent-list-ajax', [CityAgentController::class, 'cityAgentListAjax'])->name('admin.cityagent.list');
Route::get('create-city-agent', [CityAgentController::class, 'create'])->name('admin.cityagent.create');
Route::post('store-city-agent', [CityAgentController::class, 'store'])->name('admin.cityagent.store');
Route::post('user-status-change-city-agent', [CityAgentController::class, 'statusChange'])->name('admin.cityagent.status_change');
Route::post('delete-city-agent', [CityAgentController::class, 'reomveCity'])->name('admin.cityagent.remove');
Route::get('edit-city-agent/{managerId}', [CityAgentController::class, 'edit'])->name('admin.cityagent.edit');
Route::post('update-city-agent', [CityAgentController::class, 'update'])->name('admin.cityagent.update');

// City Admin Permission
Route::get('city-admin-permission', [CityAdminPermission::class, 'index'])->name('admin.city-permission.index');
Route::get('list-city-admin-for-permission', [CityAdminPermission::class, 'listManagerPermission'])->name('admin.list.city-permission');
Route::get('city-admin-permission-view/{userId}', [CityAdminPermission::class, 'permissionView'])->name('admin.permission.city-view');
Route::post('city-admin-permission-add', [CityAdminPermission::class, 'addPrivilage'])->name('admin.permission.city-admin');

//Super Admin
Route::get('super-admin', [SuperAdmin::class, 'index'])->name('admin.super-admin');
Route::get('super-admin-list-ajax', [SuperAdmin::class, 'superAdminListAjax'])->name('admin.super-admin.list');
Route::get('create-super-admin', [SuperAdmin::class, 'create'])->name('admin.super-admin.create');
Route::post('store-super-admin', [SuperAdmin::class, 'store'])->name('admin.super-admin.store');
Route::post('user-status-change', [SuperAdmin::class, 'statusChange'])->name('admin.super-admin.status_change');
Route::post('delete-super-admin', [SuperAdmin::class, 'reomveSuperAdmin'])->name('admin.super-admin.remove');
Route::get('edit-super-admin/{managerId}', [SuperAdmin::class, 'edit'])->name('admin.super-admin.edit');
Route::post('update-super-admin', [SuperAdmin::class, 'update'])->name('admin.super-admin.update');

// Payout Withdraw
Route::get('withdraw', [Withdraw::class, 'index'])->name('admin.withdraw');
Route::get('withdraw-list', [Withdraw::class, 'withdrawAjaxList'])->name('admin.withdraw.ajax-list');
Route::get('withdraw-create', [Withdraw::class, 'create'])->name('admin.withdraw.create');
Route::post('store', [Withdraw::class, 'store'])->name('admin.withdraw.store');
Route::get('edit-withdraw/{withdraw}', [Withdraw::class, 'edit'])->name('admin.withdrwa.edit');
Route::post('update-withdraw', [Withdraw::class, 'update'])->name('admin.withdraw.update');

// Manual Booking Route
Route::get('manual-booking', [ManualBookingController::class, 'index'])->name('admin.manual-booking');
Route::get('manual-booking-list-ajax', [ManualBookingController::class, 'bookingListAjax'])->name('admin.manual.booking-list');
Route::get('create-manual-booking', [ManualBookingController::class, 'create'])->name('admin.manual.create');
Route::post('store_manual-booking', [ManualBookingController::class, 'store'])->name('admin.manual.store');
// Route::get('edit_manual_booking/{maualId}' , [ManualBookingController::class , 'edit'])->name('admin.manual.edit');
Route::post('update_manual_booking', [ManualBookingController::class, 'update'])->name('admin.manual.update');
Route::post('remove-booking', [ManualBookingController::class, 'removeBooking'])->name('admin.manual.remove');
Route::get('edit-manual-booking/{manualId}', [ManualBookingController::class, 'edit'])->name('admin.manual-booking.edit');

// Commission Controller Model
Route::get('company-commission', [CommissionController::class, 'index'])->name('admin.company-commission.index');
Route::post('commission-store', [CommissionController::class, 'store'])->name('admin.company-commission.store');
Route::get('company-commission-get', [CommissionController::class, 'companyCommissionListAjax'])->name('admin.company-commission.list');
Route::post('update-commission', [CommissionController::class, 'updateCompanyCommission'])->name('admin.company-commission.update');
Route::post('remove-company-commission', [CommissionController::class, 'removeComCommission'])->name('admin.company-commission.remove');

// Commission Agent
Route::get('agent-commission', [CommissionController::class, 'agentIndex'])->name('admin.agent-commission.index');
Route::post('agent-store', [CommissionController::class, 'agentStore'])->name('admin.agent-commission.store');
Route::get('agent-commission-get', [CommissionController::class, 'agentCommissionListAjax'])->name('admin.agent-commission.list');
Route::post('update-agent-commission', [CommissionController::class, 'updateAgentCommission'])->name('admin.agent-commission.update');
Route::post('remove-agent-commission', [CommissionController::class, 'removeAgentCommission'])->name('admin.agent-commission.remove');


Route::get('booking_list', [BookingController::class, 'index'])->name('admin.booking_list');
Route::get('booking_list_ajax', [BookingController::class, 'bookingListAjax'])->name('admin.booking_list_ajax');
Route::get('invoice/{invoice_id}', [BookingController::class, 'invoice'])->name('admin.booking.invoice');
// Logout
Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');

// admin section
Route::get('profile', [HomeController::class, 'profile'])->name('admin.profile');
Route::post('profile/update', [HomeController::class, 'profileUpdate'])->name('admin.profile.update');
// :::::::::::::::::::::::::::::: Settings Part ::::::::::::::::::::::::::::::::::::::::
Route::post('settings', [SettingsController::class, 'store'])->name('admin.settings');
Route::get('settings/general', [SettingsController::class, 'general_settings'])->name('admin.general.settings');



// Payment
Route::get('manual/payment', [PaymentController::class, 'manualPayments'])->name('admin.manual.payment');
Route::get('manual-paymentlist-ajax', [PaymentController::class, 'paymentListAjax'])->name('admin.payment.list');
Route::post('payment-status-change', [PaymentController::class, 'statusChange'])->name('admin.payment.status_change');
Route::post('delete-payment', [PaymentController::class, 'reomvePayment'])->name('admin.payment.remove');

Route::get('email/send', [HomeController::class, 'admin_email_send'])->name('admin.email.send');
Route::post('email/test', [HomeController::class, 'email_test'])->name('email.test');

// Feedback
Route::get('user/feedback', [FeedbackController::class, 'user_feedback'])->name('admin.user.feedback');
Route::get('driver/feedback', [FeedbackController::class, 'driver_feedback'])->name('admin.driver.feedback');


/** 
 * Sigup Referral 
 * @author Fxc Jahid <fxcjahid3@gmail.com>
 */
Route::prefix('referal')
    ->name('referal.')
    ->controller(ReferralController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });


/** 
 * Booking List Invoice
 * @author Fxc Jahid <fxcjahid3@gmail.com>
 */
Route::prefix('booking')
    ->name('admin.booking.')
    ->controller(BookingInvoiceController::class)
    ->group(function () {
        Route::get('invoice/{id}', 'index')->name('invoice');
    });

/** 
 * Vehicles Discount
 * @author Fxc Jahid <fxcjahid3@gmail.com>
 */
Route::prefix('vehicles')
    ->name('admin.vehicles.')
    ->controller(VehiclesDiscountController::class)
    ->group(function () {
        Route::get('list', 'index')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('create', 'store')->name('store');
    });

/** 
 * Send Bulk SMS
 * @author Fxc Jahid <fxcjahid3@gmail.com>
 */
Route::prefix('sms')
    ->name('admin.sms.')
    ->controller(BulkSmsController::class)
    ->group(function () {
        Route::get('send', 'index')->name('send');
        Route::post('send', 'send')->name('post');
    });