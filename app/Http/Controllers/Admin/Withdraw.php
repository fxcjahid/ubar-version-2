<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\withdraw as ModelsWithdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Withdraw extends Controller
{
    //
    public function index() {
        if (!auth()->user()->can('withdraw-list')) {
			abort(403, 'Unauthorized action.');
		}
        return view('admin.withdraw.index');
    }

    /**
     * @method use for show withdraw list ajax
     */
    public function withdrawAjaxList(Request $request) {
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

        $total = ModelsWithdraw::select('withdraws.*' , 'users.name')
        ->join('users' , 'withdraws.user_id' , '=' , 'users.id')
        ->orWhere(function ($query) use ($search) {
            $query->orWhere('name', 'like', '%' . $search . '%');
            $query->orWhere('amount', 'like', '%' . $search . '%');
            $query->orWhere('withdraws.phone', 'like', '%' . $search . '%');
            $query->orWhere('withdraws.email', 'like', '%' . $search . '%');
        })
        ->get()->count();

        $withdraws = ModelsWithdraw::select('withdraws.*' , 'users.name')
        ->join('users' , 'withdraws.user_id' , '=' , 'users.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('name', 'like', '%' . $search . '%');
                $query->orWhere('amount', 'like', '%' . $search . '%');
                $query->orWhere('withdraws.phone', 'like', '%' . $search . '%');
                $query->orWhere('withdraws.email', 'like', '%' . $search . '%');
            })
            ->offset($ofset)->limit($limit)->orderBy($nameOrder , $orderType)->get();

        $i = 1 + $ofset;
        $data = [];
        foreach ($withdraws as $withdraw) {
            $data[] = array(
                $i++,
                '<b>'.$withdraw->name.'</b>',
                $withdraw->amount,
                $withdraw->phone,
                $withdraw->email,
                $withdraw->comment,
                '<button class="btn btn-sm '.($withdraw->status == "PENDING" ? "btn-warning" : ($withdraw->status == "COMPLETED" ? "btn-success" : ($withdraw->status == "CANCELLED" ? "btn-danger" : ($withdraw->status == "APPROVED" ? "btn-success" : "")))).'">'.$withdraw->status.'</button>',
                '<a href="'.url('admin/edit-withdraw/'.$withdraw->id).'" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-pencil" ></i></a>',
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    /**
     * @return view withdraw
     */
    public function create() {
        if (!auth()->user()->can('withdraw-create')) {
			abort(403, 'Unauthorized action.');
		}
        $users = User::where(['status' => 'ACTIVE' , 'user_type' => "USER"])->get();
        return view('admin.withdraw.withdraw' , compact('users'));
    }

    /**
     * @param Request $request
     * @method use for store withdraw amount
     */
    public function store(Request $request) {
        if (!auth()->user()->can('withdraw-create')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}

        $validator = Validator::make($request->all() , [
            'amount' => 'required|integer',
            'user'   => 'required|exists:users,id',
            'status' => 'required',
            'comment'=> 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => false , 'message' => $validator->errors()->first()]);
            exit;
        }
        else {
            $getUser = User::findOrFail($request->user);
            if($request->amount > 0) {
                if($getUser->wallet >= $request->amount) {
                    $data = new ModelsWithdraw();
                    $input['user_id']       = $request->user;
                    $input['amount']        = $request->amount;
                    $input['status']        = $request->status;
                    $input['comment']       = $request->comment;
                    $input['email']         = $request->email;
                    $input['phone']         = $request->phone;
                    $result = $data->fill($input)->save();

                }
                else {
                    return response()->json(['status' => false , 'message' => "Your wallet amount left - " . $getUser->wallet]);
                    exit;
                }
            }
            else{
                return response()->json(['status' => false , 'message' => "You can not withdraw 0 amount"]);
                exit;
            }


        }
        if($result) {
            $getUser->wallet = ($getUser->wallet - $request->amount);
            $getUser->update();
            return response()->json(['status' => true , 'message' => "withdraw successfully"]);
            exit;
        }
        else {
            return response()->json(['status' => false , 'message' => "Something went wrong try again later"]);
            exit;
        }
    }

    /**
     * @method use for edit withdraw
     */
    public function edit(Request $request) {
        if (!auth()->user()->can('withdraw-edit')) {
			abort(403, 'Unauthorized action.');
		}
        $withdraw = ModelsWithdraw::findOrFail($request->withdraw);
        return view('admin.withdraw.edit' , compact('withdraw'));
    }

    /**
     * @param Request $request
     * @method use for update withdraw
     */
    public function update(Request $request) {

        if (!auth()->user()->can('withdraw-edit')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}

        try {
            $where = array('id' => $request->withdraw_id);
            $data  = array('status' => $request->status);

            $update = ModelsWithdraw::where($where)->update($data);

            if($update) {
                return response()->json(['status' => true , 'message' => 'Status update successfully']);
                exit;
            }
            else{
                return response()->json(['status' => false , 'message' => 'Something went worng try again later']);
                exit;
            }
        } catch (\Illuminate\Database\QueryException $e) {
            //throw $th;
            return response()->json(['status' => false , 'message' => 'Something went worng try again later']);
            exit;
        }
    }
}
