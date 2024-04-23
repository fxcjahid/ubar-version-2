<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssignToDriver as ModelAssignToDriver;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssignToDriver extends Controller
{
    //
    public function index() {
        if (!auth()->user()->can('assign-driver-list')) {
			abort(403, 'Unauthorized action.');
		}
        $drivers = User::where(['user_type' => 'DRIVER'])->get();
        $cars = Vehicle::where(['vehicle_status' => "ACTIVE" , 'user_assign' => NULL])->get();
        return view('admin.assign.index' , compact('drivers' , 'cars'));
    }

    /**
     * @param Request $request
     * @method use for assign vehicle to driver
     */
    public function store(Request $request) {
        if (!auth()->user()->can('assign-driver-create')) {
			abort(403, 'Unauthorized action.');
		}
        $validator = Validator::make($request->all() , [
            'driver'    => 'required|exists:users,id',
            'vehicle'   => 'required|exists:vehicles,id'
        ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'message' => $validator->errors()->first()]);
            exit;
        }
        else {
            $data                   = new ModelAssignToDriver();
            $input['vehicle_id']    = $request->vehicle;
            $input['user_id']       = $request->driver;
            $result = $data->fill($input)->save();
        }
        if($result) {
            $vehicle = Vehicle::where(['id' => $request->vehicle])->update(['user_assign' => $request->driver]);
            $userUpdate = User::where(['id' => $request->driver])->update(['car_assign' => 1]);

            return response()->json(['status' => true , 'message' => 'Vehicle assign to driver successfully']);
            exit;
        }
        else{
            return response()->json(['status' => false , 'message' => 'something went wrong try again later']);
            exit;
        }
    }

    /**
     * @method use for show assign list ajax
     */
    public function AssignListAjax(Request $request) {
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

        $total = ModelAssignToDriver::select('assign_to_drivers.*' , 'users.name' , 'users.unique_id' , 'vehicles.vehicle_number' ,
        'vehicles.vehicle_brand' , 'vehicles.vehicle_category' , 'categories.category_name')
        ->join('users' , 'assign_to_drivers.user_id' , '=' , 'users.id')
        ->join('vehicles' , 'assign_to_drivers.vehicle_id' , '=' , 'vehicles.id')
        ->join('categories' , 'vehicles.vehicle_category' , '=' , 'categories.id')
        ->orWhere(function ($query) use ($search) {
            $query->orWhere('category_name', 'like', '%' . $search . '%');
            $query->orWhere('category_description', 'like', '%' . $search . '%');
            $query->orWhere('category_type', 'like', '%' . $search . '%');
        })->get()->count();

        $category = ModelAssignToDriver::select('assign_to_drivers.*' , 'assign_to_drivers.status as vstatus' , 'users.name' , 'users.unique_id' , 'vehicles.vehicle_number' ,
        'vehicles.vehicle_brand' , 'vehicles.vehicle_category' , 'categories.category_name')
        ->join('users' , 'assign_to_drivers.user_id' , '=' , 'users.id')
        ->join('vehicles' , 'assign_to_drivers.vehicle_id' , '=' , 'vehicles.id')
        ->join('categories' , 'vehicles.vehicle_category' , '=' , 'categories.id')
        ->orWhere(function ($query) use ($search) {
            $query->orWhere('category_name', 'like', '%' . $search . '%');
            $query->orWhere('category_description', 'like', '%' . $search . '%');
            $query->orWhere('category_type', 'like', '%' . $search . '%');
        })
        ->offset($ofset)->limit($limit)->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];
        foreach ($category as $com) {
            $data[] = array(
                $i++,
                $com->category_name,
                '<b>'.$com->name.'</b><br>'.$com->unique_id,
                $com->vehicle_brand.'<br>'.$com->vehicle_number,
                '<button class="btn btn-sm btn-success">'.$com->vstatus.'</button>',
                date('d-m-Y' , strtotime($com->created_at)),
                '<a href="#" class="btn btn-sm btn-danger  remove-assigncar" data-id="' . $com->id . '" title="Delete"><i class="fa fa-trash"></i></a>'
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    /**
     * @param Request $request
     * @method use for delete assign car
     */
    public function destroy(Request $request) {
        if (!auth()->user()->can('assign-driver-delete')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}

        try {
            $getVehicleId = ModelAssignToDriver::findOrFail($request->assign_id);
            $where = array('id' => $request->assign_id);
            $delete = ModelAssignToDriver::where($where)->delete();
            if ($delete) {

                Vehicle::where(['id' => $getVehicleId->vehicle_id])->update(['user_assign' => NULL]);
                return response()->json(array('status' => true, 'message' => " deleted successfully"));
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
}
