<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    //
     //
     public function index() {
        if (!auth()->user()->can('coupon-list')) {
			abort(403, 'Unauthorized action.');
		}
        return view('admin.setting.coupon');
    }

    /**
     * @method use for show offer list
     */
    public function couponList(Request $request) {
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

        $total = Coupon::select('coupons.*')
        ->orWhere(function ($query) use ($search) {
            $query->orWhere('coupon_code', 'like', '%' . $search . '%');
            $query->orWhere('status', 'like', '%' . $search . '%');
        })->get()->count();

        $offers = Coupon::select('coupons.*')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('coupon_code', 'like', '%' . $search . '%');
                $query->orWhere('status', 'like', '%' . $search . '%');
            })
            ->offset($ofset)->limit($limit)->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];
        foreach ($offers as $offer) {
            $data[] = array(
                $i++,
                $offer->coupon_code,
                date('d-m-Y' , strtotime($offer->start_date)),
                date('d-m-Y' , strtotime($offer->end_date)),
                $offer->percentage,
                '<a href="javascript:void(0)" class="btn btn-sm '.($offer->status == "ACTIVE" ? "btn-success" : "btn-danger").'  updateCoupon" data-status="'.($offer->status == "ACTIVE" ? "DEACTIVE" : "ACTIVE").'" data-id="'.$offer->id.'">'.$offer->status.'</a>',
                '<a href="javascript:void(0)" class="btn btn-primary btn-sm editCoupon" data-id="'.$offer->id.'" data-coupon_code="'.$offer->coupon_code.'" data-start_date="'.$offer->start_date.'" data-end_date="'.$offer->end_date.'" data-percentage="'.$offer->percentage.'" title="Edit"><i class="fa fa-pencil" ></i></a> | <a href="#" class="btn btn-sm btn-danger  remove-coupon" data-id="' . $offer->id . '" title="Delete"><i class="fa fa-trash"></i></a>'
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    /**
     * @param Request $request
     * @method use for add offer
     */
    public function store(Request $request) {
        if (!auth()->user()->can('coupon-create')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}
        $validator = Validator::make($request->all() , [
            'coupon_code'    => 'required|unique:coupons,coupon_code',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date',
            'discount'    => 'required|numeric'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => false , 'message' => $validator->errors()->first()]);
            exit;
        }else{

            $data = new Coupon();
            $input['coupon_code']    = $request->coupon_code;
            $input['start_date']    = $request->start_date;
            $input['end_date']      = $request->end_date;
            $input['percentage']    = $request->discount;

            $result = $data->fill($input)->save();

            if($result) {
                return response()->json(['status' => true , 'message' => 'Coupon added successfully']);
                exit;
            }
            else{
                return response()->json(['status' => false , 'message' => 'Something went wrong try again later']);
                exit;
            }
        }
    }

    /**
     * @param $couponId
     * @method use for update offer status
     */
    public function couponStatus(Request $request) {
        if (!auth()->user()->can('coupon-edit')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}
        try {
            $where = array('id' => $request->couponId);
            $data  = array('status' => $request->status);
            $update = Coupon::where($where)->update($data);
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
     * @param $offerId
     * @method use for delete offer
     */
    public function couponRemove(Request $request) {
        if (!auth()->user()->can('coupon-delete')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}
        try {
            $offer = Coupon::find($request->couponId);
            $result = $offer->delete();
            if ($result) {
                return response()->json(array('status' => true, 'message' => "Coupon remove successfully"));
            } else {
                return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
        }
    }

    /**
     * @param Request $request
     * @method use for update offer
     */
    public function update(Request $request) {
        if (!auth()->user()->can('coupon-edit')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}

        $rules = [];
        $checkExits = Coupon::findOrFail($request->couponId);

        if($request->coupon_code != $checkExits->coupon_code) {
            $rules['coupon_code'] = 'required|unique:coupons,coupon_code';
        }

        $rules = [
            'start_date'    => 'required|date',
            'end_date'      => 'required|date',
            'discount'    => 'required|numeric'
        ];
        $validator = Validator::make($request->all() , $rules);

        if($validator->fails()) {
            return response()->json(['status' => false , 'message' => $validator->errors()->first()]);
            exit;
        }else{

            $checkExits->coupon_code     = $request->coupon_code;
            $checkExits->start_date     = $request->start_date;
            $checkExits->end_date       = $request->end_date;
            $checkExits->percentage     = $request->discount;

            $result = $checkExits->save();

            if($result) {
                return response()->json(['status' => true , 'message' => 'Coupon updated successfully']);
                exit;
            }
            else{
                return response()->json(['status' => false , 'message' => 'Something went wrong try again later']);
                exit;
            }
        }
    }
}

