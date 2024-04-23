<?php

namespace App\Http\Controllers\Admin;

use App\Helper\MyHelper;
use App\Http\Controllers\Controller;
use App\Models\Privilage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Permission extends Controller
{
    //
    public function index() {
        return view('admin.permission.index');
    }

    /**
     * @method use for show manager list for permission
     */
    public function listManagerPermission(Request $request) {
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

        $total = User::select('users.*')
        ->orWhere(function ($query) use ($search) {
            $query->orWhere('name', 'like', '%' . $search . '%');
            $query->orWhere('email', 'like', '%' . $search . '%');
            $query->orWhere('phone', 'like', '%' . $search . '%');
        })
        ->where(['user_type' => "MANAGER"])
        ->get()->count();

        $users = User::select('users.*')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('name', 'like', '%' . $search . '%');
                $query->orWhere('email', 'like', '%' . $search . '%');
                $query->orWhere('phone', 'like', '%' . $search . '%');
            })
            ->where(['user_type' => "MANAGER"])
            ->offset($ofset)->limit($limit)->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];
        foreach ($users as $user) {
            $data[] = array(
                $i++,
                $user->name,
                '<a href="'.url('admin/permission-view/'.$user->id).'" class="btn btn-primary btn-sm editCity" title="Edit"><i class="fa fa-pencil" ></i></a> '
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    /**
     * @param $userId
     * @return view permission
     */
    public function permissionView(Request $request) {
        $id = $request->userId;
        return view('admin.permission.permission' , compact('id'));
    }

    /**
     * @param $id
     * @method use for add privilage for manager
     */
    public function addPrivilage(Request $request) {

        if($request->isMethod('post')) {
            $data = $request->all();
            $validator = Validator::make($data, [
                'moduleNo' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(array('status' => false, 'msg' => $validator->errors()->first()));
                exit;
            } else {

                Privilage::where('staff_id' , $data['staff_id'])->delete();

                foreach ($data['moduleNo'] as $key => $items) {
                    if (isset($data['submodule' . $items])) {
                        foreach ($data['submodule' . $items] as $key1 => $items2) {
                            foreach ($data['access' . $items . $items2] as $key2 => $items3) {
                                if (isset($items3)) {
//                                    echo $items3;
                                    if (isset($data['add' . $items . $items2])) {
                                        $add = $data['add' . $items . $items2];
                                    } else {
                                        $add = ['0' => ''];
                                    }
                                    if (isset($data['edit' . $items . $items2])) {
                                        $edit = $data['edit' . $items . $items2];
                                    } else {
                                        $edit = ['0' => ''];
                                    }
                                    if (isset($data['delete' . $items . $items2])) {
                                        $delete = $data['delete' . $items . $items2];
                                    } else {
                                        $delete = ['0' => ''];
                                    }


                                    if ($items3 === 'Read' || $items3 === 'Write') {
                                        $addPrivilage = new Privilage();
                                        $addPrivilage->staff_id = $data['staff_id'];
                                        $addPrivilage->module   = $items;
                                        $addPrivilage->submodule= $items2;
                                        $addPrivilage->access   = $items3;
                                        $addPrivilage->add      = $add[0];
                                        $addPrivilage->edit     = $edit[0];
                                        $addPrivilage->delete   = $delete[0];
                                        $addPrivilage->status   = 1;
                                        $addPrivilage->created_by = Auth::user()->id;
                                        $result = Privilage::where(['module' => $items, 'submodule' => $items2, 'staff_id' => $data['staff_id']])->get();
                                        if($result->count() > 0) {
                                            $updateData = [
                                                'access' => $items3,
                                                'add' => $add[0],
                                                'edit' => $edit[0],
                                                'delete' => $delete[0],
                                            ];
                                            $affected = Privilage::where(['module' => $items, 'submodule' => $items2, 'staff_id' => $data['staff_id']])->update($updateData);
                                        }
                                        else{

                                            $affected = $addPrivilage->save();
                                        }
                                    }
                                }
                            }

                        }
                    }
                }

                if(isset($affected))
                {
                    return response()->json(array('status' => true,'msg' => "Successfully Updated !"));
                    exit();
                }
                else{
                    return response()->json(array('status' => false,'msg' => "Error Occured, please try again"));
                    exit();
                }
            }
        }
    }

}
