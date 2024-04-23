<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarBooking;
use App\Models\User;
use App\Models\Category;
use App\Helpers\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class Dashboard extends Controller
{
    //
    public function index()
    {

        $catedrivers = DB::table('categories')
            ->join('users', function (JoinClause $join) {
                $join->on('categories.category_name', '=', 'users.ride_service')->where('users.user_type', 'DRIVER');
            })
            ->select('categories.id as id', 'categories.category_name as name', 'categories.category_image as img', DB::raw("count(users.ride_service) as count"))
            ->groupBy('categories.id')
            ->get();


        $totalUser         = User::where(['user_type' => 'USER'])->count();
        $totalDriver       = User::where(['user_type' => 'DRIVER'])->count();
        $totalManager      = User::where(['user_type' => 'MANAGER'])->count();
        $newManagerREG     = User::whereDate('created_at', date('Y-m-d'))->where(['user_type' => 'MANAGER'])->count();
        $totalCityAdmin    = User::where(['user_type' => 'CITYADMIN'])->count();
        $todayRegCityAdmin = User::whereDate('created_at', date('Y-m-d'))->where(['user_type' => 'CITYADMIN'])->count();
        $todayUser         = User::where(['user_type' => 'USER'])->whereDate('created_at', date('Y-m-d'))->count();
        $todayDriver       = User::where(['user_type' => 'DRIVER'])->whereDate('created_at', date('Y-m-d'))->count();
        $todayRide         = CarBooking::whereDate('created_at', date('Y-m-d'))->count();
        $cancelledRide     = CarBooking::where(['booking_status' => 'cancelled'])->count();
        $complatedRide     = CarBooking::where(['booking_status' => 'completed'])->count();
        $totalRideBooking  = CarBooking::count();
        return view('admin.dashboard', compact('totalUser', 'totalDriver', 'totalManager', 'todayUser', 'todayDriver', 'todayRide', 'cancelledRide', 'complatedRide', 'totalRideBooking', 'totalCityAdmin', 'todayRegCityAdmin', 'newManagerREG', 'catedrivers'));

    }


    public function vehicleLocation()
    {

        $drivers = MyHelper::findNearestusers('23.806262', '90.412885');
        foreach ($drivers as $driver) {
            $data[] = [
                'position'  => [
                    'lat' => (float) $driver->lat,
                    'lng' => (float) $driver->long
                ],
                'label'     => ['color' => 'red', 'text' => $driver->name],
                'draggable' => true,
            ];
        }
        $initialMarkers = $data;

        // dd($data);
        return view('admin.vehicle-location', compact('initialMarkers'));

    }

    /**
     * @return view show dashboard category wise
     */
    public function dashboard(Request $request)
    {
        $cates = Category::limit(5)->get();

        $type = ($request->data == "today" ? "Today Ride" : ($request->data == "cancelled" ? "Total Cancelled Ride" : ($request->data == "total" ? "Total Completed Ride" : ($request->data == "total" ? "Total Completed Ride" : "Total Ride"))));
        return view('admin.dashboard2', compact('cates', 'type'));
    }
}