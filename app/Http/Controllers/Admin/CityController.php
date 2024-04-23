<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    //
    public function index() {
        if (!auth()->user()->can('city-agent-list')) {
			abort(403, 'Unauthorized action.');
		}
        return view('admin.city.index');
    }

    /**
     * @method return dataTable city list ajax
     */
    public function cityAjaxList(Request $request) {
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

        $total = City::select('cities.*')
        ->orWhere(function ($query) use ($search) {
            $query->orWhere('city', 'like', '%' . $search . '%');
            $query->orWhere('status', 'like', '%' . $search . '%');
        })->get()->count();

        $cities = City::select('cities.*')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('city', 'like', '%' . $search . '%');
                $query->orWhere('status', 'like', '%' . $search . '%');
            })
            ->offset($ofset)->limit($limit)->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];
        foreach ($cities as $city) {
            $data[] = array(
                $i++,
                $city->city,
                '<a href="javascript:void(0)" class="btn btn-sm '.($city->status == "ACTIVE" ? "btn-success" : "btn-danger").'  updateCity" data-status="'.($city->status == "ACTIVE" ? "DEACTIVE" : "ACTIVE").'" data-id="'.$city->id.'">'.$city->status.'</a>',
                '<a href="javascript:void(0)" class="btn btn-primary btn-sm editCity" data-id="'.$city->id.'" data-status="'.$city->status.'" data-city="'.$city->city.'" title="Edit"><i class="fa fa-pencil" ></i></a> | <a href="#" class="btn btn-sm btn-danger  remove-city" data-id="' . $city->id . '" title="Delete"><i class="fa fa-trash"></i></a>'
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    /**
     * @param Request $request
     * @method use for store city
     */
    public function store(Request $request) {
        if (!auth()->user()->can('city-agent-create')) {
			abort(403, 'Unauthorized action.');
		}

        $validation = Validator::make($request->all() , [
            'city' => 'required|unique:cities,city',
            'status' => 'required',
        ]);
        if($validation->fails()) {
            return response()->json(['status' => false , 'message' => $validation->errors()->first()]);
            exit;
        }
        else{
            $data = new City();
            $input['city']  = $request->city;
            $input['status'] = $request->status;

            $result = $data->fill($input)->save();
            if($result) {
                return response()->json(['status' => true , 'message' => 'City added successfully']);
                exit;
            }
            else {
                return response()->json(['status' => false , 'message' => 'Something went wrong ! Try again later']);
                exit;
            }
        }
    }

    /**
     * @param $cityId
     * @method use for delete city
     */
    public function destroy(Request $request) {
        if (!auth()->user()->can('city-agent-delete')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}
        try {
            $city = City::find($request->cityId);
            $result = $city->delete();
            if ($result) {
                return response()->json(array('status' => true, 'message' => "City remove successfully"));
            } else {
                return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
        }
    }

    /**
     * @param Request $request
     * @method use for city status change
     */
    public function statusChange(Request $request) {
        if (!auth()->user()->can('city-agent-edit')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}
        try {
            $where = array('id' => $request->cityId);
            $data  = array('status' => $request->status);
            $update = City::where($where)->update($data);
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
     * @param Request $request
     * @method use for update city details
     */
    public function update(Request $request) {

        if (!auth()->user()->can('city-agent-edit')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}

        $checkCityExits = City::findOrFail($request->cityId);
        $rules = [];
        if($request->city != $checkCityExits->city) {
            $rules['city'] = 'required|unique:cities,city';
        }
        $rules = [
            'status' => 'required',
        ];
        $validation = Validator::make($request->all() , $rules);
        if($validation->fails()) {
            return response()->json(['status' => false , 'message' => $validation->errors()->first()]);
            exit;
        }else{

            $updateData = City::findOrFail($request->cityId);
            $updateData->city = $request->city;
            $updateData->status = $request->status;

            $resultUpdate = $updateData->update();
            if($resultUpdate) {
                return response()->json(array('status' => true, 'message' => "City updated successfully"));
                exit;
            }
            else{
                return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
                exit;
            }
        }

    }
}
