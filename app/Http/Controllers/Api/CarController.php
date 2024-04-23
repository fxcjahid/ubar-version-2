<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssignToDriver;
use App\Models\CarBooking;
use App\Models\Category;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    //Schedule car list
    public function scheduleCarList(Request $request) {
        $data = AssignToDriver::select("assign_to_drivers.*" , 'users.unique_id' ,'users.name' , 'users.first_name' ,
        'users.last_name' ,  'vehicles.vehicle_number' , 'vehicles.vehicle_seats' , 'vehicles.vehicle_type' ,
        'vehicles.vehicle_category' , 'vehicles.vehicle_pic' , 'categories.category_name' ,
        'fares.minimum_fare' , 'fares.km' , 'users.lat' , 'users.long' , 'users.active' , 'users.phone' , 'users.profile_pic')
        ->join('users' , 'assign_to_drivers.user_id' , '=' , 'users.id')
        ->join('vehicles' , 'assign_to_drivers.vehicle_id' , '=' , 'vehicles.id')
        ->join('categories' , 'vehicles.vehicle_category' , '=' , 'categories.id')
        ->leftjoin('fares' , 'vehicles.vehicle_category' , '=' , 'fares.category_id')
        ->where(['vehicles.vehicle_type' => 'schedule_car'])
        // ->where('lat' , '>=' , $request->lat)->where('long' , '<=' , $request->long)
        ->where(['vehicles.vehicle_type' => 'schedule_car'])
        ->where('users.active' , 1);
        if(!empty($request->type )){
            if($request->type != "all") {
                $data = $data->where('categories.category_name', 'LIKE', '%'.$request->type.'%');
            }
        }
        $data = $data->get();

        $array = [];
        if($data) {
            foreach($data as $item) {
                $vehicleImage = VehicleImage::where(['vehicle_id' => $item->vehicle_id])->first();
                $newData['id']  = $item->id;
                $newData['vehicle_id']  = $item->vehicle_id;
                $newData['user_id']  = $item->user_id;
                $newData['status']  = $item->status;
                $newData['unique_id']  = $item->unique_id;
                $newData['name']  = $item->name;
                $newData['driver_phone']  = $item->phone;
                $newData['first_name']  = $item->first_name;
                $newData['last_name']  = $item->last_name;
                $newData['vehicle_number']  = $item->vehicle_number;
                $newData['vehicle_seats']  = $item->vehicle_seats;
                $newData['vehicle_type']  = $item->vehicle_type;
                $newData['vehicle_category']  = $item->vehicle_category;
                // $newData['vehicle_pic']  = $item->vehicle_pic;
                $newData['category_name']  = $item->category_name;
                $newData['minimum_fare']  = $item->minimum_fare;
                $newData['km']  = $item->km;
                $newData['lat']  = $item->lat;
                $newData['long']  = $item->long;
                $newData['active']  = $item->active;
                $newData['day']   = $request->day;
                $newData['total_time']   = '30 Minutes';
                $newData['driver_profile_pic']  = ($item->profile_pic != '' ? url($item->profile_pic) : NULL);
                 $newData['vehicle_pic']  = ($vehicleImage->vehicle_image != '' ? url($vehicleImage->vehicle_image) : NULL);

                array_push($array , $newData);
            }
        }

        $users = User::findOrFail(Auth::user()->id);
        return response()->json(['status' => true ,  'data' => $array , 'users' => $users]);
    }


    // Rent car list
    public function rentCarList(Request $request) {

        $data = AssignToDriver::select("assign_to_drivers.*" , 'users.unique_id' ,'users.name' , 'users.first_name' ,
        'users.last_name' ,  'vehicles.vehicle_number' , 'vehicles.vehicle_seats' , 'vehicles.vehicle_type' ,
        'vehicles.vehicle_category' , 'vehicles.vehicle_pic' , 'categories.category_name' ,
        'fares.minimum_fare' , 'fares.km' , 'users.lat' , 'users.long' , 'users.active' , 'users.phone' ,  'users.profile_pic')
        // 'rent_car_bookings.start_date' ,
        //  'rent_car_bookings.end_date' , 'rent_car_bookings.total_days')
        ->join('users' , 'assign_to_drivers.user_id' , '=' , 'users.id')
        ->join('vehicles' , 'assign_to_drivers.vehicle_id' , '=' , 'vehicles.id')
        ->join('categories' , 'vehicles.vehicle_category' , '=' , 'categories.id')
        ->leftjoin('fares' , 'vehicles.vehicle_category' , '=' , 'fares.category_id')
        ->leftjoin('rent_car_bookings' , 'vehicles.id' , '=' , 'rent_car_bookings.vehicle_id')
        ->where(['vehicles.vehicle_type' => 'rent'])
        // ->where('lat' , '>=' , $request->lat)->where('long' , '<=' , $request->long)
        // ->whereDate('start_date' , '!=' , $request->start_date)
        ->where('users.active' , 1);
        if(!empty($request->type )){
            if($request->type != "all") {
                $data = $data->where('categories.category_name', 'LIKE', '%'.$request->type.'%');
            }
        }
        $data = $data->get();
        $array = [];
        if($data) {
            foreach($data as $item) {
                 $vehicleImage = VehicleImage::where(['vehicle_id' => $item->vehicle_id])->first();
                $newData['id']  = $item->id;
                $newData['vehicle_id']  = $item->vehicle_id;
                $newData['user_id']  = $item->user_id;
                $newData['status']  = $item->status;
                $newData['unique_id']  = $item->unique_id;
                $newData['name']  = $item->name;
                $newData['driver_phone']  = $item->phone;
                $newData['first_name']  = $item->first_name;
                $newData['last_name']  = $item->last_name;
                $newData['vehicle_number']  = $item->vehicle_number;
                $newData['vehicle_seats']  = $item->vehicle_seats;
                $newData['vehicle_type']  = $item->vehicle_type;
                $newData['vehicle_category']  = $item->vehicle_category;
                // $newData['vehicle_pic']  = $item->vehicle_pic;
                $newData['category_name']  = $item->category_name;
                $newData['minimum_fare']  = $item->minimum_fare;
                $newData['km']  = $item->km;
                $newData['lat']  = $item->lat;
                $newData['long']  = $item->long;
                $newData['active']  = $item->active;
                $newData['day']   = $request->day;
                $newData['total_time']   = '30 Minutes';
                 $newData['driver_profile_pic']  = ($item->profile_pic != '' ? url($item->profile_pic) : NULL);
                 $newData['vehicle_pic']  = ($vehicleImage->vehicle_image != '' ? url($vehicleImage->vehicle_image) : NULL);

                array_push($array , $newData);
            }
        }

        $users = User::findOrFail(Auth::user()->id);
        return response()->json(['status' => true ,  'data' => $array , 'users' => $users]);
    }

     // Intercity car list
     public function intercityCarList(Request $request) {
        $data =   $data = AssignToDriver::select("assign_to_drivers.*" , 'users.unique_id' ,'users.name' , 'users.first_name' ,
        'users.last_name' ,  'vehicles.vehicle_number' , 'vehicles.vehicle_seats' , 'vehicles.vehicle_type' ,
        'vehicles.vehicle_category' , 'vehicles.vehicle_pic' , 'categories.category_name' ,
        'fares.minimum_fare' , 'fares.km' , 'users.lat' , 'users.long' , 'users.active' , 'users.phone' ,  'users.profile_pic')
        ->join('users' , 'assign_to_drivers.user_id' , '=' , 'users.id')
        ->join('vehicles' , 'assign_to_drivers.vehicle_id' , '=' , 'vehicles.id')
        ->join('categories' , 'vehicles.vehicle_category' , '=' , 'categories.id')
        ->leftjoin('fares' , 'vehicles.vehicle_category' , '=' , 'fares.category_id')
        // ->where('lat' , '>=' , $request->lat)->where('long' , '<=' , $request->long)
        ->where('users.active' , 1)
        ->where(['vehicles.vehicle_type' => 'intercity']);
        if(!empty($request->type )){
            if($request->type != "all") {
                $data = $data->where('categories.category_name', 'LIKE', '%'.$request->type.'%');
            }
        }
        $data = $data->get();
        $array = [];
        if($data) {
            foreach($data as $item) {
                 $vehicleImage = VehicleImage::where(['vehicle_id' => $item->vehicle_id])->first();
                $newData['id']  = $item->id;
                $newData['vehicle_id']  = $item->vehicle_id;
                $newData['user_id']  = $item->user_id;
                $newData['status']  = $item->status;
                $newData['unique_id']  = $item->unique_id;
                $newData['name']  = $item->name;
                $newData['driver_phone']  = $item->phone;
                $newData['first_name']  = $item->first_name;
                $newData['last_name']  = $item->last_name;
                $newData['vehicle_number']  = $item->vehicle_number;
                $newData['vehicle_seats']  = $item->vehicle_seats;
                $newData['vehicle_type']  = $item->vehicle_type;
                $newData['vehicle_category']  = $item->vehicle_category;
                // $newData['vehicle_pic']  = $item->vehicle_pic;
                $newData['category_name']  = $item->category_name;
                $newData['minimum_fare']  = $item->minimum_fare;
                $newData['km']  = $item->km;
                $newData['lat']  = $item->lat;
                $newData['long']  = $item->long;
                $newData['active']  = $item->active;
                $newData['day']   = $request->day;
                $newData['total_time']   = '30 Minutes';
               $newData['driver_profile_pic']  = ($item->profile_pic != '' ? url($item->profile_pic) : NULL);
                 $newData['vehicle_pic']  = ($vehicleImage->vehicle_image != '' ? url($vehicleImage->vehicle_image) : NULL);

                array_push($array , $newData);
            }
        }


        return response()->json(['status' => true ,  'data' => $array]);
    }

      // Hourly car list
      public function hourlyCarList(Request $request) {
        $data = AssignToDriver::select("assign_to_drivers.*" , 'users.unique_id' ,'users.name' , 'users.first_name' ,
        'users.last_name' ,  'vehicles.vehicle_number' , 'vehicles.vehicle_seats' , 'vehicles.vehicle_type' ,
        'vehicles.vehicle_category' , 'vehicles.vehicle_pic' , 'categories.category_name' ,
        'fares.minimum_fare' , 'fares.km' , 'users.lat' , 'users.long' , 'users.active' , 'users.phone' ,  'users.profile_pic')
        ->join('users' , 'assign_to_drivers.user_id' , '=' , 'users.id')
        ->join('vehicles' , 'assign_to_drivers.vehicle_id' , '=' , 'vehicles.id')
        ->join('categories' , 'vehicles.vehicle_category' , '=' , 'categories.id')
        ->leftjoin('fares' , 'vehicles.vehicle_category' , '=' , 'fares.category_id')
        // ->where('lat' , '>=' , $request->lat)->where('long' , '<=' , $request->long)
        ->where('users.active' , 1)
        ->where(['vehicles.vehicle_type' => 'hourly_car']);
        if(!empty($request->type )){
            if($request->type != "all") {
                $data = $data->where('categories.category_name', 'LIKE', '%'.$request->type.'%');
            }
        }
        $data = $data->get();

        $array = [];
        if($data) {
            foreach($data as $item) {
                 $vehicleImage = VehicleImage::where(['vehicle_id' => $item->vehicle_id])->first();
                $newData['id']  = $item->id;
                $newData['vehicle_id']  = $item->vehicle_id;
                $newData['user_id']  = $item->user_id;
                $newData['status']  = $item->status;
                $newData['unique_id']  = $item->unique_id;
                $newData['name']  = $item->name;
                $newData['driver_phone']  = $item->phone;
                $newData['first_name']  = $item->first_name;
                $newData['last_name']  = $item->last_name;
                $newData['vehicle_number']  = $item->vehicle_number;
                $newData['vehicle_seats']  = $item->vehicle_seats;
                $newData['vehicle_type']  = $item->vehicle_type;
                $newData['vehicle_category']  = $item->vehicle_category;
                // $newData['vehicle_pic']  = $item->vehicle_pic;
                $newData['category_name']  = $item->category_name;
                $newData['minimum_fare']  = $item->minimum_fare;
                $newData['km']  = $item->km;
                $newData['lat']  = $item->lat;
                $newData['long']  = $item->long;
                $newData['active']  = $item->active;
                $newData['day']   = $request->day;
                $newData['available_for_hour']   = $request->hours;
                $newData['total_time']   = '30 Minutes';
                $newData['driver_profile_pic']  = ($item->profile_pic != '' ? url($item->profile_pic) : NULL);
                 $newData['vehicle_pic']  = ($vehicleImage->vehicle_image != '' ? url($vehicleImage->vehicle_image) : NULL);
                array_push($array , $newData);
            }
        }
 $users = User::findOrFail(Auth::user()->id);

        return response()->json(['status' => true ,  'data' => $array , 'users' => $users]);
    }

      // Ride car list
      public function rideCarList(Request $request) {
        $data = AssignToDriver::select("assign_to_drivers.*" , 'users.unique_id' ,'users.name' , 'users.first_name' ,
        'users.last_name' ,  'vehicles.vehicle_number' , 'vehicles.vehicle_seats' , 'vehicles.vehicle_type' ,
        'vehicles.vehicle_category' , 'vehicles.vehicle_pic' , 'categories.category_name' ,
        'fares.minimum_fare' , 'fares.km' , 'users.lat' , 'users.long' , 'users.active' , 'users.phone' ,  'users.profile_pic')
        ->join('users' , 'assign_to_drivers.user_id' , '=' , 'users.id')
        ->join('vehicles' , 'assign_to_drivers.vehicle_id' , '=' , 'vehicles.id')
        ->join('categories' , 'vehicles.vehicle_category' , '=' , 'categories.id')
        ->leftjoin('fares' , 'vehicles.vehicle_category' , '=' , 'fares.category_id')
        // ->where('lat' , '>=' , $request->lat)->where('long' , '<=' , $request->long)
        ->where('users.active' , 1)
        ->where(['vehicles.vehicle_type' => 'ride_car']);
        if(!empty($request->type )){
            if($request->type != "all") {
                $data = $data->where('categories.category_name', 'LIKE', '%'.$request->type.'%');
            }
        }
        $data = $data->get();

        $array = [];
        if($data) {
            foreach($data as $item) {
                $vehicleImage = VehicleImage::where(['vehicle_id' => $item->vehicle_id])->first();
                $newData['id']  = $item->id;
                $newData['vehicle_id']  = $item->vehicle_id;
                $newData['user_id']  = $item->user_id;
                $newData['status']  = $item->status;
                $newData['unique_id']  = $item->unique_id;
                $newData['name']  = $item->name;
                $newData['driver_phone']  = $item->phone;
                $newData['first_name']  = $item->first_name;
                $newData['last_name']  = $item->last_name;
                $newData['vehicle_number']  = $item->vehicle_number;
                $newData['vehicle_seats']  = $item->vehicle_seats;
                $newData['vehicle_type']  = $item->vehicle_type;
                $newData['vehicle_category']  = $item->vehicle_category;
                // $newData['vehicle_pic']  = $item->vehicle_pic;
                $newData['category_name']  = $item->category_name;
                $newData['minimum_fare']  = $item->minimum_fare;
                $newData['km']  = $item->km;
                $newData['lat']  = $item->lat;
                $newData['long']  = $item->long;
                $newData['active']  = $item->active;
                $newData['day']   = $request->day;
                $newData['available_for_hour']   = 6;
                $newData['total_time']   = '30 Minutes';
                 $newData['driver_profile_pic']  = ($item->profile_pic != '' ? url($item->profile_pic) : NULL);
                 $newData['vehicle_pic']  = ($vehicleImage->vehicle_image != '' ? url($vehicleImage->vehicle_image) : NULL);
                array_push($array , $newData);
            }
        }

 $users = User::findOrFail(Auth::user()->id);
        return response()->json(['status' => true ,  'data' => $array ,'users' => $users]);
    }

    /**
     * @method use for bus list
     */
    public function busList(Request $request) {
        $data = AssignToDriver::select("assign_to_drivers.*" , 'users.unique_id' ,'users.name' , 'users.first_name' ,
        'users.last_name' ,  'vehicles.vehicle_number' , 'vehicles.vehicle_seats' , 'vehicles.vehicle_type' ,
        'vehicles.vehicle_category' , 'vehicles.vehicle_pic' , 'categories.category_name' ,
        'fares.minimum_fare' , 'fares.km' , 'users.lat' , 'users.long' , 'users.active' , 'users.phone' ,  'users.profile_pic')
        ->join('users' , 'assign_to_drivers.user_id' , '=' , 'users.id')
        ->join('vehicles' , 'assign_to_drivers.vehicle_id' , '=' , 'vehicles.id')
        ->join('categories' , 'vehicles.vehicle_category' , '=' , 'categories.id')
        ->leftjoin('fares' , 'vehicles.vehicle_category' , '=' , 'fares.category_id')
        // ->where('lat' , '>=' , $request->lat)->where('long' , '<=' , $request->long)
        ->where('users.active' , 1)
        ->where(['vehicles.vehicle_type' => 'bus']);
        if(!empty($request->type )){
            if($request->type != "all") {
                $data = $data->where('categories.category_name', 'LIKE', '%'.$request->type.'%');
            }
        }
        $data = $data->get();
        $array = [];
        if($data) {
            foreach($data as $item) {
                 $vehicleImage = VehicleImage::where(['vehicle_id' => $item->vehicle_id])->first();
                $newData['id']  = $item->id;
                $newData['vehicle_id']  = $item->vehicle_id;
                $newData['user_id']  = $item->user_id;
                $newData['status']  = $item->status;
                $newData['unique_id']  = $item->unique_id;
                $newData['name']  = $item->name;
                $newData['driver_phone']  = $item->phone;
                $newData['first_name']  = $item->first_name;
                $newData['last_name']  = $item->last_name;
                $newData['vehicle_number']  = $item->vehicle_number;
                $newData['vehicle_seats']  = $item->vehicle_seats;
                $newData['vehicle_type']  = $item->vehicle_type;
                $newData['vehicle_category']  = $item->vehicle_category;
                // $newData['vehicle_pic']  = $item->vehicle_pic;
                $newData['category_name']  = $item->category_name;
                $newData['minimum_fare']  = $item->minimum_fare;
                $newData['km']  = $item->km;
                $newData['lat']  = $item->lat;
                $newData['long']  = $item->long;
                $newData['active']  = $item->active;
                $newData['day']   = $request->day;
                $newData['available_for_hour']   = 6;
                $newData['total_time']   = '30 Minutes';
                $newData['driver_profile_pic']  = ($item->profile_pic != '' ? url($item->profile_pic) : NULL);
                 $newData['vehicle_pic']  = ($vehicleImage->vehicle_image != '' ? url($vehicleImage->vehicle_image) : NULL);
                array_push($array , $newData);
            }
        }
         $users = User::findOrFail(Auth::user()->id);

        return response()->json(['status' => true ,  'data' => $array , 'users' => $users]);
    }

    /**
     * @method use for get truck list
     */
    public function truckList(Request $request) {
        $data = AssignToDriver::select("assign_to_drivers.*" , 'users.unique_id' ,'users.name' , 'users.first_name' ,
        'users.last_name' ,  'vehicles.vehicle_number' , 'vehicles.vehicle_seats' , 'vehicles.vehicle_type' ,
        'vehicles.vehicle_category' , 'vehicles.vehicle_pic' , 'categories.category_name' ,
        'fares.minimum_fare' , 'fares.km' , 'users.lat' , 'users.long' , 'users.active' , 'users.phone' ,  'users.profile_pic')
        ->join('users' , 'assign_to_drivers.user_id' , '=' , 'users.id')
        ->join('vehicles' , 'assign_to_drivers.vehicle_id' , '=' , 'vehicles.id')
        ->join('categories' , 'vehicles.vehicle_category' , '=' , 'categories.id')
        ->leftjoin('fares' , 'vehicles.vehicle_category' , '=' , 'fares.category_id')
        // ->where('lat' , '>=' , $request->lat)->where('long' , '<=' , $request->long)
        ->where('users.active' , 1)
        ->where(['vehicles.vehicle_type' => 'truck']);
        if(!empty($request->type )){
            if($request->type != "all") {
                $data = $data->where('categories.category_name', 'LIKE', '%'.$request->type.'%');
            }
        }
        $data = $data->get();

        $array = [];
        if($data) {
            foreach($data as $item) {
                 $vehicleImage = VehicleImage::where(['vehicle_id' => $item->vehicle_id])->first();
                $newData['id']  = $item->id;
                $newData['vehicle_id']  = $item->vehicle_id;
                $newData['user_id']  = $item->user_id;
                $newData['status']  = $item->status;
                $newData['unique_id']  = $item->unique_id;
                $newData['name']  = $item->name;
                $newData['driver_phone']  = $item->phone;
                $newData['first_name']  = $item->first_name;
                $newData['last_name']  = $item->last_name;
                $newData['vehicle_number']  = $item->vehicle_number;
                $newData['vehicle_seats']  = $item->vehicle_seats;
                $newData['vehicle_type']  = $item->vehicle_type;
                $newData['vehicle_category']  = $item->vehicle_category;
                // $newData['vehicle_pic']  = $item->vehicle_pic;
                $newData['category_name']  = $item->category_name;
                $newData['minimum_fare']  = $item->minimum_fare;
                $newData['km']  = $item->km;
                $newData['lat']  = $item->lat;
                $newData['long']  = $item->long;
                $newData['active']  = $item->active;
                $newData['day']   = $request->day;
                $newData['available_for_hour']   = 6;
                $newData['total_time']   = '30 Minutes';
                $newData['driver_profile_pic']  = ($item->profile_pic != '' ? url($item->profile_pic) : NULL);
                 $newData['vehicle_pic']  = ($vehicleImage->vehicle_image != '' ? url($vehicleImage->vehicle_image) : NULL);
                array_push($array , $newData);
            }
        }

        $users = User::findOrFail(Auth::user()->id);
        return response()->json(['status' => true ,  'data' => $array , 'users' => $users]);
    }

    /**
     * @method use for get ambulance list
     */
    public function ambulnaceList(Request $request) {
        $data = AssignToDriver::select("assign_to_drivers.*" , 'users.unique_id' ,'users.name' , 'users.first_name' ,
        'users.last_name' ,  'vehicles.vehicle_number' , 'vehicles.vehicle_seats' , 'vehicles.vehicle_type' ,
        'vehicles.vehicle_category' , 'vehicles.vehicle_pic' , 'categories.category_name' ,
        'fares.minimum_fare' , 'fares.km' , 'users.lat' , 'users.long' , 'users.active' , 'users.phone' ,  'users.profile_pic')
        ->join('users' , 'assign_to_drivers.user_id' , '=' , 'users.id')
        ->join('vehicles' , 'assign_to_drivers.vehicle_id' , '=' , 'vehicles.id')
        ->join('categories' , 'vehicles.vehicle_category' , '=' , 'categories.id')
        ->leftjoin('fares' , 'vehicles.vehicle_category' , '=' , 'fares.category_id')
        // ->where('lat' , '>=' , $request->lat)->where('long' , '<=' , $request->long)
        ->where('users.active' , 1)
        ->where(['vehicles.vehicle_type' => 'ambulance']);
        if(!empty($request->type )){
            if($request->type != "all") {
                $data = $data->where('categories.category_name', 'LIKE', '%'.$request->type.'%');
            }
        }
        $data = $data->get();
        $array = [];
        if($data) {
            foreach($data as $item) {
                 $vehicleImage = VehicleImage::where(['vehicle_id' => $item->vehicle_id])->first();
                $newData['id']  = $item->id;
                $newData['vehicle_id']  = $item->vehicle_id;
                $newData['user_id']  = $item->user_id;
                $newData['status']  = $item->status;
                $newData['unique_id']  = $item->unique_id;
                $newData['name']  = $item->name;
                $newData['driver_phone']  = $item->phone;
                $newData['first_name']  = $item->first_name;
                $newData['last_name']  = $item->last_name;
                $newData['vehicle_number']  = $item->vehicle_number;
                $newData['vehicle_seats']  = $item->vehicle_seats;
                $newData['vehicle_type']  = $item->vehicle_type;
                $newData['vehicle_category']  = $item->vehicle_category;
                // $newData['vehicle_pic']  = $item->vehicle_pic;
                $newData['category_name']  = $item->category_name;
                $newData['minimum_fare']  = $item->minimum_fare;
                $newData['km']  = $item->km;
                $newData['lat']  = $item->lat;
                $newData['long']  = $item->long;
                $newData['active']  = $item->active;
                $newData['day']   = $request->day;
                $newData['available_for_hour']   = 6;
                $newData['total_time']   = '30 Minutes';
                $newData['driver_profile_pic']  = ($item->profile_pic != '' ? url($item->profile_pic) : NULL);
                 $newData['vehicle_pic']  = ($vehicleImage->vehicle_image != '' ? url($vehicleImage->vehicle_image) : NULL);
                array_push($array , $newData);
            }
        }
            $users = User::findOrFail(Auth::user()->id);
        return response()->json(['status' => true ,  'data' => $array , 'users' => $users]);
    }


    /**
     * @param Request $request
     * @method use for store ridecar bookin details
     */
    public function rideCarBooking(Request $request) {
        $validator = Validator::make($request->all() , [
            'vehicle_id'    => 'required',
            'payment_type'  => 'required',
            'user_id'       => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else {

            $invoiceNo = 'INV001'.rand(100000 , 999999);
            $data = new CarBooking();
            $input['user_id']           = $request->user_id;
            $input['driver_id']         = $request->driver_id;
            $input['pickup_location']   = $request->pickup_location;
            $input['destination']       = $request->destination;
            $input['vehicle_id']        = $request->vehicle_id;
            $input['payment_type']      = $request->payment_type;
            $input['total_fare']        = $request->total_fare;
            $input['total_distance']    = $request->total_distance;
            $input['invoice_id']        = $invoiceNo;
            $input['otp']               = 1234;
            $input['booking_type']      = 'ride';
            $input['ride_type']      = $request->ride_type;

            $resutl = $data->fill($input)->save();

            $getDetails = CarBooking::select("car_bookings.*" , 'users.name' , 'users.phone' , 'users.unique_id' , 'vehicles.vehicle_number')
            ->join("users" , 'car_bookings.driver_id' , '=' , 'users.id')
            ->join("vehicles" , 'car_bookings.vehicle_id' , '=' , 'vehicles.id')
            ->where(['car_bookings.id' => $data->id])->first();

            $dataArray = [];
            $dataArray['dirver_name']   = $getDetails->name;
            $dataArray['dirver_phone']  = $getDetails->phone;
            $dataArray['invoice_id']    = $getDetails->invoice_id;
            $dataArray['total_fare']    = $getDetails->total_fare;
            $dataArray['total_distance']= $getDetails->total_distance;
            $dataArray['payment_type']  = $getDetails->payment_type;
            $dataArray['car_number']    = $getDetails->vehicle_number;
            $dataArray['status']        = $getDetails->booking_status;
            $dataArray['opt']           = $getDetails->otp;
            // $dataArray['unique_id']     = $request->unique_id;
            $dataArray['ride_type']   = $getDetails->ride_type;
            $dataArray['dirver_unique_id']     = $getDetails->unique_id;
            return response()->json(['status' => true , 'data' => $dataArray]);
        }
    }

    /**
     * @param Request $request
     * @method use for store schedule car booking
     */
    public function scheduleCarBooking(Request $request) {
        $validator = Validator::make($request->all() , [
            'vehicle_id'    => 'required',
            'user_id'       => 'required',
            'pickup_date'   => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else {

            $invoiceNo = 'INV001'.rand(100000 , 999999);
            $data = new CarBooking();
            $input['user_id']           = $request->user_id;
            $input['driver_id']         = $request->driver_id;
            $input['pickup_location']   = $request->pickup_location;
            $input['destination']       = $request->destination;
            $input['vehicle_id']        = $request->vehicle_id;
            $input['payment_type']      = $request->payment_type;
            $input['total_fare']        = $request->total_fare;
            $input['total_distance']    = $request->total_distance;
            $input['invoice_id']        = $invoiceNo;
            $input['otp']               = 1234;
            $input['booking_type']      = 'schedule';
            $input['trip_type']         = $request->trip_type;
            $input['pickup_date']       = $request->pickup_date;
            $input['pickup_time']       = $request->pickup_time;
            $input['return_date']       = $request->return_date;
            $input['return_time']       = $request->return_time;
            $input['ride_type']      = $request->ride_type;
            $resutl = $data->fill($input)->save();

            $getDetails = CarBooking::select("car_bookings.*" , 'users.name' , 'users.phone' , 'users.unique_id' , 'vehicles.vehicle_number')
            ->join("users" , 'car_bookings.driver_id' , '=' , 'users.id')
            ->join("vehicles" , 'car_bookings.vehicle_id' , '=' , 'vehicles.id')
            ->where(['car_bookings.id' => $data->id])->first();

            $dataArray = [];
            $dataArray['dirver_name']   = $getDetails->name;
            $dataArray['dirver_phone']  = $getDetails->phone;
            $dataArray['invoice_id']    = $getDetails->invoice_id;
            $dataArray['total_fare']    = $getDetails->total_fare;
            $dataArray['total_distance']= $getDetails->total_distance;
            // $dataArray['payment_type']  = $getDetails->payment_type;
            $dataArray['car_number']    = $getDetails->vehicle_number;
            $dataArray['status']        = $getDetails->booking_status;
            $dataArray['opt']           = $getDetails->otp;
            // $dataArray['unique_id']     = $getDetails->unique_id;
            $dataArray['trip_type']     = $getDetails->trip_type;
            $dataArray['pickup_date']   = $getDetails->pickup_date;
            $dataArray['pickup_time']   = $getDetails->pickup_time;
            $dataArray['return_date']   = $getDetails->return_date;
            $dataArray['return_time']   = $getDetails->return_time;
            $dataArray['ride_type']   = $getDetails->ride_type;
            $dataArray['dirver_unique_id']     = $getDetails->unique_id;
            return response()->json(['status' => true , 'data' => $dataArray]);
        }
    }

    /**
     * @param Request $request
     * @method use for store hourly car booking
     */
    public function hourlyCarBooking(Request $request) {
        $validator = Validator::make($request->all() , [
            'vehicle_id'    => 'required',
            'user_id'       => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else {

            $invoiceNo = 'INV001'.rand(100000 , 999999);
            $data = new CarBooking();
            $input['user_id']           = $request->user_id;
            $input['driver_id']         = $request->driver_id;
            $input['pickup_location']   = $request->pickup_location;
            $input['vehicle_id']        = $request->vehicle_id;
            $input['total_fare']        = $request->total_fare;
            $input['invoice_id']        = $invoiceNo;
            $input['otp']               = 1234;
            $input['booking_type']      = 'hourly';
            $input['trip_type']         = $request->trip_type;
            $input['total_booking_hour']= $request->total_hour;
            $input['ride_type']      = $request->ride_type;
            $resutl = $data->fill($input)->save();

            $getDetails = CarBooking::select("car_bookings.*" , 'users.name' , 'users.phone' , 'users.unique_id' , 'vehicles.vehicle_number')
            ->join("users" , 'car_bookings.driver_id' , '=' , 'users.id')
            ->join("vehicles" , 'car_bookings.vehicle_id' , '=' , 'vehicles.id')
            ->where(['car_bookings.id' => $data->id])->first();

            $dataArray = [];
            $dataArray['dirver_name']   = $getDetails->name;
            $dataArray['dirver_phone']  = $getDetails->phone;
            $dataArray['invoice_id']    = $getDetails->invoice_id;
            $dataArray['total_fare']    = $getDetails->total_fare;
            $dataArray['total_hour']    = $getDetails->total_booking_hour;
            // $dataArray['payment_type']  = $getDetails->payment_type;
            $dataArray['car_number']    = $getDetails->vehicle_number;
            $dataArray['status']        = $getDetails->booking_status;
            $dataArray['opt']           = $getDetails->otp;
            // $dataArray['unique_id']     = $getDetails->unique_id;
            $dataArray['trip_type']     = $getDetails->trip_type;
            $dataArray['ride_type']   = $getDetails->ride_type;
            $dataArray['dirver_unique_id']     = $getDetails->unique_id;
            return response()->json(['status' => true , 'data' => $dataArray]);
        }
    }


     /**
     * @param Request $request
     * @method use for store intercity car booking
     */
    public function intercityCarBooking(Request $request) {
        $validator = Validator::make($request->all() , [
            'vehicle_id'    => 'required',
            'user_id'       => 'required',
            'pickup_date'   => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else {

            $invoiceNo = 'INV001'.rand(100000 , 999999);
            $data = new CarBooking();
            $input['user_id']           = $request->user_id;
            $input['driver_id']         = $request->driver_id;
            $input['pickup_location']   = $request->pickup_location;
            $input['destination']       = $request->destination;
            $input['vehicle_id']        = $request->vehicle_id;
            $input['payment_type']      = $request->payment_type;
            $input['total_fare']        = $request->total_fare;
            $input['total_distance']    = $request->total_distance;
            $input['invoice_id']        = $invoiceNo;
            $input['otp']               = 1234;
            $input['booking_type']      = 'intercity';
            $input['trip_type']         = $request->trip_type;
            $input['pickup_date']       = $request->pickup_date;
            $input['pickup_time']       = $request->pickup_time;
            $input['return_date']       = $request->return_date;
            $input['return_time']       = $request->return_time;
            $input['ride_type']      = $request->ride_type;
            $resutl = $data->fill($input)->save();

            $getDetails = CarBooking::select("car_bookings.*" , 'users.name' , 'users.phone' , 'users.unique_id' , 'vehicles.vehicle_number')
            ->join("users" , 'car_bookings.driver_id' , '=' , 'users.id')
            ->join("vehicles" , 'car_bookings.vehicle_id' , '=' , 'vehicles.id')
            ->where(['car_bookings.id' => $data->id])->first();

            $dataArray = [];
            $dataArray['dirver_name']   = $getDetails->name;
            $dataArray['dirver_phone']  = $getDetails->phone;
            $dataArray['invoice_id']    = $getDetails->invoice_id;
            $dataArray['total_fare']    = $getDetails->total_fare;
            $dataArray['total_distance']= $getDetails->total_distance;
            // $dataArray['payment_type']  = $getDetails->payment_type;
            $dataArray['car_number']    = $getDetails->vehicle_number;
            $dataArray['status']        = $getDetails->booking_status;
            $dataArray['opt']           = $getDetails->otp;
            // $dataArray['unique_id']     = $getDetails->unique_id;
            $dataArray['trip_type']     = $getDetails->trip_type;
            $dataArray['pickup_date']   = $getDetails->pickup_date;
            $dataArray['pickup_time']   = $getDetails->pickup_time;
            $dataArray['return_date']   = $getDetails->return_date;
            $dataArray['return_time']   = $getDetails->return_time;
            $dataArray['ride_type']   = $getDetails->ride_type;
            $dataArray['dirver_unique_id']     = $getDetails->unique_id;
            return response()->json(['status' => true , 'data' => $dataArray]);
        }
    }


     /**
     * @param Request $request
     * @method use for store intercity car booking
     */
    public function rentalCarBooking(Request $request) {
        $validator = Validator::make($request->all() , [
            'vehicle_id'    => 'required',
            'user_id'       => 'required',
            'pickup_date'   => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else {

            $invoiceNo = 'INV001'.rand(100000 , 999999);
            $data = new CarBooking();
            $input['user_id']           = $request->user_id;
            $input['driver_id']         = $request->driver_id;
            $input['pickup_location']   = $request->pickup_location;
            $input['destination']       = $request->destination;
            $input['vehicle_id']        = $request->vehicle_id;
            $input['payment_type']      = $request->payment_type;
            $input['total_fare']        = $request->total_fare;
            $input['total_distance']    = $request->total_distance;
            $input['invoice_id']        = $invoiceNo;
            $input['otp']               = 1234;
            $input['booking_type']      = 'rental';
            $input['trip_type']         = $request->trip_type;
            $input['pickup_date']       = $request->pickup_date;
            $input['pickup_time']       = $request->pickup_time;
            $input['return_date']       = $request->return_date;
            $input['return_time']       = $request->return_time;
            $input['total_day']         = $request->total_day;
            $input['ride_type']      = $request->ride_type;
            $resutl = $data->fill($input)->save();

            $getDetails = CarBooking::select("car_bookings.*" , 'users.name' , 'users.phone' , 'users.unique_id' , 'vehicles.vehicle_number')
            ->join("users" , 'car_bookings.driver_id' , '=' , 'users.id')
            ->join("vehicles" , 'car_bookings.vehicle_id' , '=' , 'vehicles.id')
            ->where(['car_bookings.id' => $data->id])->first();

            $dataArray = [];
            $dataArray['dirver_name']   = $getDetails->name;
            $dataArray['dirver_phone']  = $getDetails->phone;
            $dataArray['invoice_id']    = $getDetails->invoice_id;
            $dataArray['total_fare']    = $getDetails->total_fare;
            $dataArray['total_distance']= $getDetails->total_distance;
            // $dataArray['payment_type']  = $getDetails->payment_type;
            $dataArray['car_number']    = $getDetails->vehicle_number;
            $dataArray['status']        = $getDetails->booking_status;
            $dataArray['opt']           = $getDetails->otp;
            // $dataArray['unique_id']     = $getDetails->unique_id;
            $dataArray['trip_type']     = $getDetails->trip_type;
            $dataArray['pickup_date']   = $getDetails->pickup_date;
            $dataArray['pickup_time']   = $getDetails->pickup_time;
            $dataArray['return_date']   = $getDetails->return_date;
            $dataArray['return_time']   = $getDetails->return_time;
            $dataArray['total_day']     = $getDetails->total_day;
            $dataArray['ride_type']   = $getDetails->ride_type;
            $dataArray['dirver_unique_id']     = $getDetails->unique_id;
            return response()->json(['status' => true , 'data' => $dataArray]);
        }
    }


     /**
     * @param Request $request
     * @method use for store bus car booking
     */
    public function busBookingBooking(Request $request) {
        $validator = Validator::make($request->all() , [
            'vehicle_id'    => 'required',
            'user_id'       => 'required',
            'pickup_date'   => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else {

            $invoiceNo = 'INV001'.rand(100000 , 999999);
            $data = new CarBooking();
            $input['user_id']           = $request->user_id;
            $input['driver_id']         = $request->driver_id;
            $input['pickup_location']   = $request->pickup_location;
            $input['destination']       = $request->destination;
            $input['vehicle_id']        = $request->vehicle_id;
            $input['payment_type']      = $request->payment_type;
            $input['total_fare']        = $request->total_fare;
            $input['total_distance']    = $request->total_distance;
            $input['invoice_id']        = $invoiceNo;
            $input['otp']               = 1234;
            $input['booking_type']      = 'bus';
            $input['trip_type']         = $request->trip_type;
            $input['pickup_date']       = $request->pickup_date;
            $input['pickup_time']       = $request->pickup_time;
            $input['return_date']       = $request->return_date;
            $input['return_time']       = $request->return_time;
            $input['ride_type']      = $request->ride_type;
            $resutl = $data->fill($input)->save();

            $getDetails = CarBooking::select("car_bookings.*" , 'users.name' , 'users.phone' , 'users.unique_id' , 'vehicles.vehicle_number')
            ->join("users" , 'car_bookings.driver_id' , '=' , 'users.id')
            ->join("vehicles" , 'car_bookings.vehicle_id' , '=' , 'vehicles.id')
            ->where(['car_bookings.id' => $data->id])->first();

            $dataArray = [];
            $dataArray['dirver_name']   = $getDetails->name;
            $dataArray['dirver_phone']  = $getDetails->phone;
            $dataArray['invoice_id']    = $getDetails->invoice_id;
            $dataArray['total_fare']    = $getDetails->total_fare;
            $dataArray['total_distance']= $getDetails->total_distance;
            // $dataArray['payment_type']  = $getDetails->payment_type;
            $dataArray['car_number']    = $getDetails->vehicle_number;
            $dataArray['status']        = $getDetails->booking_status;
            $dataArray['opt']           = $getDetails->otp;
            // $dataArray['unique_id']     = $getDetails->unique_id;
            $dataArray['trip_type']     = $getDetails->trip_type;
            $dataArray['pickup_date']   = $getDetails->pickup_date;
            $dataArray['pickup_time']   = $getDetails->pickup_time;
            $dataArray['ride_type']   = $getDetails->ride_type;
            $dataArray['dirver_unique_id']     = $getDetails->unique_id;
            // $dataArray['return_date']   = $getDetails->return_date;
            // $dataArray['return_time']   = $getDetails->return_time;
            return response()->json(['status' => true , 'data' => $dataArray]);
        }
    }


    /**
     * @method use for truck booking list
     */
    public function truckBookingBooking(Request $request) {
        $validator = Validator::make($request->all() , [
            'vehicle_id'    => 'required',
            'user_id'       => 'required',
            'pickup_date'   => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else {

            $invoiceNo = 'INV001'.rand(100000 , 999999);
            $data = new CarBooking();
            $input['user_id']           = $request->user_id;
            $input['driver_id']         = $request->driver_id;
            $input['pickup_location']   = $request->pickup_location;
            $input['destination']       = $request->destination;
            $input['vehicle_id']        = $request->vehicle_id;
            $input['payment_type']      = $request->payment_type;
            $input['total_fare']        = $request->total_fare;
            $input['total_distance']    = $request->total_distance;
            $input['invoice_id']        = $invoiceNo;
            $input['otp']               = 1234;
            $input['booking_type']      = 'truck';
            $input['trip_type']         = $request->trip_type;
            $input['pickup_date']       = $request->pickup_date;
            $input['pickup_time']       = $request->pickup_time;
            $input['return_date']       = $request->return_date;
            $input['return_time']       = $request->return_time;
            $input['ride_type']      = $request->ride_type;
            $resutl = $data->fill($input)->save();

            $getDetails = CarBooking::select("car_bookings.*" , 'users.name' , 'users.phone' , 'users.unique_id' , 'vehicles.vehicle_number')
            ->join("users" , 'car_bookings.driver_id' , '=' , 'users.id')
            ->join("vehicles" , 'car_bookings.vehicle_id' , '=' , 'vehicles.id')
            ->where(['car_bookings.id' => $data->id])->first();

            $dataArray = [];
            $dataArray['dirver_name']   = $getDetails->name;
            $dataArray['dirver_phone']  = $getDetails->phone;
            $dataArray['invoice_id']    = $getDetails->invoice_id;
            $dataArray['total_fare']    = $getDetails->total_fare;
            $dataArray['total_distance']= $getDetails->total_distance;
            // $dataArray['payment_type']  = $getDetails->payment_type;
            $dataArray['car_number']    = $getDetails->vehicle_number;
            $dataArray['status']        = $getDetails->booking_status;
            $dataArray['opt']           = $getDetails->otp;
            // $dataArray['unique_id']     = $getDetails->unique_id;
            $dataArray['trip_type']     = $getDetails->trip_type;
            $dataArray['pickup_date']   = $getDetails->pickup_date;
            $dataArray['pickup_time']   = $getDetails->pickup_time;
            $dataArray['ride_type']   = $getDetails->ride_type;
            $dataArray['dirver_unique_id']     = $getDetails->unique_id;
            // $dataArray['return_date']   = $getDetails->return_date;
            // $dataArray['return_time']   = $getDetails->return_time;
            return response()->json(['status' => true , 'data' => $dataArray]);
        }
    }

     /**
     * @method use for ambulance booking list
     */
    public function ambulanceBookingBooking(Request $request) {
        $validator = Validator::make($request->all() , [
            'vehicle_id'    => 'required',
            'user_id'       => 'required',
            'pickup_date'   => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else {

            $invoiceNo = 'INV001'.rand(100000 , 999999);
            $data = new CarBooking();
            $input['user_id']           = $request->user_id;
            $input['driver_id']         = $request->driver_id;
            $input['pickup_location']   = $request->pickup_location;
            $input['destination']       = $request->destination;
            $input['vehicle_id']        = $request->vehicle_id;
            $input['payment_type']      = $request->payment_type;
            $input['total_fare']        = $request->total_fare;
            $input['total_distance']    = $request->total_distance;
            $input['invoice_id']        = $invoiceNo;
            $input['otp']               = 1234;
            $input['booking_type']      = 'ambulance';
            $input['trip_type']         = $request->trip_type;
            $input['pickup_date']       = $request->pickup_date;
            $input['pickup_time']       = $request->pickup_time;
            $input['return_date']       = $request->return_date;
            $input['return_time']       = $request->return_time;
              $input['ride_type']      = $request->ride_type;
            $resutl = $data->fill($input)->save();

            $getDetails = CarBooking::select("car_bookings.*" , 'users.name' , 'users.phone' , 'users.unique_id' , 'vehicles.vehicle_number')
            ->join("users" , 'car_bookings.driver_id' , '=' , 'users.id')
            ->join("vehicles" , 'car_bookings.vehicle_id' , '=' , 'vehicles.id')
            ->where(['car_bookings.id' => $data->id])->first();

            $dataArray = [];
            $dataArray['dirver_name']   = $getDetails->name;
            $dataArray['dirver_phone']  = $getDetails->phone;
            $dataArray['invoice_id']    = $getDetails->invoice_id;
            $dataArray['total_fare']    = $getDetails->total_fare;
            $dataArray['total_distance']= $getDetails->total_distance;
            // $dataArray['payment_type']  = $getDetails->payment_type;
            $dataArray['car_number']    = $getDetails->vehicle_number;
            $dataArray['status']        = $getDetails->booking_status;
            $dataArray['opt']           = $getDetails->otp;

            $dataArray['trip_type']     = $getDetails->trip_type;
            $dataArray['pickup_date']   = $getDetails->pickup_date;
            $dataArray['pickup_time']   = $getDetails->pickup_time;
            $dataArray['ride_type']   = $getDetails->ride_type;
            $dataArray['dirver_unique_id']     = $getDetails->unique_id;
            // $dataArray['return_date']   = $getDetails->return_date;
            // $dataArray['return_time']   = $getDetails->return_time;
            return response()->json(['status' => true , 'data' => $dataArray]);
        }
    }

    /**
     * @method use for booking cancelled process
     */
    public function bookingCancelled(Request $request) {
        $validator = Validator::make($request->all() , [
            'invoice_number' => 'required',
            'user_id'        => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else {

            $data = CarBooking::where(['invoice_id' => $request->invoice_number , 'user_id' => $request->user_id])->first();
            $data->booking_status = 'cancelled';
            $update = $data->update();
        }
        if($update) {
            return response()->json(['status' => true , 'msg' => 'Booking cancelled successfully']);
            exit;
        }
        else {
            return response()->json(['status' => false , 'msg' => 'Something went wrong try again later!!!']);
            exit;
        }
    }
       /**
     * @method use for get car list
     */
    public function typeOfCar() {
       $data = Category::select("categories.*" , 'fares.minimum_fare')
        ->join("fares" , "categories.id" , "=" , "fares.category_id")
        ->get();
        $array = [];
        if($data) {
            foreach($data as $item) {
                
                $newData['id']  = $item->id;
                $newData['name']  = $item->category_name;
                $newData['per_person']  = $item->person;
                $newData['fare_per_km']  = $item->minimum_fare;
                 $newData['category_icon']  =  ($item->category_icon != '' ?url($item->category_icon) : NULL);
                  $newData['category_image']  = ($item->category_image != '' ? url($item->category_image) : NULL );
                array_push($array , $newData);
            }
        }
        return response()->json(['data' => $array]);
    }
}

