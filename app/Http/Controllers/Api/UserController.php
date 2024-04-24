<?php

namespace App\Http\Controllers\Api;

use App\Events\NewRideRequest;
use App\Models\DriverLocation;
use App\Models\Fare;
use App\Models\Type;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Category;
use App\Helpers\MyHelper;
use App\Models\CarBooking;
use App\Models\FareCategory;
use Illuminate\Http\Request;
use App\Models\VehicleImage;
use App\Models\AssignToDriver;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ReferralController;
use App\Models\Referral;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //

    public function rideType(Request $request)
    {

        $types    = Type::where('t_status', 'APPROVED')->get();
        $response = [
            'success' => true,
            'data'    => $types,
            'user_id' => 0,
        ];
        return response()->json($response, 200);

    }

    public function GetCategory(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'type_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            exit;
        }

        $categories = Category::where('type_id', $request->type_id)->get();

        $array = [];
        if ($categories) {
            foreach ($categories as $item) {
                $newData['id']              = $item->id;
                $newData['category_name']   = $item->category_name;
                $newData['category_icon']   = ($item->category_icon != '' ? url($item->category_icon) : NULL);
                $newData['category_image']  = ($item->category_image != '' ? url($item->category_image) : NULL);
                $newData['category_status'] = $item->category_status;
                $newData['person']          = $item->person;
                array_push($array, $newData);
            }
        }
        $response = [
            'success' => true,
            'data'    => $array,
            'user_id' => 0,
        ];
        return response()->json($response, 200);

    }

    public function Getvehicle1(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'vehicle_type_id' => 'required',
            'ride_type_id'    => 'required',
            'payment_type'    => 'required',
            'rider_id'        => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            exit;
        }

        $type_id     = $request->ride_type_id;
        $category_id = $request->vehicle_type_id;
        $pick_lat    = $request->pick_up_location_lat;
        $pick_lng    = $request->pick_up_location_lng;

        $time = date('H');

        $id = FareCategory::where('start_time', '<=', $time)->where('end_time', '>=', $time)->where('status', 'ACTIVE')->first();

        $fare = Fare::where(['fare_category_id' => $id->id, 'type_id' => $type_id, 'category_id' => $category_id])->first();

        $drivers = MyHelper::findNearestusers($pick_lat, $pick_lng)->pluck('id');

        $vehicles = Vehicle::select('vehicles.*', 'categories.category_name', 'types.t_name', 'users.*')
            ->join('categories', 'vehicles.vehicle_category', '=', 'categories.id')
            ->join('types', 'vehicles.vehicle_type', '=', 'types.id')
            ->join('users', 'vehicles.user_assign', '=', 'users.id')
            ->whereIn('user_assign', $drivers)
            ->where('vehicles.vehicle_category', $category_id)
            ->where('vehicles.vehicle_type', $type_id)
            ->where('vehicles.booking_status', 'available')->get();

        $data                         = new CarBooking();
        $input['user_id']             = $request->rider_id;
        $input['pickup_location']     = $request->pickUpAddress;
        $input['drop_location']       = $request->dropOffAddress;
        $input['pickup_location_lat'] = $request->pick_up_location_lat;
        $input['pickup_location_lng'] = $request->pick_up_location_lng;
        $input['drop_location_lat']   = $request->drop_off_location_lat;
        $input['drop_location_lng']   = $request->drop_off_location_lng;
        $input['invoice_id']          = 'INV001' . rand(100000, 999999);
        $input['otp']                 = rand(1000, 9999);
        $input['type_id']             = $request->ride_type_id;
        $input['category_id']         = $request->vehicle_type_id;

        $resutl = $data->fill($input)->save();

        $array = [];
        if ($vehicles) {
            foreach ($vehicles as $item) {
                $newData['id']                 = $item->id;
                $newData['category_name']      = $item->category_name;
                $newData['ride_type_name']     = $item->t_name;
                $newData['vehicle_pic']        = ($item->vehicle_pic != '' ? url($item->vehicle_pic) : NULL);
                $newData['vehicle_number']     = $item->vehicle_number;
                $newData['vehicle_brand']      = $item->vehicle_brand;
                $newData['vehicle_model']      = $item->vehicle_model;
                $newData['vehicle_color']      = $item->vehicle_color;
                $newData['vehicle_seats']      = $item->vehicle_seats;
                $newData['driver_name']        = $item->name;
                $newData['driver_phone']       = $item->phone;
                $newData['driver_profile_pic'] = ($item->profile_pic != '' ? url($item->profile_pic) : NULL);
                $newData['per_km']             = $fare->km;
                $newData['per_hour_fare']      = $fare->per_hour_fare;
                $newData['minimum_fare']       = $fare->minimum_fare;
                array_push($array, $newData);
            }
        }
        $response = [
            'success' => true,
            'data'    => $array,
            'user_id' => 0,
        ];
        return response()->json($response, 200);

    }


    public function register(Request $request)
    {
        if (! $request->isMethod('post')) {

            $data = [
                'first_name'       => '',
                'last_name'        => '',
                'email'            => '',
                'phone'            => '',
                'emergency_number' => '',
                'city'             => '',
                'gender'           => '',
                'profile_image'    => '',
                'password'         => '',
            ];

            $response = [
                'success' => true,
                'data'    => $data,
                'user_id' => 0,
            ];
            return response()->json($response, 200);
        } else {
            $rules     = [
                'first_name'       => 'required',
                'last_name'        => 'required',
                'phone'            => 'required|numeric|unique:users,phone',
                'emergency_number' => 'required|numeric',
                'email'            => 'required|unique:users,email',
                'gender'           => 'required',
                'user_type'        => 'required|in:user,driver',
                'password'         => 'required|min:4',
                'profile_pic'      => 'nullable|file',
                'referred_code'    => ['nullable', 'digits:6', 'exists:users,referral_code'],
                'term_agreed'      => 'boolean',
            ];
            $msg       = [
                'first_name.required'       => 'Enter First Name',
                'last_name.required'        => 'Enter Last Name',
                'phone.required'            => 'Enter Your Phone number',
                'emergency_number.required' => 'Enter Your Emergency number',
                'email.required'            => 'Enter Your Email',
            ];
            $validator = Validator::make($request->all(), $rules, $msg);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
                exit;
            } else {
                DB::beginTransaction();

                try {
                    if ($request->file('profile_pic')) {
                        $fileName = '/assets/user/' . uniqid(time()) . '.' . $request->file('profile_pic')->extension();
                        $request->file('profile_pic')->move(public_path('assets/user/'), $fileName);
                        $profile = $fileName;
                    } else {
                        $profile = "";
                    }

                    /**
                     * Create Primary Unique Refer Code
                     * @var int $referralCode
                     */
                    $referralCode = ReferralController::generateUniqueCode();


                    $verification_code           = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
                    $data                        = new User();
                    $input['first_name']         = $request->first_name;
                    $input['last_name']          = $request->last_name;
                    $input['email']              = $request->email;
                    $input['phone']              = $request->phone;
                    $input['address']            = $request->city;
                    $input['password']           = Hash::make($request->password);
                    $input['gender']             = $request->gender;
                    $input['emergency_number']   = $request->emergency_number;
                    $input['profile_pic']        = $profile;
                    $input['name']               = $request->first_name . ' ' . $request->last_name;
                    $input['user_type']          = "USER";
                    $input['username']           = $request->email;
                    $input['verification_code']  = $verification_code;
                    $input['user_register_from'] = "APP";
                    $input['referral_code']      = $referralCode;

                    $input['licence_number']    = $request->licence_number;
                    $input['car_owner_mobile']  = $request->car_owner_mobile;
                    $input['car_model']         = $request->car_model;
                    $input['car_brand']         = $request->car_brand;
                    $input['car_cc']            = $request->car_cc;
                    $input['car_number']        = $request->car_number;
                    $input['car_register_year'] = $request->car_register_year;
                    $input['verification_code'] = $request->verification_code;

                    $input['ride_service'] = $request->ride_service;
                    $input['ride_package'] = $request->ride_package;

                    $result = $data->fill($input)->save();


                    /**
                     * Store a new referral.
                     * @author Fxc Jahid <fxcjahid3@gmail.com> 
                     * @param array $data 
                     */
                    if (! empty($request->referred_code)) {

                        Referral::store([
                            'referral_code' => $request->referred_code,
                            'referred_id'   => $data->id,
                            'status'        => Referral::STATUS_PENDING,
                        ]);
                    }

                    $sms = send_otp($request->phone, $verification_code);

                    DB::commit();

                    return response()->json([
                        'status'  => 200,
                        'message' => 'User register Successfully',
                        'data'    => $data,
                    ]);

                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['status' => false, 'message' => $e->getMessage()]);
                }
            }
        }
    }

    public function otp_verification(Request $request)
    {

        $rules     = [
            'user_id'           => 'required|numeric|exists:users,id',
            'verification_code' => 'required|numeric',
        ];
        $msg       = [
            'user_id.required'           => 'User not Found',
            'verification_code.required' => 'Your Verification code is not Valid',
        ];
        $validator = Validator::make($request->all(), $rules, $msg);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            exit;
        }

        $validatedData = $validator->validated();

        $user = User::find($validatedData['user_id']);

        if ($user->verification_code == $validatedData['verification_code']) {
            // Authentication successful, generate token
            $token            = Str::random(80);
            $success['token'] = $user->createToken($token)->plainTextToken;
            $success['name']  = $user->name;
            $success['id']    = $user->id;

            return response()->json(['status' => 200, 'message' => 'User login successfully.', 'data' => $success]);
        }

        return response()->json(['status' => false, 'message' => 'Authentication failed.']);


    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user'     => ['required', 'string', function ($attribute, $value, $fail) {
                if (! filter_var($value, FILTER_VALIDATE_EMAIL) && ! is_numeric($value)) {
                    $fail('The ' . $attribute . ' field must be a valid email address or a phone number.');
                }
            }],
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $credentials = [
            'password' => $request->password,
        ];

        // Check if the user input is numeric, if so, treat it as a phone number
        if (is_numeric($request->user)) {
            $credentials['phone'] = $request->user;
        } else {
            $credentials['email'] = $request->user;
        }

        if (Auth::attempt($credentials)) {
            $user             = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['user']  = $user;
            return response()->json(['status' => 200, 'message' => 'User login successfully.', 'data' => $success]);
        } else {
            return response()->json(['status' => false, 'message' => "Credentials Not Match!!"]);
        }
    }


    /**
     * @param Request $request
     * @method use for update profile
     */
    public function profileUpdate(Request $request)
    {

        $userData = User::findOrFail($request->user_id);
        $rules    = [];

        if ($userData->phone != $request->phone) {
            $rules['phone'] = 'required|unique:users,phone';
        }
        if ($userData->email != $request->email) {
            $rules['email'] = 'required|unique:users,username';
        }
        $rules     = [
            'first_name' => 'required',
            'last_name'  => 'required',
            'city'       => 'required',
            'user_id'    => 'required',
        ];
        $msg       = [
            'first_name.required' => 'Enter First Name',
            'last_name.required'  => 'Enter Last Name',
            'city.required'       => 'Enter Your City Name',
        ];
        $validator = Validator::make($request->all(), $rules, $msg);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            exit;
        } else {
            if ($request->user_id == Auth::user()->id) {
                $userData->first_name       = $request->first_name;
                $userData->last_name        = $request->last_name;
                $userData->phone            = $request->phone;
                $userData->emergency_number = $request->emergency_number;
                $userData->name             = $request->first_name . '' . $request->last_name;
                $userData->username         = $request->email;
                $userData->address          = $request->city;

                $update = $userData->update();
            } else {
                return response()->json(['status' => false, 'message' => 'Something went wrong try again later']);
                exit;
            }

        }
        if ($update) {
            return response()->json(['status' => 200, 'message' => 'User updated Successfully', 'data' => $userData]);
            exit;
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong try again later']);
            exit;
        }

    }

    /**
     * @method use for get user
     */

    public function nearbyVehicle(Request $request)
    {
        $user = User::findOrfail($request->user_id);
        $lat  = $request->lat;
        $long = $request->long;

        $driver = User::where('user_type', 'DRIVER')->whereNotNull('lat')->select('ride_service', 'lat', 'long')->get();

        return response()->json(['status' => 200, 'data' => $driver]);
    }


    public function userDetail(Request $request)
    {
        try {
            if ($request->id == Auth::user()->id) {
                $user = User::findOrfail($request->id);

                $data                     = [];
                $data['id']               = $user->id;
                $data['unique_id']        = $user->unique_id;
                $data['name']             = $user->name;
                $data['email']            = $user->email;
                $data['username']         = $user->username;
                $data['first_name']       = $user->first_name;
                $data['last_name']        = $user->last_name;
                $data['phone']            = $user->phone;
                $data['profile_pic']      = url($user->profile_pic);
                $data['address']          = $user->address;
                $data['wallet']           = $user->wallet;
                $data['gender']           = $user->gender;
                $data['emergency_number'] = $user->emergency_number;

                return response()->json(['status' => 200, 'data' => $data]);
            } else {
                return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
                exit;
            }

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
            exit;
        }
    }

    /**
     * @param Request $request
     * @method use for update password
     */
    public function password_update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),

            [
                'current_password' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (! Hash::check($value, Auth::user()->password)) {
                            $fail('Current Password didn\'t match');
                        }
                    },
                ],
                'new_password'     => 'min:4|required_with:confirm_password|different:current_password|same:confirm_password',
                'confirm_password' => 'min:4',
            ],

        );
        if ($validator->fails()) {
            return response()->json(array('status' => false, 'msg' => $validator->errors()->first()));
            exit;
        }
        if ($request->user_id == Auth::user()->id) {
            $n_pass = $request->new_password;
            $bool   = DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['password' => Hash::make($n_pass)]);
        } else {
            return response()->json(array('status' => false, 'msg' => "User id not exists, please try again."));
            exit;
        }

        if ($bool) {
            return response()->json(array('status' => true, 'msg' => "Password Updated Successfully"));
            exit;

        } else {
            return response()->json(array('status' => false, 'msg' => "Error occurred, please try again."));
            exit;
        }
    }

    /**
     * @method use for get user emergency number
     */
    public function userEmergencyNumber(Request $request)
    {

        if ($request->id == Auth::user()->id) {
            $user = User::findOrFail(Auth::user()->id);
            return response()->json(['status' => 200, 'emergency_number' => $user->emergency_number]);
        } else {
            return response()->json(['status' => false, 'msg' => "Error occurred, please try again."]);
        }

    }

    /**
     * @param Request $request
     * @method use for update user emergency number
     */
    public function updateUserEmergencyNumber(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'emergency_number' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(array('status' => false, 'msg' => $validator->errors()->first()));
            exit;
        } else {
            if ($request->user_id == Auth::user()->id) {
                $user                   = User::findOrFail(Auth::user()->id);
                $user->emergency_number = $request->emergency_number;

                $update = $user->update();
            } else {
                return response()->json(['status' => false, 'message' => 'Something went wrong try again later']);
                exit;
            }

        }
        if ($update) {
            return response()->json(['status' => 200, 'message' => 'Emergency Number updated successfully']);
            exit;
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong try again later']);
            exit;
        }
    }

    /**
     * @method use for upload profile pic
     */
    public function profileUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(array('status' => false, 'msg' => $validator->errors()->first()));
            exit;
        } else {
            if ($request->user_id == Auth::user()->id) {
                if ($request->file('profile_image')) {
                    // Delete
                    File::delete(public_path('../' . Auth::user()->profile_pic));
                    $fileName = '/assets/user/' . uniqid(time()) . '.' . $request->file('profile_image')->extension();
                    $request->file('profile_image')->move(public_path('assets/user/'), $fileName);
                    $profile = $fileName;
                } else {
                    $profile = "";
                }

                $user              = User::findOrFail(Auth::user()->id);
                $user->profile_pic = $profile;

                $update = $user->update();
            } else {
                return response()->json(['status' => false, 'message' => 'Something went wrong try again later']);
                exit;
            }

        }
        if ($update) {
            return response()->json(['status' => 200, 'message' => 'Profile pic updated successfully']);
            exit;
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong try again later']);
            exit;
        }
    }

}