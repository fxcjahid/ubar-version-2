<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarBooking;
use App\Models\DriverLocation;
use App\Models\RequestedDriver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RideController extends Controller
{
    public function ride_request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'pickup_location' => 'required',
            'drop_location' => 'required',
            'pickup_location_lat' => 'required|numeric',
            'pickup_location_lng' => 'required|numeric',
            'drop_location_lat' => 'required|numeric',
            'drop_location_lng' => 'required|numeric',
            'type_id' => 'required', // Ride Type
            'category_id' => 'required', //Service type
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $validated = $validator->validated();

        $validated['invoice_id'] = 'INV001' . rand(100000, 999999);
        $validated['otp'] = rand(1000, 9999);

        $booking = CarBooking::create($validated);


        $drivers = DriverLocation::select('driver_id', 'lat', 'lon', "driver_locations.id",
            DB::raw("6371 * acos(cos(radians(" . $request->pickup_location_lat . "))
                * cos(radians(driver_locations.lat))
                * cos(radians(driver_locations.lon) - radians(" . $request->pickup_location_lng . "))
                + sin(radians(" . $request->pickup_location_lat . "))
                * sin(radians(driver_locations.lat))) AS distance")
        )
            ->groupBy("driver_locations.id", "driver_id", "lat", "lon") // Include all selected columns in the GROUP BY clause
            ->get();



        foreach ($drivers as $driver) {
            RequestedDriver::create([
                'car_booking_id' => $booking->id,
                'driver_id' => $driver->driver_id,
                'user_id' => $request->user_id
            ]);
        }

        $data = [
            'drivers' => $drivers,
            'car_booking_id' => $booking->id,
        ];

        return response()->json(['status' => true, 'message' => 'Car booking created', 'data' => $data]);
    }
    public function check_ride_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_booking_id' => 'required|exists:car_bookings,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $validated = $validator->validated();

        $rider = RequestedDriver::where('car_booking_id', $validated['car_booking_id'])->where('user_id', $validated['user_id'])->where('status', 1)->first();

        if($rider == null) return response()->json(['status' => false, 'message' => 'Driver Not Accept']);
        $driver =  User::select('id', 'name', 'phone', 'profile_pic', )->find($rider->driver_id);

        $driver['profile_pic'] = get_image_url($driver->profile_pic);

        $data = [
            'driver' => $driver,
            'car_booking_id' => $validated['car_booking_id']
        ];

        return response()->json(['status' => true, 'message' => 'Driver Details', 'driver' => $data]);
    }

    public function check_request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $validated = $validator->validated();

        $rides = RequestedDriver::select('id', 'car_booking_id', 'driver_id', 'status')->where('driver_id', $validated['driver_id'])->where('status', 0)->get();

        return response()->json(['status' => true, 'message' => 'Ride lists', 'rides' => $rides]);
    }

    public function accept_request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required|exists:users,id',
            'car_booking_id' => 'required|exists:car_bookings,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $validated = $validator->validated();

        try {
            DB::beginTransaction();
            $car_booking = CarBooking::find($validated['car_booking_id']);
            $car_booking->update(['booking_status' => 'Accepted']);

            $rides = RequestedDriver::select('id', 'car_booking_id', 'driver_id', 'status')->where('driver_id', $validated['driver_id'])->where('car_booking_id', $validated['car_booking_id'])->first();
            $rides = $rides->update(['status' => 1]);

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Your Request Accept successfully', 'rides' => $rides]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'An error occurred while processing your request. Please try again later.']);
        }
    }
}

