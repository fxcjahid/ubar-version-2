<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarBooking;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    //
    public function index()
    {
        if (! auth()->user()->can('booking-list')) {
            abort(403, 'Unauthorized action.');
        }

        $booking = CarBooking::get();

        return view('admin.booking.index', compact('booking'));
    }

    /**
     * @method use for get booking list ajax
     */
    public function bookingListAjax(Request $request)
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

        $total = CarBooking::select('car_bookings.*', 'users.name')
            ->join('users', 'car_bookings.user_id', '=', 'users.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('name', 'like', '%' . $search . '%');
                $query->orWhere('pickup_location', 'like', '%' . $search . '%');
                $query->orWhere('destination', 'like', '%' . $search . '%');
            })->get()->count();

        $bookings = CarBooking::select('car_bookings.*', 'users.name', 'users.phone')
            ->join('users', 'car_bookings.user_id', '=', 'users.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('name', 'like', '%' . $search . '%');
                $query->orWhere('pickup_location', 'like', '%' . $search . '%');
                $query->orWhere('destination', 'like', '%' . $search . '%');
            })
            ->offset($ofset)->limit($limit)->orderBy($nameOrder, $orderType)->get();
        $i        = 1 + $ofset;
        $data     = [];
        foreach ($bookings as $item) {
            $drivers = User::findOrFail($item->driver_id);
            $vehicle = Vehicle::findOrFail($item->vehicle_id);
            $data[]  = array(
                $i++,
                $item->invoice_id,
                $item->name . '<br>' . $item->phone,
                $drivers->name . '<br>' . $drivers->phone,
                $item->pickup_location,
                $item->destination,
                $vehicle->vehicle_number . ' - ' . $vehicle->vehicle_brand,
                $item->payment_type,
                $item->total_fare,
                $item->total_distance,
                $item->booking_type,
                ($item->pickup_date != NULL ? date('d-m-Y', strtotime($item->pickup_date)) : ''),
                $item->booking_type,
                $item->booking_status,
                '<a href="' . url('admin/invoice/' . $item->id) . '" class="btn btn-sm btn-primary">Invoice</a>'
            );
        }
        $records['recordsTotal']    = $total;
        $records['recordsFiltered'] = $total;
        $records['data']            = $data;
        echo json_encode($records);
    }

    /**
     * @param Request $request
     * @method use for show invoice
     */
    public function invoice(Request $request)
    {


        $getDetails = CarBooking::select("car_bookings.*", 'users.name', 'users.phone', 'users.unique_id', 'vehicles.vehicle_number',
            'vehicles.vehicle_category', 'fares.minimum_fare', 'vehicle_images.vehicle_image', 'users.profile_pic', 'vehicles.vehicle_brand')
            ->join("users", 'car_bookings.user_id', '=', 'users.id')
            ->join("vehicles", 'car_bookings.vehicle_id', '=', 'vehicles.id')
            ->join("vehicle_images", 'car_bookings.vehicle_id', '=', 'vehicle_images.vehicle_id')
            ->leftjoin("fares", 'vehicles.vehicle_category', '=', 'fares.category_id')
            ->where(['car_bookings.id' => $request->invoice_id])->first();

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
        $dataArray['user_id']                  = $getDetails->user_id;
        $dataArray['user_pic']                 = ($getDetails->profile_pic != NULL ? url($getDetails->profile_pic) : NULL);
        $dataArray['user_id']                  = $getDetails->user_id;
        $dataArray['car_name']                 = $getDetails->vehicle_brand;
        $dataArray['car_number']               = $getDetails->vehicle_number;

        return view('admin.booking.invoice', compact('dataArray'));

    }
}