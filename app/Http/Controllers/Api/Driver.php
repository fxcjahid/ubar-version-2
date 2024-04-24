<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssignToDriver;
use App\Models\CarBooking;
use App\Models\Category;
use App\Models\DriverDoc;
use App\Models\DriverFeedBack;
use App\Models\DriverLocation;
use App\Models\DriverPromoCode;
use App\Models\DriverRefferalCode;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\UserFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;
use Mail;

class Driver extends Controller
{
    //
    public function addDriver(Request $request)
    {
        // return $request;
        $rules = [
            'first_name'        => 'required',
            'last_name'         => 'required',
            'phone'             => 'required|numeric|unique:users,phone',
            'email'             => 'required|unique:users,email',
            'gender'            => 'required',
            'password'          => 'required|min:4',
            'ride_package'      => 'required',
            'driver_licence'    => 'required',
            'car_model'         => 'required',
            'car_cc'            => 'required',
            'car_number'        => 'required',
            'car_owner_mobile'  => 'required',
            'car_brand'         => 'required',
            'car_register_year' => 'required',
            'profile_pic'       => 'required',
        ];

        $msg = [
            'first_name.required'        => 'Enter First Name',
            'last_name.required'         => 'Enter Last Name',
            'phone.required'             => 'Enter Your Phone number',
            'email.required'             => 'Enter Your Email',
            'ride_package.required'      => 'Service Type Required',
            'driver_licence.required'    => 'Driver Licence required',
            'car_model.required'         => 'Enter Car Model',
            'car_cc.required'            => 'Enter Car CC',
            'car_number.required'        => 'Enter Car Number',
            'car_owner_mobile.required'  => 'Enter Owner Number',
            'car_brand.required'         => 'Enter Car Brand',
            'car_register_year.required' => 'Enter Car Register',
            'profile_pic.required'       => 'Expect Image',
        ];

        $validator = Validator::make($request->all(), $rules, $msg);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        DB::beginTransaction();

        try {
            $profile = "";

            if ($request->file('profile_pic')) {
                $fileName = '/assets/user/' . uniqid(time()) . '.' . $request->file('profile_pic')->extension();
                $request->file('profile_pic')->move(public_path('assets/user/'), $fileName);
                $profile = $fileName;
            }

            $uniqueId = 'DRV01' . rand(10000, 99999);
            // Sms Verification
            $verification_code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            $data   = new User();
            $input  = [
                'first_name'          => $request->first_name,
                'last_name'           => $request->last_name,
                'email'               => $request->email,
                'phone'               => $request->phone,
                'address'             => $request->city,
                'password'            => Hash::make($request->password),
                'gender'              => $request->gender,
                'emergency_number'    => $request->emergency_number,
                'profile_pic'         => $profile,
                'name'                => $request->first_name . ' ' . $request->last_name,
                'user_type'           => "DRIVER",
                'username'            => $request->email,
                'user_register_from'  => "User App",
                'unique_id'           => $uniqueId,
                'licence_number'      => $request->driver_licence,
                'driver_phone_number' => $request->phone,
                'driver_email'        => $request->email,
                'ride_service'        => $request->ride_service,
                'ride_package'        => $request->ride_package,
                'car_model'           => $request->car_model,
                'car_cc'              => $request->car_cc,
                'car_number'          => $request->car_number,
                'car_register_year'   => $request->car_register_year,
                'verification_code'   => $verification_code,
            ];
            $result = $data->fill($input)->save();

            if ($result) {
                // Add Category

                $findCategory = Category::where(['category_name' => $request->ride_service])->first();
                if (empty($findCategory)) {
                    $category                  = new Category();
                    $input1['category_name']   = $request->ride_service;
                    $input1['category_status'] = "APPROVED";
                    $StoreCategory             = $category->fill($input1)->save();
                }

                // Add Vehcile Driver
                $vehicle                    = new Vehicle();
                $input2['vehicle_category'] = ($findCategory != '' ? $findCategory->id : $category->id);
                $input2['vehicle_number']   = $request->car_number;
                $input2['vehicle_brand']    = $request->car_brand;
                $input2['vehicle_model']    = $request->car_model;
                $input2['vehicle_type']     = $request->vehicle_type;
                $saveVehicle                = $vehicle->fill($input2)->save();

                // Vehicle Assign to Driver Process
                $assignToDriver       = new AssignToDriver();
                $input3['vehicle_id'] = $vehicle->id;
                $input3['user_id']    = $data->id;
                $saveAssignTo         = $assignToDriver->fill($input3)->save();

                $sms = send_otp($request->phone, $verification_code);
            }
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Driver register Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function otp_verification_driver(Request $request)
    {
        $rules     = [
            'driver_id'         => 'required|numeric|exists:users,id',
            'verification_code' => 'required|numeric',
        ];
        $msg       = [
            'driver_id.required'         => 'Driver not Found',
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

            return response()->json(['status' => 200, 'message' => 'Driver login successfully.', 'data' => $success]);
        }

        return response()->json(['status' => false, 'message' => 'Authentication failed.']);
    }
    /**
     * @method use for login driver
     */
    public function driverLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user'     => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            exit;
        } else {
            if (is_numeric($request->user)) {
                if (Auth::attempt(['phone' => $request->user, 'password' => $request->password])) {
                    $token            = Str::random(80);
                    $user             = Auth::user();
                    $success['token'] = $user->createToken($token)->plainTextToken;
                    $success['name']  = $user->name;
                    $success['id']    = $user->id;
                    return response()->json(['status' => 200, 'message' => 'Driver login successfully.', 'data' => $success]);
                } else {
                    return response()->json(['status' => false, 'message' => "Credentials Not Match!!"]);
                    exit;
                }
            } else {
                if (Auth::attempt(['email' => $request->user, 'password' => $request->password])) {
                    $user             = Auth::user();
                    $token            = Str::random(80);
                    $success['token'] = $user->createToken($token)->plainTextToken;
                    $success['name']  = $user->name;
                    $success['id']    = $user->id;
                    return response()->json(['status' => 200, 'message' => 'Driver login successfully.', 'data' => $success]);
                } else {
                    return response()->json(['status' => false, 'message' => "Credentials Not Match!!"]);
                    exit;
                }
            }
        }
    }

    /**
     * @param Request $request
     * @method use for upload driver document
     */
    public function driverUploadDocument(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'msg'    => $validator->errors()->first(),
            ]);
        } else {

            $findDoc = DriverDoc::where(['driver_id' => $request->driver_id])->first();

            if ($findDoc) {
                if ($request->file('driver_licence_front_pic')) {
                    File::delete(public_path('.././' . $findDoc->driver_licence_front_pic));
                    $driver_licence_front_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('driver_licence_front_pic')->extension();
                    $request->file('driver_licence_front_pic')->move(public_path('assets/driver/document/'), $driver_licence_front_pic);
                    $driverLicenceFrontPic             = $driver_licence_front_pic;
                    $findDoc->driver_licence_front_pic = $driverLicenceFrontPic;

                }
                if ($request->file('driver_licence_back_pic')) {
                    File::delete(public_path('.././' . $findDoc->driver_licence_back_pic));
                    $driver_licence_back_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('driver_licence_back_pic')->extension();
                    $request->file('driver_licence_back_pic')->move(public_path('assets/driver/document/'), $driver_licence_back_pic);
                    $driverLicenceBackPic             = $driver_licence_back_pic;
                    $findDoc->driver_licence_back_pic = $driverLicenceBackPic;

                }
                if ($request->file('car_pic')) {
                    File::delete(public_path('.././' . $findDoc->car_pic));
                    $car_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('car_pic')->extension();
                    $request->file('car_pic')->move(public_path('assets/driver/document/'), $car_pic);
                    $carPic           = $car_pic;
                    $findDoc->car_pic = $carPic;

                }
                if ($request->file('electricity_bill_pic')) {
                    File::delete(public_path('.././' . $findDoc->electricity_bill_pic));
                    $electricity_bill_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('electricity_bill_pic')->extension();
                    $request->file('electricity_bill_pic')->move(public_path('assets/driver/document/'), $electricity_bill_pic);
                    $electricityBillPic            = $electricity_bill_pic;
                    $findDoc->electricity_bill_pic = $electricityBillPic;

                }
                if ($request->file('bank_check_book_pic')) {
                    File::delete(public_path('.././' . $findDoc->bank_check_book_pic));
                    $bank_check_book_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('bank_check_book_pic')->extension();
                    $request->file('bank_check_book_pic')->move(public_path('assets/driver/document/'), $bank_check_book_pic);
                    $bankCheckBookPic             = $electricity_bill_pic;
                    $findDoc->bank_check_book_pic = $bankCheckBookPic;
                }

                if ($request->file('car_front_side_pic')) {
                    File::delete(public_path('.././' . $findDoc->car_front_side_pic));
                    $car_front_side_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('car_front_side_pic')->extension();
                    $request->file('car_front_side_pic')->move(public_path('assets/driver/document/'), $car_front_side_pic);
                    $carFrontSidePic             = $car_front_side_pic;
                    $findDoc->car_front_side_pic = $carFrontSidePic;


                }
                if ($request->file('car_back_side_pic')) {
                    File::delete(public_path('.././' . $findDoc->car_back_side_pic));
                    $car_back_side_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('car_back_side_pic')->extension();
                    $request->file('car_back_side_pic')->move(public_path('assets/driver/document/'), $car_back_side_pic);
                    $carBackSidePic             = $car_back_side_pic;
                    $findDoc->car_back_side_pic = $carBackSidePic;

                }

                if ($request->file('car_registration_pic')) {
                    File::delete(public_path('.././' . $findDoc->car_registration_pic));
                    $car_registration_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('car_registration_pic')->extension();
                    $request->file('car_registration_pic')->move(public_path('assets/driver/document/'), $car_registration_pic);
                    $carRegistrationPic            = $car_registration_pic;
                    $findDoc->car_registration_pic = $carRegistrationPic;

                }
                if ($request->file('car_tax_token_licence')) {
                    File::delete(public_path('.././' . $findDoc->car_tax_token_licence));
                    $car_tax_token_licence = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('car_tax_token_licence')->extension();
                    $request->file('car_tax_token_licence')->move(public_path('assets/driver/document/'), $car_tax_token_licence);
                    $carTaxTokenLicence             = $car_tax_token_licence;
                    $findDoc->car_tax_token_licence = $carTaxTokenLicence;

                }
                if ($request->file('car_fitness_licence')) {
                    File::delete(public_path('.././' . $findDoc->car_fitness_licence));
                    $car_fitness_licence = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('car_fitness_licence')->extension();
                    $request->file('car_fitness_licence')->move(public_path('assets/driver/document/'), $car_fitness_licence);
                    $carFitnessLicence            = $car_fitness_licence;
                    $findDoc->car_fitness_licence = $carFitnessLicence;

                }
                if ($request->file('car_insurance_licence')) {
                    File::delete(public_path('.././' . $findDoc->car_insurance_licence));
                    $car_insurance_licence = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('car_insurance_licence')->extension();
                    $request->file('car_insurance_licence')->move(public_path('assets/driver/document/'), $car_insurance_licence);
                    $carInsuranceLicence            = $car_insurance_licence;
                    $findDoc->car_insurance_licence = $carInsuranceLicence;

                }
                if ($request->file('car_route_permit_licence')) {
                    File::delete(public_path('.././' . $findDoc->car_route_permit_licence));
                    $car_route_permit_licence = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('car_route_permit_licence')->extension();
                    $request->file('car_route_permit_licence')->move(public_path('assets/driver/document/'), $car_route_permit_licence);
                    $carRoutePermitLicence             = $car_route_permit_licence;
                    $findDoc->car_route_permit_licence = $carRoutePermitLicence;

                }
                if ($request->file('add_extra_pic')) {
                    File::delete(public_path('.././' . $findDoc->add_extra_pic));
                    $add_extra_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('add_extra_pic')->extension();
                    $request->file('add_extra_pic')->move(public_path('assets/driver/document/'), $add_extra_pic);
                    $addExtraPic            = $add_extra_pic;
                    $findDoc->add_extra_pic = $addExtraPic;
                }

                $findDoc->driver_id    = $request->driver_id;
                $findDoc->gps_tracking = $request->gps_tracking;
                $findDoc->cctv_sur     = $request->cctv_sur;
                $update                = $findDoc->update();
                if ($update) {
                    return response()->json(['status' => true, 'msg' => 'Driver document updated successfully']);

                } else {
                    return response()->json(['status' => false, 'msg' => 'Something went wrong try again later!!']);

                }
            } else {
                if ($request->file('driver_licence_front_pic')) {
                    $driver_licence_front_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('driver_licence_front_pic')->extension();
                    $request->file('driver_licence_front_pic')->move(public_path('assets/driver/document/'), $driver_licence_front_pic);
                    $driverLicenceFrontPic = $driver_licence_front_pic;
                } else {
                    $driverLicenceFrontPic = "";
                }
                if ($request->file('driver_licence_back_pic')) {
                    $driver_licence_back_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('driver_licence_back_pic')->extension();
                    $request->file('driver_licence_back_pic')->move(public_path('assets/driver/document/'), $driver_licence_back_pic);
                    $driverLicenceBackPic = $driver_licence_back_pic;
                } else {
                    $driverLicenceBackPic = "";
                }
                if ($request->file('car_pic')) {
                    $car_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('car_pic')->extension();
                    $request->file('car_pic')->move(public_path('assets/driver/document/'), $car_pic);
                    $carPic = $car_pic;
                } else {
                    $carPic = "";
                }
                if ($request->file('electricity_bill_pic')) {
                    $electricity_bill_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('electricity_bill_pic')->extension();
                    $request->file('electricity_bill_pic')->move(public_path('assets/driver/document/'), $electricity_bill_pic);
                    $electricityBillPic = $electricity_bill_pic;
                } else {
                    $electricityBillPic = "";
                }
                if ($request->file('bank_check_book_pic')) {
                    $bank_check_book_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('bank_check_book_pic')->extension();
                    $request->file('bank_check_book_pic')->move(public_path('assets/driver/document/'), $bank_check_book_pic);
                    $bankCheckBookPic = $electricity_bill_pic;
                } else {
                    $bankCheckBookPic = "";
                }
                if ($request->file('car_front_side_pic')) {
                    $car_front_side_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('car_front_side_pic')->extension();
                    $request->file('car_front_side_pic')->move(public_path('assets/driver/document/'), $car_front_side_pic);
                    $carFrontSidePic = $car_front_side_pic;
                } else {
                    $carFrontSidePic = "";
                }
                if ($request->file('car_back_side_pic')) {
                    $car_back_side_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('car_back_side_pic')->extension();
                    $request->file('car_back_side_pic')->move(public_path('assets/driver/document/'), $car_back_side_pic);
                    $carBackSidePic = $car_back_side_pic;
                } else {
                    $carBackSidePic = "";
                }
                if ($request->file('car_registration_pic')) {
                    $car_registration_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('car_registration_pic')->extension();
                    $request->file('car_registration_pic')->move(public_path('assets/driver/document/'), $car_registration_pic);
                    $carRegistrationPic = $car_registration_pic;
                } else {
                    $carRegistrationPic = "";
                }
                if ($request->file('car_tax_token_licence')) {
                    $car_tax_token_licence = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('car_tax_token_licence')->extension();
                    $request->file('car_tax_token_licence')->move(public_path('assets/driver/document/'), $car_tax_token_licence);
                    $carTaxTokenLicence = $car_tax_token_licence;
                } else {
                    $carTaxTokenLicence = "";
                }
                if ($request->file('car_fitness_licence')) {
                    $car_fitness_licence = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('car_fitness_licence')->extension();
                    $request->file('car_fitness_licence')->move(public_path('assets/driver/document/'), $car_fitness_licence);
                    $carFitnessLicence = $car_fitness_licence;
                } else {
                    $carFitnessLicence = "";
                }
                if ($request->file('car_insurance_licence')) {
                    $car_insurance_licence = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('car_insurance_licence')->extension();
                    $request->file('car_insurance_licence')->move(public_path('assets/driver/document/'), $car_insurance_licence);
                    $carInsuranceLicence = $car_insurance_licence;
                } else {
                    $carInsuranceLicence = "";
                }
                if ($request->file('car_route_permit_licence')) {
                    $car_route_permit_licence = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('car_route_permit_licence')->extension();
                    $request->file('car_route_permit_licence')->move(public_path('assets/driver/document/'), $car_route_permit_licence);
                    $carRoutePermitLicence = $car_route_permit_licence;
                } else {
                    $carRoutePermitLicence = "";
                }
                if ($request->file('add_extra_pic')) {
                    $add_extra_pic = '/public/assets/driver/document/' . uniqid(time()) . '.' . $request->file('add_extra_pic')->extension();
                    $request->file('add_extra_pic')->move(public_path('assets/driver/document/'), $add_extra_pic);
                    $addExtraPic = $add_extra_pic;
                } else {
                    $addExtraPic = "";
                }

                $data                              = new DriverDoc();
                $input['driver_id']                = $request->driver_id;
                $input['driver_licence_front_pic'] = $driverLicenceFrontPic;
                $input['driver_licence_back_pic']  = $driverLicenceBackPic;
                $input['car_pic']                  = $carPic;
                $input['electricity_bill_pic']     = $electricityBillPic;
                $input['bank_check_book_pic']      = $bankCheckBookPic;
                $input['car_front_side_pic']       = $carFrontSidePic;
                $input['car_back_side_pic']        = $carBackSidePic;
                $input['car_registration_pic']     = $carRegistrationPic;
                $input['car_tax_token_licence']    = $carTaxTokenLicence;
                $input['car_fitness_licence']      = $carFitnessLicence;
                $input['car_insurance_licence']    = $carInsuranceLicence;
                $input['car_route_permit_licence'] = $carRoutePermitLicence;
                $input['add_extra_pic']            = $addExtraPic;
                $input['gps_tracking']             = $request->gps_tracking;
                $input['cctv_sur']                 = $request->cctv_sur;

                $result = $data->fill($input)->save();

                if ($result) {
                    return response()->json(['status' => true, 'msg' => 'Driver document added successfully']);
                    exit;
                } else {
                    return response()->json(['status' => false, 'msg' => 'Something went wrong try again later!!']);
                    exit;
                }
            }
        }
    }

    /**
     * @return view driver doc
     */
    public function driverDoc($driver_id)
    {
        $data = DriverDoc::where(['driver_id' => $driver_id])->first();
        if ($data) {
            $doc['driver_licence_front_pic'] = ($data->driver_licence_front_pic != NULL ? url($data->driver_licence_front_pic) : NULL);
            $doc['driver_licence_back_pic']  = ($data->driver_licence_back_pic != NUll ? url($data->driver_licence_back_pic) : NULL);
            $doc['car_pic']                  = ($data->car_pic != NULL ? url($data->car_pic) : NULL);
            $doc['electricity_bill_pic']     = ($data->electricity_bill_pic != NULL ? url($data->electricity_bill_pic) : NULL);
            $doc['bank_check_book_pic']      = ($data->bank_check_book_pic != NULL ? url($data->bank_check_book_pic) : NULL);
            $doc['car_front_side_pic']       = ($data->car_front_side_pic != NULL ? url($data->car_front_side_pic) : NULL);
            $doc['car_back_side_pic']        = ($data->car_back_side_pic != NULL ? url($data->car_back_side_pic) : NULL);
            $doc['car_registration_pic']     = ($data->car_registration_pic != NULL ? url($data->car_registration_pic) : NULL);
            $doc['car_tax_token_licence']    = ($data->car_tax_token_licence != NULL ? url($data->car_tax_token_licence) : NULL);
            $doc['car_fitness_licence']      = ($data->car_fitness_licence != NULL ? url($data->car_fitness_licence) : NULL);
            $doc['car_insurance_licence']    = ($data->car_insurance_licence != NULL ? url($data->car_insurance_licence) : NULL);
            $doc['car_route_permit_licence'] = ($data->car_route_permit_licence != NULL ? url($data->car_route_permit_licence) : NULL);
            $doc['add_extra_pic']            = ($data->add_extra_pic != NULL ? url($data->add_extra_pic) : NULL);

            return response()->json(['status' => true, 'data' => $doc]);
        } else {
            $doc['driver_licence_front_pic'] = NULL;
            $doc['driver_licence_back_pic']  = NULL;
            $doc['car_pic']                  = NULL;
            $doc['electricity_bill_pic']     = NULL;
            $doc['bank_check_book_pic']      = NULL;
            $doc['car_front_side_pic']       = NULL;
            $doc['car_back_side_pic']        = NULL;
            $doc['car_registration_pic']     = NULL;
            $doc['car_tax_token_licence']    = NULL;
            $doc['car_fitness_licence']      = NULL;
            $doc['car_insurance_licence']    = NULL;
            $doc['car_route_permit_licence'] = NULL;
            $doc['add_extra_pic']            = NULL;

            return response()->json(['status' => true, 'data' => $doc]);
        }


    }

    /**
     * @param $driver_id
     * @return view driver profile data
     */
    public function getDriverData($driver_id)
    {
        $data = User::findOrFail($driver_id);

        $row['first_name']             = ($data->first_name != NULL ? $data->first_name : NULL);
        $row['last_name']              = ($data->last_name != NULL ? $data->last_name : NULL);
        $row['driver_phone_number']    = ($data->driver_phone_number != NULL ? $data->driver_phone_number : NULL);
        $row['driver_emergency_phone'] = ($data->emergency_number != NULL ? $data->emergency_number : NULL);
        $row['car_owner_mobile']       = ($data->car_owner_mobile != NULL ? $data->car_owner_mobile : NULL);
        $row['driver_email']           = ($data->driver_email != NULL ? $data->driver_email : NULL);
        $row['ride_service']           = ($data->ride_service != NULL ? $data->ride_service : NULL);
        $row['ride_package']           = ($data->ride_package != NULL ? $data->ride_package : NULL);
        $row['driver_licence_number']  = ($data->licence_number != NULL ? $data->licence_number : NULL);
        $row['car_model']              = ($data->car_model != NULL ? $data->car_model : NULL);
        $row['car_cc']                 = ($data->car_cc != NULL ? $data->car_cc : NULL);
        $row['car_number']             = ($data->car_number != NULL ? $data->car_number : NULL);
        $row['car_register_year']      = ($data->car_register_year != NULL ? $data->car_register_year : NULL);
        $row['profile_pic']            = ($data->profile_pic != NULL ? url($data->profile_pic) : NULL);

        return response()->json(['status' => true, 'data' => $row]);
    }

    /**
     * @param Request $request
     * @method use for update driver profile
     */
    public function profileUpdate(Request $request)
    {
        $row = User::where(['id' => $request->driver_id])->first();
        if ($row) {
            $row['first_name']          = $request->first_name;
            $row['last_name']           = $request->last_name;
            $row['driver_phone_number'] = $request->driver_phone_number;
            $row['emergency_number']    = $request->emergency_number;
            $row['car_owner_mobile']    = $request->car_owner_mobile;
            $row['driver_email']        = $request->driver_email;
            $row['ride_service']        = $request->ride_service;
            $row['ride_package']        = $request->ride_package;
            $row['licence_number']      = $request->licence_number;
            $row['car_model']           = $request->car_model;
            $row['car_cc']              = $request->car_cc;
            $row['car_number']          = $request->car_number;
            $row['car_register_year']   = $request->car_register_year;
            $update                     = $row->update();

            if ($update) {
                return response()->json(['status' => true, 'msg' => 'profile updated successfully']);
                exit;
            } else {
                return response()->json(['status' => false, 'msg' => 'Something went wrong try again later!!']);
                exit;
            }
        } else {
            return response()->json(['status' => false, 'msg' => 'Something went wrong try again later!!']);
            exit;
        }
    }

    /**
     * @param Request $request
     * @method use for store driver promo code
     */
    public function promoCode(Request $request)
    {
        $data = DriverPromoCode::where(['driver_id' => $request->driver_id])->first();
        if (! empty($data)) {
            $data->code = $request->code;
            $update     = $data->update();

            if ($update) {
                return response()->json(['status' => true, 'msg' => 'code added successfully', 'data' => $data]);
                exit;
            } else {
                return response()->json(['status' => false, 'msg' => 'Something went wrong try again later!!']);
                exit;
            }
        } else {


            $newCode            = new DriverPromoCode();
            $input['code']      = $request->code;
            $input['driver_id'] = $request->driver_id;

            $result = $newCode->fill($input)->save();
            if ($result) {
                return response()->json(['status' => true, 'msg' => 'code added successfully', 'data' => $newCode]);
                exit;
            } else {
                return response()->json(['status' => false, 'msg' => 'Something went wrong try again later!!']);
                exit;
            }
        }
    }


    /**
     * @param Request $request
     * @method use for store driver promo code
     */
    public function refferalCode(Request $request)
    {
        $data = DriverRefferalCode::where(['driver_id' => $request->driver_id])->first();

        if ($data) {
            $data->code = $request->code;
            $update     = $data->update();

            if ($update) {
                return response()->json(['status' => true, 'msg' => 'code added successfully', 'data' => $data]);
                exit;
            } else {
                return response()->json(['status' => false, 'msg' => 'Something went wrong try again later!!']);
                exit;
            }
        } else {
            $newCode            = new DriverRefferalCode();
            $input['code']      = $request->code;
            $input['driver_id'] = $request->driver_id;

            $result = $newCode->fill($input)->save();
            if ($result) {
                return response()->json(['status' => true, 'msg' => 'code added successfully', 'data' => $newCode]);
                exit;
            } else {
                return response()->json(['status' => false, 'msg' => 'Something went wrong try again later!!']);
                exit;
            }
        }
    }

    /**
     * @return promocode
     */
    public function getPromoCode($driver_id)
    {
        $data = DriverPromoCode::where(['driver_id' => $driver_id])->first();
        return response()->json(['status' => true, 'data' => $data]);
    }

    /**
     * @return promocode
     */
    public function getRefferalCode($driver_id)
    {
        $data = DriverRefferalCode::where(['driver_id' => $driver_id])->first();
        return response()->json(['status' => true, 'data' => $data]);
    }

    /**
     * @return booking list
     */
    public function getPendingList($driver_id)
    {
        $data = CarBooking::select("car_bookings.*", "users.name", "users.phone", "users.profile_pic", "vehicles.vehicle_brand")
            ->join('users', 'car_bookings.user_id', '=', 'users.id')
            ->join('vehicles', 'car_bookings.vehicle_id', '=', 'vehicles.id')
            ->where(['driver_id' => $driver_id])
            ->where(['car_bookings.booking_status' => "pending"])
            ->get();

        $array = [];
        if ($data) {
            foreach ($data as $item) {
                $details['booking_id']      = $item->id;
                $details['user_id']         = $item->user_id;
                $details['user_phone']      = $item->phone;
                $details['user_name']       = $item->name;
                $details['distance']        = $item->total_distance;
                $details['fare']            = $item->total_fare;
                $details['pickup_location'] = $item->pickup_location;
                $details['destination']     = $item->destination;
                $details['status']          = $item->booking_status;
                $details['date']            = date('d-m-Y', strtotime($item->created_at));
                $details['profile_pic']     = ($item->profile_pic != NULL ? url($item->profile_pic) : NULL);
                $details['car_name']        = ($item->vehicle_brand);
                array_push($array, $details);
            }
        }

        return response()->json(['status' => true, 'data' => $array]);
    }

    /**
     * @param Request $request
     * @method use for accept booking
     */
    public function acceptBooking(Request $request)
    {

        $data                 = CarBooking::findOrFail($request->booking_id);
        $data->booking_status = 'accepted';

        $update = $data->update();

        if ($update) {
            return response()->json(['status' => true, 'msg' => 'Booking accepted', 'otp' => 1234]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => 'Something went wrong try again later!!']);
            exit;
        }
    }


    /**
     * @param Request $request
     * @method use for cancel booking
     */
    public function cancelledBooking(Request $request)
    {
        $data                 = CarBooking::findOrFail($request->booking_id);
        $data->booking_status = 'cancelled';

        $update = $data->update();

        if ($update) {
            return response()->json(['status' => true, 'msg' => 'Booking cancelled']);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => 'Something went wrong try again later!!']);
            exit;
        }
    }

    /**
     * @method use for check otp correct
     */
    public function otpCheck(Request $request)
    {

        $checkOtp = CarBooking::where(['id' => $request->booking_id, 'otp' => $request->otp, 'driver_id' => $request->driver_id])->first();
        if ($checkOtp) {
            $getDetails = CarBooking::select(
                "car_bookings.*",
                'users.name',
                'users.phone',
                'users.unique_id',
                'vehicles.vehicle_number',
                'vehicles.vehicle_category',
                'fares.minimum_fare',
                'vehicle_images.vehicle_image',
                'users.profile_pic',
                'vehicles.vehicle_brand',
            )
                ->join("users", 'car_bookings.user_id', '=', 'users.id')
                ->join("vehicles", 'car_bookings.vehicle_id', '=', 'vehicles.id')
                ->join("vehicle_images", 'car_bookings.vehicle_id', '=', 'vehicle_images.vehicle_id')
                ->leftjoin("fares", 'vehicles.vehicle_category', '=', 'fares.category_id')
                ->where(['car_bookings.id' => $checkOtp->id])->first();

            $getDriver                  = User::findOrFail($request->driver_id);
            $newArray                   = [];
            $newArray['user_name']      = $getDetails->name;
            $newArray['user_phone']     = $getDetails->phone;
            $newArray['total_fare']     = $getDetails->total_fare;
            $newArray['total_distance'] = $getDetails->total_distance;
            $newArray['suv_pic']        = ($getDetails->vehicle_image != NULL ? url($getDetails->vehicle_image) : NULL);
            $newArray['driver_id']      = $request->driver_id;
            $newArray['driver_phone']   = $getDriver->phone;
            $newArray['driver_pic']     = ($getDriver->profile_pic != NULL ? url($getDriver->profile_pic) : NULL);
            $newArray['booking_id']     = $checkOtp->id;
            $newArray['booking_id']     = $checkOtp->id;
            $newArray['user_pic']       = ($getDetails->profile_pic != NULL ? url($getDetails->profile_pic) : NULL);
            $newArray['user_id']        = $getDetails->user_id;
            $newArray['car_name']       = ($getDetails->vehicle_brand != NULL ? ($getDetails->vehicle_brand) : NULL);


            // $dataArray = [];
            // $dataArray['invoice_id']            = $getDetails->invoice_id;
            // $dataArray['Issue_date']            = date('d-m-Y' , strtotime($getDetails->created_at));
            // $dataArray['time']                  = date('H:i A' , strtotime($getDetails->created_at));
            // $dataArray['car_number']            = $getDetails->vehicle_number;
            // $dataArray['driver_id_number']      = $getDriver->unique_id;
            // $dataArray['user_id_number']        = $getDetails->unique_id;
            // $dataArray['ride_start_time']       = date('H:i A' , strtotime($getDetails->created_at));
            // $dataArray['ride_end_time']         = date('H:i A' , strtotime($getDetails->updated_at));
            // $dataArray['app_service_fee']       = '15TK';
            // $dataArray['base_fare']             = $getDetails->minimum_fare;
            // $dataArray['ride_per_km']           = $getDetails->minimum_fare;
            // $dataArray['ride_distance_fare']    = $getDetails->total_fare;
            // $dataArray['waiting_charge_minutes']= '03Tk';
            // $dataArray['waiting_charge_cost30min']= '90Tk';
            // $dataArray['tax_free_ride_bill']    = '00Tk';
            // $dataArray['vat_free_ride_bill']    = '00Tk';
            // $dataArray['ride_cancelling_fee']   = '50Tk';
            // $dataArray['user_driver_help_fund'] = '10Tk';

            if ($checkOtp) {
                return response()->json(['status' => true, 'msg' => 'Otp matched', 'data' => $newArray]);
                exit;
            } else {
                return response()->json(['status' => true, 'msg' => 'Please Enter correct Otp']);
                exit;
            }
        } else {
            return response()->json(['status' => false, 'msg' => 'Something went wrong try again later']);
            exit;
        }
    }

    /**
     * @method use for confirm booking
     */
    public function confirmBooking(Request $request)
    {
        $checkOtp = CarBooking::where(['id' => $request->booking_id])->first();
        if ($checkOtp) {
            $getDetails = CarBooking::select(
                "car_bookings.*",
                'users.name',
                'users.phone',
                'users.unique_id',
                'vehicles.vehicle_number',
                'vehicles.vehicle_category',
                'fares.minimum_fare',
                'vehicle_images.vehicle_image',
                'users.profile_pic',
                'vehicles.vehicle_brand',
            )
                ->join("users", 'car_bookings.user_id', '=', 'users.id')
                ->join("vehicles", 'car_bookings.vehicle_id', '=', 'vehicles.id')
                ->join("vehicle_images", 'car_bookings.vehicle_id', '=', 'vehicle_images.vehicle_id')
                ->leftjoin("fares", 'vehicles.vehicle_category', '=', 'fares.category_id')
                ->where(['car_bookings.id' => $request->booking_id])->first();

            $getDriver = User::findOrFail($getDetails->driver_id);

            $dataArray                             = [];
            $dataArray['invoice_id']               = $getDetails->invoice_id;
            $dataArray['Issue_date']               = date('d-m-Y', strtotime($getDetails->created_at));
            $dataArray['time']                     = date('H:i A', strtotime($getDetails->created_at));
            $dataArray['car_number']               = $getDetails->vehicle_number;
            $dataArray['driver_id_number']         = $getDriver->unique_id;
            $dataArray['user_id_number']           = $getDetails->unique_id;
            $dataArray['ride_start_time']          = date('H:i A', strtotime($getDetails->created_at));
            $dataArray['ride_end_time']            = date('H:i A', strtotime($getDetails->updated_at));
            $dataArray['app_service_fee']          = '15TK';
            $dataArray['base_fare']                = $getDetails->minimum_fare;
            $dataArray['ride_per_km']              = $getDetails->minimum_fare;
            $dataArray['ride_distance_fare']       = $getDetails->total_fare;
            $dataArray['waiting_charge_minutes']   = '03Tk';
            $dataArray['waiting_charge_cost30min'] = '90Tk';
            $dataArray['tax_free_ride_bill']       = '00Tk';
            $dataArray['vat_free_ride_bill']       = '00Tk';
            $dataArray['ride_cancelling_fee']      = '50Tk';
            $dataArray['user_driver_help_fund']    = '10Tk';
            $dataArray['booking_id']               = $request->booking_id;
            $dataArray['driver_id']                = $getDetails->driver_id;
            $dataArray['user_pic']                 = ($getDetails->profile_pic != NULL ? url($getDetails->profile_pic) : NULL);
            $dataArray['user_id']                  = $getDetails->user_id;
            $dataArray['car_name']                 = ($getDetails->vehicle_brand != NULL ? ($getDetails->vehicle_brand) : NULL);
            $dataArray['toll_free']                = 0;
            $dataArray['discount_offeer']          = 0;
            $dataArray['total_bill']               = '90TK';
            $dataArray['ride_bill']                = '90TK';
            $dataArray['toll_free']                = 0;
            $dataArray['due_bill']                 = '90TK';
            $dataArray['ride__total_bill']         = '90TK';
            $dataArray['insurance_fee']            = 0;

            $checkOtp->booking_status = "completed";
            $checkOtp->update();


            if ($checkOtp) {
                return response()->json(['status' => true, 'data' => $dataArray]);
                exit;
            } else {
                return response()->json(['status' => true, 'msg' => 'Please Enter correct Otp']);
                exit;
            }
        } else {
            return response()->json(['status' => false, 'msg' => 'Something went wrong try again later']);
            exit;
        }
    }

    /**
     * @method use for store rating
     */
    public function rating(Request $request)
    {
        $data = DriverFeedBack::select()
            ->where(['driver_id' => $request->driver_id])->sum("star");

        $count = DriverFeedBack::select()
            ->where(['driver_id' => $request->driver_id])->count();
        if ($count > 0) {
            $rating = $data / $count;
        } else {
            $rating = 0;
        }


        return response()->json(['status' => true, 'rating' => $rating]);
    }

    /**
     * @method use for update driver profile
     */
    public function driverProfileUpdate(Request $request)
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

    /**
     * @method get previous booking
     */
    public function getPriviousBookingList($driver_id)
    {
        $data = CarBooking::select("car_bookings.*", "users.name", "users.phone")
            ->join('users', 'car_bookings.user_id', '=', 'users.id')
            ->where(['driver_id' => $driver_id])
            ->where('booking_status', '!=', "pending")
            ->get();

        $array = [];
        if ($data) {
            foreach ($data as $item) {
                $details['booking_id']      = $item->id;
                $details['user_id']         = $item->user_id;
                $details['user_phone']      = $item->phone;
                $details['user_name']       = $item->name;
                $details['distance']        = $item->total_distance;
                $details['fare']            = $item->total_fare;
                $details['pickup_location'] = $item->pickup_location;
                $details['destination']     = $item->destination;
                $details['status']          = $item->booking_status;
                $details['date']            = date('d-m-Y', strtotime($item->created_at));
                array_push($array, $details);
            }
        }

        return response()->json(['status' => true, 'data' => $array]);
    }

    /**
     * @param Request $reqeust
     * @method use for give rating to user
     */
    public function giveRatingToUser(Request $reqeust)
    {
        $data                = new UserFeedback();
        $input['user_id']    = $reqeust->user_id;
        $input['driver_id']  = $reqeust->driver_id;
        $input['booking_id'] = $reqeust->booking_id;
        $input['feedback']   = $reqeust->feedback;
        $input['star']       = $reqeust->star;

        $result = $data->fill($input)->save();

        if ($result) {
            return response()->json(['status' => true, 'msg' => 'Feedback submitted successfully']);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => 'Something went wrong try again later!!']);
            exit;
        }
    }

    public function driver_current_location(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_id'   => 'required|exists:users,id',
            'location_id' => 'required|string',
            'lat'         => 'required|numeric',
            'lon'         => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(array('status' => false, 'msg' => $validator->errors()->first()));
        }

        $validated = $validator->validated();
        try {
            DriverLocation::create($validated);

            return response()->json(['status' => 200, 'message' => 'Record currect location']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Something went wrong try again later']);
        }
    }


    public function accept(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'driver_id'      => 'required',
            'car_booking_id' => 'required',
            'accepted'       => 'required|boolean',
        ]);

        // Update the status of the car booking
        $carBooking         = CarBooking::findOrFail($validatedData['car_booking_id']);
        $carBooking->status = $validatedData['accepted'] ? 'accepted' : 'rejected';
        $carBooking->save();

        // If the request is accepted, notify the user
        if ($validatedData['accepted']) {
            $carBooking->user->notify(new RideAcceptedNotification($carBooking));
        }

        return response()->json(['message' => 'Accept response received'], 200);
    }
}