<?php
use App\Http\Controllers\FeedbackController;
use App\Models\Vehicle;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Manager;
use App\Http\Controllers\Admin\Withdraw;
use App\Http\Controllers\Admin\CityAdmin;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Permission;
use App\Http\Controllers\Admin\SuperAdmin;
use App\Http\Controllers\Admin\AssignToDriver;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\FareController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\CityAgentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\VehicleControllers;
use App\Http\Controllers\Admin\CityAdminPermission;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\ManualBookingController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\FareCategoryController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\RoleController;

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

Route::get('/updateapp', function () {
    \Artisan::call('dump-autoload');
    echo 'dump-autoload complete';
});

Route::get('/clear', function () {
    $output = new \Symfony\Component\Console\Output\BufferedOutput();
    Artisan::call('optimize:clear', array (), $output);
    return $output->fetch();
})->name('/clear');

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'loginSubmit'])->name('user.login');