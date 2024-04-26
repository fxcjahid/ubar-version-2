<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommissionController extends Controller
{
    //
    public function index()
    {
        if (! auth()->user()->can('company-commission-list')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.commission.index');
    }

    /**
     * @param Request $request
     * @method use for store company commission
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('company-commission-create')) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
            exit;
        }
        $validator = Validator::make($request->all(), [
            'commission_type' => 'required',
            'commission'      => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        } else {
            $data                     = new Commission();
            $input['commission_type'] = $request->commission_type;
            $input['commission']      = $request->commission;
            $input['user_type']       = "COMPANY";

            $result = $data->fill($input)->save();
        }
        if ($result) {
            return response()->json(['status' => true, 'message' => 'Company Commission added successfully']);
            exit;
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong try again later']);
            exit;
        }
    }

    /**
     * @method use for get company commisison list ajax
     */
    public function companyCommissionListAjax(Request $request)
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

        $total = Commission::select('commissions.*')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('commission_type', 'like', '%' . $search . '%');
                $query->orWhere('commission', 'like', '%' . $search . '%');
            })
            ->where(['user_type' => "COMPANY"])
            ->get()->count();

        $category = Commission::select('commissions.*')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('commission_type', 'like', '%' . $search . '%');
                $query->orWhere('commission', 'like', '%' . $search . '%');
            })
            ->where(['user_type' => "COMPANY"])
            ->offset($ofset)->limit($limit)->orderBy($nameOrder, $orderType)->get();
        $i        = 1 + $ofset;
        $data     = [];
        foreach ($category as $com) {
            $data[] = array(
                $i++,
                $com->commission_type,
                ($com->commission_type == "amount" ? $com->commission : $com->commission . '%'),
                '<a href="javascript:void(0)" class="btn btn-primary btn-sm editCommission" data-id="' . $com->id . '" data-commission_type="' . $com->commission_type . '" data-commission="' . $com->commission . '" title="Edit"><i class="fa fa-pencil" ></i></a> | <a href="#" class="btn btn-sm btn-danger  remove-commission" data-id="' . $com->id . '" title="Delete"><i class="fa fa-trash"></i></a>'
            );
        }
        $records['recordsTotal']    = $total;
        $records['recordsFiltered'] = $total;
        $records['data']            = $data;
        echo json_encode($records);
    }

    /**
     * @param Request $request
     * @method use for update company commission
     */
    public function updateCompanyCommission(Request $request)
    {
        if (! auth()->user()->can('company-commission-edit')) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
            exit;
        }

        $validator = Validator::make($request->all(), [
            'commission_type' => 'required',
            'commission'      => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        } else {
            $data                  = Commission::findOrFail($request->commission_id);
            $data->commission_type = $request->commission_type;
            $data->commission      = $request->commission;

            $result = $data->update();
        }
        if ($result) {
            return response()->json(['status' => true, 'message' => 'Company Commission updated successfully']);
            exit;
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong try again later']);
            exit;
        }
    }

    /**
     * @param Request $request
     * @method use for delete commission
     */
    public function removeComCommission(Request $request)
    {
        if (! auth()->user()->can('company-commission-delete')) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
            exit;
        }
        try {
            $commission = Commission::find($request->id);
            $result     = $commission->delete();
            if ($result) {
                return response()->json(array('status' => true, 'message' => "Commission remove successfully"));
            } else {
                return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
        }
    }


    // New Agent Commission
    //
    public function agentIndex()
    {
        if (! auth()->user()->can('agent-commission-list')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.agent.index');
    }

    /**
     * @param Request $request
     * @method use for store company commission
     */
    public function agentStore(Request $request)
    {
        if (! auth()->user()->can('agent-commission-create')) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
            exit;
        }

        $validator = Validator::make($request->all(), [
            'commission_type' => 'required',
            'commission'      => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        } else {
            $data                     = new Commission();
            $input['commission_type'] = $request->commission_type;
            $input['commission']      = $request->commission;
            $input['user_type']       = "AGENT";

            $result = $data->fill($input)->save();
        }
        if ($result) {
            return response()->json(['status' => true, 'message' => 'Agent Commission added successfully']);
            exit;
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong try again later']);
            exit;
        }
    }

    /**
     * @method use for get company commisison list ajax
     */
    public function agentCommissionListAjax(Request $request)
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

        $total = Commission::select('commissions.*')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('commission_type', 'like', '%' . $search . '%');
                $query->orWhere('commission', 'like', '%' . $search . '%');
            })
            ->where(['user_type' => "AGENT"])
            ->get()->count();

        $category = Commission::select('commissions.*')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('commission_type', 'like', '%' . $search . '%');
                $query->orWhere('commission', 'like', '%' . $search . '%');
            })
            ->where(['user_type' => "AGENT"])
            ->offset($ofset)->limit($limit)->orderBy($nameOrder, $orderType)->get();
        $i        = 1 + $ofset;
        $data     = [];
        foreach ($category as $com) {
            $data[] = array(
                $i++,
                $com->commission_type,
                ($com->commission_type == "amount" ? $com->commission : $com->commission . '%'),
                $com->city_name,
                '<a href="javascript:void(0)" class="btn btn-primary btn-sm editCommission" data-id="' . $com->id . '" data-commission_type="' . $com->commission_type . '" data-commission="' . $com->commission . '" title="Edit"><i class="fa fa-pencil" ></i></a> | <a href="#" class="btn btn-sm btn-danger  remove-commission" data-id="' . $com->id . '" title="Delete"><i class="fa fa-trash"></i></a>'
            );
        }
        $records['recordsTotal']    = $total;
        $records['recordsFiltered'] = $total;
        $records['data']            = $data;
        echo json_encode($records);
    }

    /**
     * @param Request $request
     * @method use for update company commission
     */
    public function updateAgentCommission(Request $request)
    {

        if (! auth()->user()->can('agent-commission-edit')) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
            exit;
        }

        $validator = Validator::make($request->all(), [
            'commission_type' => 'required',
            'commission'      => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        } else {
            $data                  = Commission::findOrFail($request->commission_id);
            $data->commission_type = $request->commission_type;
            $data->commission      = $request->commission;

            $result = $data->update();
        }
        if ($result) {
            return response()->json(['status' => true, 'message' => 'Agent Commission updated successfully']);
            exit;
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong try again later']);
            exit;
        }
    }

    /**
     * @param Request $request
     * @method use for delete commission
     */
    public function removeAgentCommission(Request $request)
    {
        if (! auth()->user()->can('agent-commission-delete')) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
            exit;
        }
        try {
            $commission = Commission::find($request->id);
            $result     = $commission->delete();
            if ($result) {
                return response()->json(array('status' => true, 'message' => "Commission remove successfully"));
            } else {
                return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
        }
    }
}