<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ManualBooking;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ManualBookingController extends Controller
{
    //
    public function index() {
        if (!auth()->user()->can('manual-booking-list')) {
			abort(403, 'Unauthorized action.');
		}
        return view('admin.manual-booking.index');
    }

    /**
     * @method use for show manual booking list ajax
     */
    public function bookingListAjax(Request $request) {
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

        $total = ManualBooking::select('manual_bookings.*' , 'users.name')
        ->join('users' , 'manual_bookings.created_by_id' , '=' , 'users.id')
        ->orWhere(function ($query) use ($search) {
            $query->orWhere('booking_id', 'like', '%' . $search . '%');
            $query->orWhere('customer_name', 'like', '%' . $search . '%');
            $query->orWhere('manual_bookings.phone', 'like', '%' . $search . '%');
        });

        if(Auth::user()->user_type != "SUPERADMIN") {
            $total = $total->where(['create_by_id' => Auth::user()->id]);
        }
        $total = $total->get()->count();

        $bookings = ManualBooking::select('manual_bookings.*' , 'users.name')
            ->join('users' , 'manual_bookings.created_by_id' , '=' , 'users.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('booking_id', 'like', '%' . $search . '%');
                $query->orWhere('customer_name', 'like', '%' . $search . '%');
                $query->orWhere('manual_bookings.phone', 'like', '%' . $search . '%');});
            if(Auth::user()->user_type != "SUPERADMIN") {
                $bookings = $bookings->where(['create_by_id' => Auth::user()->id]);
            }
            $bookings = $bookings->offset($ofset)->limit($limit)->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];
        foreach ($bookings as $booking) {
            $data[] = array(
                $i++,
                '<b>'.$booking->booking_id.'</b>',
                $booking->customer_name,
                $booking->phone,
                $booking->email,
                date('d-m-Y' , strtotime($booking->booking_start_date)),
                date('d-m-Y' , strtotime($booking->booking_end_date)),
                $booking->advance_amnt,
                $booking->pending_amnt,
                '<b>'.$booking->total_amnt.'</b>',
                '<button class="btn btn-sm '.($booking->status == "PENDING" ? "btn-warning" :($booking->status == "COMPLETED" ? "btn-success" :  ($booking->status == "CANCELLED" ? "btn-danger" : ""))).'" >'.$booking->status.'</button>',
                $booking->name,
                '<a href="'.route('admin.manual-booking.edit' , $booking->id).'" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-pencil" ></i></a> | <a href="#" class="btn btn-sm btn-danger  remove-booking" data-id="' . $booking->id . '" title="Delete"><i class="fa fa-trash"></i></a>'
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
        if (!auth()->user()->can('manual-booking-create')) {
			abort(403, 'Unauthorized action.');
		}
        $types = Type::where(['t_status' => 'APPROVED'])->get();
        $drivers = User::where(['user_type'=>'DRIVER','active'=>'1'])->get();
        return view('admin.manual-booking.create',compact('types','drivers'));
    }

    /**
     * @param Request $request
     * @method use for store manual booking
     */
    public function store(Request $request) {
        if (!auth()->user()->can('manual-booking-create')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}
        $validator = Validator::make($request->all() , [
            'customer'      => 'required',
            'phone'         => 'required|numeric',
            'email'         => 'required',
            'type'         => 'required',
            'category'         => 'required',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date',
            'pickup_location'=> 'required',
            'drop_location'=> 'required',
            'advance_amount'=> 'required',
            'pending_amount'=> 'required',
            'driver'=> 'required',
            'distance'=> 'required',
            'total_amount'  => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => false , 'message' => $validator->errors()->first()]);
            exit;
        }
        else {
            $uniqueId = 'CUST0012'.rand(100000, 999999);
            $data = new ManualBooking();
            $input['booking_id']       = $uniqueId;
            $input['phone']             = $request->phone;
            $input['customer_name']     = $request->customer;
            $input['email']             = $request->email;
            $input['distance']             = $request->distance;
            $input['pickup_location']             = $request->pickup_location;
            $input['drop_location']             = $request->drop_location;
            $input['type_id']             = $request->type;
            $input['category_id']             = $request->category;
            $input['driver_id']             = $request->driver;
            $input['booking_start_date']= $request->start_date;
            $input['booking_end_date']  = $request->end_date;
            $input['advance_amnt']      = $request->advance_amount;
            $input['pending_amnt']      = $request->pending_amount;
            $input['total_amnt']        = $request->total_amount;
            $input['created_by_id']     = Auth::user()->id;

            $result = $data->fill($input)->save();

            if($result) {
                return response()->json(['status' => true , 'message' => 'Booking successfully']);
                exit;
            }
            else {
                return response()->json(['status' => false , 'message' => 'Something went wrong try again later']);
                exit;
            }
        }

    }

    /**
    * @return view edit
    */
    public function edit(Request $request){
        if (!auth()->user()->can('manual-booking-edit')) {
			abort(403, 'Unauthorized action.');
		}
        $booking = ManualBooking::FindOrFail($request->manualId);

        $types = Type::where(['t_status' => 'APPROVED'])->get();
        $categories = Category::where(['category_status' => 'APPROVED'])->get();
        $drivers = User::where(['user_type'=>'DRIVER','active'=>'1'])->get();
        return view('admin.manual-booking.edit' , compact('booking','categories','types','drivers'));
    }

    /**
     * @method use for update booking
     */
    public function update(Request $request) {
        if (!auth()->user()->can('manual-booking-edit')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}
        $validator = Validator::make($request->all() , [
            'customer'      => 'required',
            'phone'         => 'required|numeric',
            'email'         => 'required',
            'driver'         => 'required',
            'type'         => 'required',
            'category'         => 'required',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date',
            'pickup_location'=> 'required',
            'drop_location'=> 'required',
            'distance'=> 'required',
            'advance_amount'=> 'required',
            'pending_amount'=> 'required',
            'total_amount'  => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => false , 'message' => $validator->errors()->first()]);
            exit;
        }
        else {
            $data = ManualBooking::FindOrFail($request->bookingId);
            $data->phone             = $request->phone;
            $data->customer_name     = $request->customer;
            $data->email             = $request->email;
            $data->distance             = $request->distance;
            $data->pickup_location             = $request->pickup_location;
            $data->drop_location             = $request->drop_location;
            $data->type_id             = $request->type;
            $data->driver_id             = $request->driver;
            $data->category_id             = $request->category;
            $data->booking_start_date= $request->start_date;
            $data->booking_end_date  = $request->end_date;
            $data->advance_amnt      = $request->advance_amount;
            $data->pending_amnt      = $request->pending_amount;
            $data->total_amnt        = $request->total_amount;
            $data->created_by_id     = Auth::user()->id;

            $result = $data->update();

            if($result) {
                return response()->json(['status' => true , 'message' => 'Booking updated successfully']);
                exit;
            }
            else {
                return response()->json(['status' => false , 'message' => 'Something went wrong try again later']);
                exit;
            }
        }

    }

    /**
     * @param $bookingId
     * @method use for remove Booking
     */
    public function removeBooking(Request $request) {
        if (!auth()->user()->can('manual-booking-delete')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}
        try {
            $booking = ManualBooking::find($request->bookingId);
            $result = $booking->delete();
            if ($result) {
                return response()->json(array('status' => true, 'message' => "Booking remove successfully"));
            } else {
                return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
        }
    }
}
