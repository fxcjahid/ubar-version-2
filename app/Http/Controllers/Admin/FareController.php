<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Fare;
use App\Models\FareCategory;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FareController extends Controller
{
    //
    public function index()
    {

        if (! auth()->user()->can('fare-setting-list')) {
            abort(403, 'Unauthorized action.');
        }
        $types         = Type::where(['t_status' => 'APPROVED'])->get();
        $fare_category = FareCategory::where(['status' => 'ACTIVE'])->get();
        $category      = Category::where(['category_status' => 'APPROVED'])->get();
        return view('admin.fares.index', compact('category', 'types', 'fare_category'));
    }

    /**
     * @method return dataTable city list ajax
     */
    public function fareAjaxList(Request $request)
    {
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

        $total = Fare::where('fares.status', 'like', '%' . $search . '%')->count();

        $fares = Fare::where('fares.status', 'like', '%' . $search . '%')->with('type', 'category', 'fare_category')
            ->offset($ofset)->limit($limit)->orderBy($nameOrder, $orderType)->get();

        // $fares = Fare::select('fares.*' , 'categories.category_name', 'types.t_name', 'fare_categories.name')
        // ->join('types' , 'fares.type_id' ,'=' , 'types.id')
        // ->join('fare_categories' , 'fares.fare_category_id' ,'=' , 'fare_categories.id')
        // ->join('categories' , 'fares.category_id' ,'=' , 'categories.id')
        //     ->orWhere(function ($query) use ($search) {
        //         $query->orWhere('fares.status', 'like', '%' . $search . '%');
        //         $query->orWhere('categories.category_name', 'like', '%' . $search . '%');
        //     })
        //     ->offset($ofset)->limit($limit)->orderBy($nameOrder , $orderType)->get();
        $i    = 1 + $ofset;
        $data = [];
        foreach ($fares as $fare) {
            $data[] = array(
                $i++,
                $fare->type ? $fare->type->t_name : '',
                $fare->category ? $fare->category->category_name : '',
                $fare->fare_category ? $fare->fare_category->name : '',
                $fare->km,
                $fare->per_hour_fare,
                $fare->per_day_fare,
                $fare->per_week_fare,
                $fare->per_month_fare,
                $fare->holiday_fare,
                $fare->per_holiday_fare,
                '<a href="javascript:void(0)" class="btn btn-sm ' . ($fare->status == "ACTIVE" ? "btn-success" : "btn-danger") . '  updateFare" data-status="' . ($fare->status == "ACTIVE" ? "DEACTIVE" : "ACTIVE") . '" data-id="' . $fare->id . '">' . $fare->status . '</a>',

                '<a href="javascript:void(0)" class="btn btn-primary btn-sm editFare" data-id="' . $fare->id . '" data-type="' . $fare->type_id . '" data-t_name="' . $fare->t_name . '" data-category="' . $fare->category_id . '" data-category_name="' . $fare->category_name . '"  data-fare_category="' . $fare->fare_category_id . '" data-fare_category_name="' . $fare->name . '"  data-km="' . $fare->km . '" data-per_day_fare="' . $fare->per_day_fare . '" data-per_week_fare="' . $fare->per_week_fare . '" data-per_month_fare="' . $fare->per_month_fare . '" data-holiday_fare="' . $fare->holiday_fare . '" data-per_holiday_fare="' . $fare->per_holiday_fare . '" data-per_hour_fare="' . $fare->per_hour_fare . '" title="Edit"><i class="fa fa-pencil" ></i></a> | <a href="#" class="btn btn-sm btn-danger  remove-fare" data-id="' . $fare->id . '" title="Delete"><i class="fa fa-trash"></i></a>'
            );
        }
        $records['recordsTotal']    = $total;
        $records['recordsFiltered'] = $total;
        $records['data']            = $data;
        echo json_encode($records);
    }

    /**
     * @param Request $request
     * @method use for store city
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('fare-setting-create')) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
            exit;
        }

        $validation = Validator::make($request->all(), [
            'type'     => 'required',
            'category' => 'required',
            'km'       => 'required',
        ]);

        $type = Type::find($request->type);

        if ($type) {
            if ($type->t_name != 'Ride Car') {
                $validation = Validator::make($request->all(), [
                    'fare_category' => 'required',
                ]);
            }

            if ($type->t_name == 'Hourly Car') {
                $validation = Validator::make($request->all(), [
                    'per_hour_fare' => 'required',
                ]);
            }

            if ($type->t_name == 'Schedule Car' || $type->t_name == 'Intercity' || $type->t_name == 'Rental Car' || $type->t_name == 'Chander Pahar Car' || $type->t_name == 'Ambulance' || $type->t_name == 'Truck' || $type->t_name == 'Bus' || $type->t_name == 'Helicopter' || $type->t_name == 'Hire Driver' || $type->t_name == 'Self Driving Car') {
                $validation = Validator::make($request->all(), [
                    'per_hour_fare'    => 'required',
                    'per_day_fare'     => 'required',
                    'per_month_fare'   => 'required',
                    'holiday_fare'     => 'required',
                    'per_holiday_fare' => 'required',
                ]);
            }
        }

        if ($validation->fails()) {
            return response()->json(['status' => false, 'message' => $validation->errors()->first()]);
            exit;
        } else {
            $data                 = new Fare();
            $input['type_id']     = $request->type;
            $input['category_id'] = $request->category;
            $input['km']          = $request->km;

            if ($type) {
                if ($type->t_name != 'Ride Car') {
                    $input['fare_category_id'] = $request->fare_category;
                }

                if ($type->t_name == 'Hourly Car') {
                    $input['per_hour_fare'] = $request->per_hour_fare;
                }

                if ($type->t_name == 'Schedule Car' || $type->t_name == 'Intercity' || $type->t_name == 'Rental Car' || $type->t_name == 'Chander Pahar Car' || $type->t_name == 'Ambulance' || $type->t_name == 'Truck' || $type->t_name == 'Bus' || $type->t_name == 'Helicopter' || $type->t_name == 'Hire Driver' || $type->t_name == 'Self Driving Car') {
                    $input['per_hour_fare']    = $request->per_hour_fare;
                    $input['per_day_fare']     = $request->per_day_fare;
                    $input['per_week_fare']    = $request->per_week_fare;
                    $input['per_month_fare']   = $request->per_month_fare;
                    $input['holiday_fare']     = $request->holiday_fare;
                    $input['per_holiday_fare'] = $request->per_holiday_fare;
                }
            }

            $input['officeTime']   = $request->officeTime;
            $input['lunchHours']   = $request->lunchHours;
            $input['eveningHours'] = $request->eveningHours;
            $input['nightHours']   = $request->nightHours;
            $input['mindNight']    = $request->mindNight;
            $input['morningTime']  = $request->morningTime;

            $input['created_by'] = Auth::user()->id;

            $result = $data->fill($input)->save();

            if ($result) {
                return response()->json(['status' => true, 'message' => 'Fares added successfully']);
                exit;
            } else {
                return response()->json(['status' => false, 'message' => 'Something went wrong ! Try again later']);
                exit;
            }
        }
    }

    /**
     * @param $cityId
     * @method use for delete city
     */
    public function destroy(Request $request)
    {
        if (! auth()->user()->can('fare-setting-delete')) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
            exit;
        }
        try {
            $city   = Fare::find($request->fareId);
            $result = $city->delete();
            if ($result) {
                return response()->json(array('status' => true, 'message' => "Fare remove successfully"));
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
    public function statusChange(Request $request)
    {
        if (! auth()->user()->can('fare-setting-edit')) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
            exit;
        }
        try {
            $where  = array('id' => $request->fareId);
            $data   = array('status' => $request->status);
            $update = Fare::where($where)->update($data);
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
    public function update(Request $request)
    {
        if (! auth()->user()->can('fare-setting-edit')) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
            exit;
        }

        $validation = Validator::make($request->all(), [
            'edit_type'     => 'required',
            'edit_category' => 'required',
            'edit_km'       => 'required',
        ]);

        $type = Type::find($request->edit_type);

        if ($type) {
            if ($type->t_name != 'Ride Car') {
                $validation = Validator::make($request->all(), [
                    'edit_fare_category' => 'required',
                ]);
            }

            if ($type->t_name == 'Hourly Car') {
                $validation = Validator::make($request->all(), [
                    'edit_per_hour_fare' => 'required',
                ]);
            }

            if ($type->t_name == 'Schedule Car' || $type->t_name == 'Intercity' || $type->t_name == 'Rental Car' || $type->t_name == 'Chander Pahar Car' || $type->t_name == 'Ambulance' || $type->t_name == 'Truck' || $type->t_name == 'Bus' || $type->t_name == 'Helicopter' || $type->t_name == 'Hire Driver' || $type->t_name == 'Self Driving Car') {
                $validation = Validator::make($request->all(), [
                    'edit_per_hour_fare'    => 'required',
                    'edit_per_day_fare'     => 'required',
                    'edit_per_month_fare'   => 'required',
                    'edit_holiday_fare'     => 'required',
                    'edit_per_holiday_fare' => 'required',
                ]);
            }
        }

        if ($validation->fails()) {
            return response()->json(['status' => false, 'message' => $validation->errors()->first()]);
            exit;
        } else {
            $data              = Fare::findOrFail($request->fareId);
            $data->type_id     = $request->edit_type;
            $data->category_id = $request->edit_category;
            $data->km          = $request->edit_km;

            if ($type) {
                if ($type->t_name == 'Hourly Car') {
                    $data->per_hour_fare = $request->edit_per_hour_fare;
                } else {
                    $data->per_hour_fare = 0;
                }

                if ($type->t_name == 'Schedule Car' || $type->t_name == 'Intercity' || $type->t_name == 'Rental Car' || $type->t_name == 'Chander Pahar Car' || $type->t_name == 'Ambulance' || $type->t_name == 'Truck' || $type->t_name == 'Bus' || $type->t_name == 'Helicopter' || $type->t_name == 'Hire Driver' || $type->t_name == 'Self Driving Car') {
                    $data->per_hour_fare    = $request->edit_per_hour_fare;
                    $data->per_day_fare     = $request->edit_per_day_fare;
                    $data->per_week_fare    = $request->edit_per_week_fare;
                    $data->per_month_fare   = $request->edit_per_month_fare;
                    $data->holiday_fare     = $request->edit_holiday_fare;
                    $data->per_holiday_fare = $request->edit_per_holiday_fare;
                } else {
                    $data->per_hour_fare    = 0;
                    $data->per_day_fare     = 0;
                    $data->per_week_fare    = 0;
                    $data->per_month_fare   = 0;
                    $data->holiday_fare     = null;
                    $data->per_holiday_fare = 0;
                }


                if ($type->t_name != 'Ride Car') {
                    $data->fare_category_id = $request->edit_fare_category;
                } else {
                    $data->fare_category_id = null;
                }
            }

            $result = $data->update();

            if ($result) {
                return response()->json(['status' => true, 'message' => 'Fares updated successfully']);
                exit;
            } else {
                return response()->json(['status' => false, 'message' => 'Something went wrong ! Try again later']);
                exit;
            }
        }
    }
}