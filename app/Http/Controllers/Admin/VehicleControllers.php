<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Type;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class VehicleControllers extends Controller
{
    //
    public function index() {
        if (!auth()->user()->can('vehicle-list')) {
			abort(403, 'Unauthorized action.');
		}
        return view('admin.vehicle.index');
    }

     /**
     * @method use for show vehicle list ajax
     */
    public function vehicleAjaxList(Request $request) {
        if (isset($_GET['search']['value'])) {
            $search = $_GET['search']['value'];
        } else {
            $search = '';
        }
        if (isset($_GET['length'])) {
            $limit = $_GET['length'];
        } else {
            $limit = 10;
        }

        if (isset($_GET['start'])) {
            $ofset = $_GET['start'];
        } else {
            $ofset = 0;
        }

        $orderType = $_GET['order'][0]['dir'];
        $nameOrder = $_GET['columns'][$_GET['order'][0]['column']]['name'];

        $total = Vehicle::select('vehicles.*' , 'users.name')
        ->join('users' , 'vehicles.created_by' , '=' , 'users.id')
        ->orWhere(function ($query) use ($search) {
            $query->orWhere('vehicle_number', 'like', '%' . $search . '%');
            $query->orWhere('vehicle_brand', 'like', '%' . $search . '%');
            $query->orWhere('vehicle_model', 'like', '%' . $search . '%');
            $query->orWhere('vehicle_color', 'like', '%' . $search . '%');
            $query->orWhere('vehicle_seats', 'like', '%' . $search . '%');
        })
        ->get()->count();

        $vehicles = Vehicle::select('vehicles.*', 'users.name')
        ->join('users' , 'vehicles.created_by' , '=' , 'users.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('vehicle_number', 'like', '%' . $search . '%');
                $query->orWhere('vehicle_brand', 'like', '%' . $search . '%');
                $query->orWhere('vehicle_model', 'like', '%' . $search . '%');
                $query->orWhere('vehicle_color', 'like', '%' . $search . '%');
                $query->orWhere('vehicle_seats', 'like', '%' . $search . '%');
            })
            ->offset($ofset)->limit($limit)->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];
        foreach ($vehicles as $vehicle) {
            $checkVehicleImageExist = VehicleImage::where(['vehicle_id' => $vehicle->id])->get();
            $vehiclePic = '';
            if($checkVehicleImageExist){
                foreach($checkVehicleImageExist as $key => $pic) {
                    $vehiclePic .= ($pic->vehicle_image ? '<img src="'.url($pic->vehicle_image).'"  class="rounded" style="width: 50px; height: 50px;"> ' : '<img src="'.url('assets/images/profile.png').'"  class="rounded" style="width: 50px; height: 50px;">');
                }
            }
            $data[] = array(
                $i++,
                $vehiclePic,
                $vehicle->vehicle_type,
                $vehicle->vehicle_category,
                '<b>'.$vehicle->vehicle_number.'</b>',
                $vehicle->vehicle_brand,
                $vehicle->vehicle_color,
                $vehicle->vehicle_model,
                $vehicle->vehicle_seats,
                '<a href="javascript:void(0)" class="btn btn-sm '.($vehicle->vehicle_status == "ACTIVE" ? "btn-success" : "btn-danger").' statusChange" data-id="'.$vehicle->id.'"  data-active="'.($vehicle->vehicle_status == "ACTIVE" ? "DEACTIVE" : "ACTIVE").'">'.($vehicle->vehicle_status == "ACTIVE" ? "ACTIVE" : "DE-ACTIVE").'</a>',
                $vehicle->name,
                '<a href="'.url('admin/edit-vehicle/'.$vehicle->id).'" class="btn btn-primary btn-sm editCity" title="Edit"><i class="fa fa-pencil" ></i></a> | <a href="#" class="btn btn-sm btn-danger  vehicleRemove" data-id="' . $vehicle->id . '" title="Delete"><i class="fa fa-trash"></i></a>'
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    /**
     * @return view create
     */
    public function create() {
        if (!auth()->user()->can('vehicle-create')) {
			abort(403, 'Unauthorized action.');
		}
        $types = Type::where(['t_status' => 'APPROVED'])->get();
        $category = Category::where(['category_status' => 'APPROVED'])->get();
        return view('admin.vehicle.create' , compact('category','types'));
    }

    /**
     * @param Request $request
     * @method use for store Vehicle Details
     */
    public function store(Request $request) {
        if (!auth()->user()->can('vehicle-create')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}

        $validator = Validator::make($request->all() , [
            'vehicle_category'  => 'required|exists:categories,id',
            'vehicle_number'    => 'required|unique:vehicles,vehicle_number',
            'vehicle_brand'     => 'required',
            'vehicle_model'     => 'required',
            'vehicle_color'     => 'required',
            'vehicle_seats'     => 'required',
            'vehicle_pic.*'     => 'required',
            'vehicle_type'      => 'required',
            'car_model_year'      => 'required',
            'car_regi_year'      => 'required',
            'owner_name'      => 'required',
            'owner_mobile'      => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => false , 'message' => $validator->errors()->first()]);
            exit;
        }
        else {


            $data = new Vehicle();
            $input['vehicle_category']  = $request->vehicle_category;
            $input['vehicle_number']    = $request->vehicle_number;
            $input['vehicle_brand']     = $request->vehicle_brand;
            $input['vehicle_model']     = $request->vehicle_model;
            $input['vehicle_color']     = $request->vehicle_color;
            $input['vehicle_seats']     = $request->vehicle_seats;
            $input['created_by']        = Auth::user()->id;
            $input['vehicle_type']      = $request->vehicle_type;
            $input['car_model_year']      = $request->car_model_year;
            $input['car_regi_year']      = $request->car_regi_year;
            $input['owner_name']      = $request->owner_name;
            $input['owner_email']      = $request->owner_email;
            $input['owner_mobile']      = $request->owner_mobile;

            if ($request->file('owner_photo')) {
                $vehiclePic = $request->file('vehicle_pic');
                $fileName = '/assets/vehicle/images/' . uniqid(time()) . '.' . $vehiclePic->extension();
                $vehiclePic->move(public_path('assets/vehicle/images/'), $fileName);
                $vehcileImageName = $fileName;

                $input['owner_photo']    = $vehcileImageName;
            }


            $result = $data->fill($input)->save();

            if ($request->file('vehicle_pic')) {
                foreach($request->file('vehicle_pic') as $vehiclePic) {
                    $fileName = '/assets/vehicle/images/' . uniqid(time()) . '.' . $vehiclePic->extension();
                    $vehiclePic->move(public_path('assets/vehicle/images/'), $fileName);
                    $vehcileImageName = $fileName;

                    $storeImage = new VehicleImage();
                    $input1['vehicle_id']       = $data->id;
                    $input1['vehicle_image']    = $vehcileImageName;

                    $result1 = $storeImage->fill($input1)->save();
                }
            }


            if($result) {
                return response()->json(['status' => true , 'message' => 'Vehicle added successfully']);
                exit;
            }else{
                return response()->json(['status' => false , 'message' => 'Something went wrong try again later!!']);
                exit;
            }
        }
    }

    /**
     * @param $userId
     * @method use for change use status
     */
    public function statusChange(Request $request) {
        if (!auth()->user()->can('vehicle-edit')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}

        try {
            $where = array('id' => $request->vehicleId);
            $data  = array('vehicle_status' => $request->status);
            $update = Vehicle::where($where)->update($data);
            if ($update) {
                return response()->json(array('status' => true, 'message' => "Status updated successfully"));
                exit;
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
     * @param $vehicleId
     * @method use for edit vehicle
     */
    public function edit($vehicleId) {
        if (!auth()->user()->can('vehicle-edit')) {
			abort(403, 'Unauthorized action.');
		}
        $types = Type::where(['t_status' => 'APPROVED'])->get();
        $categories = Category::where(['category_status' => 'APPROVED'])->get();
        $vehicles = Vehicle::findOrFail($vehicleId);
        $vehicleImage = VehicleImage::where(['vehicle_id' => $vehicleId])->get();
        $category = Category::where(['category_status' => 'APPROVED'])->get();
        return view('admin.vehicle.edit' , compact('vehicles' , 'category' , 'vehicleImage','types','categories'));
    }

    /**
     * @param Request $request
     * @method use for delete  vehicle image
     */
    public function deleteImage(Request $request) {
        try {
            $Vehicles = VehicleImage::find($request->imageId);
            File::delete(public_path('../' . $Vehicles->vehicle_image));
            File::delete(public_path('../' . $Vehicles->vehicle_image));
            $result = $Vehicles->delete();
            if ($result) {
                return response()->json(array('status' => true, 'message' => "Image remove successfully"));
            } else {
                return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
        }

    }


    /**
     * @method use for Request $request
     * @method use for update vehicle details
     */
    public function update(Request $request) {
        if (!auth()->user()->can('vehicle-edit')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}

        $checkExits = Vehicle::findOrFail($request->vehicleId);

        $rules = [];
        if($checkExits->vehicle_number != $request->vehicle_number) {
            $rules['vehicle_number']  = 'required|unique:vehicles,vehicle_number';
        }

        $rules = [
            'vehicle_category'  => 'required|exists:categories,id',
            'vehicle_brand'     => 'required',
            'vehicle_model'     => 'required',
            'vehicle_color'     => 'required',
            'vehicle_seats'     => 'required',
            'vehicle_pic.*'     => 'required',
            'vehicle_type'      => 'required',
            'car_model_year'      => 'required',
            'car_regi_year'      => 'required',
            'owner_name'      => 'required',
            'owner_mobile'      => 'required',
        ];

        $validator = Validator::make($request->all() , $rules);

        if($validator->fails()) {
            return response()->json(['status' => false , 'message' => $validator->errors()->first()]);
            exit;
        }
        else {

            $checkExits->vehicle_category  = $request->vehicle_category;
            $checkExits->vehicle_number    = $request->vehicle_number;
            $checkExits->vehicle_brand     = $request->vehicle_brand;
            $checkExits->vehicle_model     = $request->vehicle_model;
            $checkExits->vehicle_color     = $request->vehicle_color;
            $checkExits->vehicle_seats     = $request->vehicle_seats;
            $checkExits->vehicle_type      = $request->vehicle_type;
            $checkExits->car_model_year      = $request->car_model_year;
            $checkExits->car_regi_year      = $request->car_regi_year;
            $checkExits->owner_name      = $request->owner_name;
            $checkExits->owner_mobile      = $request->owner_mobile;
            $checkExits->owner_email      = $request->owner_email;

            
            if ($request->file('owner_photo')) {
                $vehiclePic = $request->file('vehicle_pic');
                $fileName = '/assets/vehicle/images/' . uniqid(time()) . '.' . $vehiclePic->extension();
                $vehiclePic->move(public_path('assets/vehicle/images/'), $fileName);
                $vehcileImageName = $fileName;

                $checkExits->owner_photo    = $vehcileImageName;
            }


            $update = $checkExits->update();

            if ($request->file('vehicle_pic')) {
                foreach($request->file('vehicle_pic') as $vehiclePic) {
                    $fileName = '/assets/vehicle/images/' . uniqid(time()) . '.' . $vehiclePic->extension();
                    $vehiclePic->move(public_path('assets/vehicle/images/'), $fileName);
                    $vehcileImageName = $fileName;

                    $storeImage = new VehicleImage();
                    $input1['vehicle_id']       = $request->vehicleId;
                    $input1['vehicle_image']    = $vehcileImageName;

                    $result1 = $storeImage->fill($input1)->save();
                }
            }


            if($update) {
                return response()->json(['status' => true , 'message' => 'Updated added successfully']);
                exit;
            }else{
                return response()->json(['status' => false , 'message' => 'Something went wrong try again later!!']);
                exit;
            }
        }
    }

    /**
     * @param $vehicleId
     * @method use for delete vehicle
     */
    public function vehicleRemove(Request $request) {
        if (!auth()->user()->can('vehicle-delete')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}
        try {
            $Vehicles = Vehicle::find($request->vehicleId);
            $result = $Vehicles->delete();
            if ($result) {
                return response()->json(array('status' => true, 'message' => "Vehicle remove successfully"));
            } else {
                return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
        }
    }
}
