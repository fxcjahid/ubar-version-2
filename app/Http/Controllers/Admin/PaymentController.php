<?php

namespace App\Http\Controllers\Admin;


use App\Models\Payment;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{

    public function manualPayments()
    {

        return view('admin.payments.index');


    }




    /**
     * @method use for show manager list ajax
     */
    public function paymentListAjax(Request $request)
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

        $total = Payment::select('payments.*')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('payment_method', 'like', '%' . $search . '%');
                $query->orWhere('mobile_no', 'like', '%' . $search . '%');
                $query->orWhere('transaction_no', 'like', '%' . $search . '%');
            })

            ->get()->count();

        $users = Payment::select('payments.*')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('payment_method', 'like', '%' . $search . '%');
                $query->orWhere('mobile_no', 'like', '%' . $search . '%');
                $query->orWhere('amount', 'like', '%' . $search . '%');
                $query->orWhere('transaction_no', 'like', '%' . $search . '%');
            })

            ->offset($ofset)->limit($limit)->orderBy($nameOrder, $orderType)->get();
        $i     = 1 + $ofset;
        $data  = [];
        foreach ($users as $user) {
            $data[] = array(
                $i++,

                $user->userid,
                $user->payment_type,
                $user->payment_method,
                $user->amount,
                $user->transaction_no,
                $user->mobile_no,



                '<a href="javascript:void(0)" class="btn btn-sm ' . ($user->status == 1 ? "btn-success" : "btn-danger") . ' statusChange" data-id="' . $user->id . '"  data-active="' . ($user->status == 1 ? 0 : 1) . '">' . ($user->status == 1 ? "Approved" : "Unapproved") . '</a>',
                date('d-m-Y H:i:s', strtotime($user->created_at)),
                '<a href="#" class="btn btn-sm btn-danger  userRemove" data-id="' . $user->id . '" title="Delete"><i class="fa fa-trash"></i></a>'
            );
        }
        $records['recordsTotal']    = $total;
        $records['recordsFiltered'] = $total;
        $records['data']            = $data;
        echo json_encode($records);
    }


    public function statusChange(Request $request)
    {
        if (! auth()->user()->can('user-edit')) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
            exit;
        }

        try {
            $where = array('id' => $request->userId);
            $data  = array('status' => $request->status);
            // $update = Payment::where('id',$request->userId)->first();
            // $update->update(['status',0]);
            $update = DB::table('payments')
                ->where('id', $request->userId)
                ->update([
                    'status' => $request->status,

                ]);

            if ($update) {
                return response()->json(array('status' => 1, 'message' => "Status updated successfully"));
                exit;
            } else {
                return response()->json(array('status' => 0, 'message' => "Opps!! , Something went wrong"));
                exit;
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
            exit;
        }
    }


    public function reomvePayment(Request $request)
    {
        if (! auth()->user()->can('user-delete')) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
            exit;
        }
        try {
            $where  = array('id' => $request->userId);
            $delete = Payment::where($where)->delete();
            if ($delete) {
                return response()->json(array('status' => true, 'message' => "User deleted successfully"));
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