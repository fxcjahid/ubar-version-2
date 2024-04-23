<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CityAdmin extends Controller
{
    //
    public function index() {
        if (!auth()->user()->can('city-admin-list')) {
			abort(403, 'Unauthorized action.');
		}
        return view('admin.city-admin.index');
    }

    /**
     * @method use for show city admin list ajax
     */
    public function cityAdminListAjax(Request $request) {
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
        ->where(['user_type' => "CITYADMIN"])
        ->get()->count();

        $users = User::select('users.*')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('name', 'like', '%' . $search . '%');
                $query->orWhere('email', 'like', '%' . $search . '%');
                $query->orWhere('phone', 'like', '%' . $search . '%');
            })
            ->where(['user_type' => "CITYADMIN"])
            ->offset($ofset)->limit($limit)->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];
        foreach ($users as $user) {
            $data[] = array(
                $i++,
                ($user->profile_pic ? '<img src="'.url($user->profile_pic).'"  class="rounded" style="width: 50px; height: 50px;"> ' : '<img src="'.url('assets/images/profile.png').'"  class="rounded" style="width: 50px; height: 50px;">'),
                $user->name,
                $user->email,
                $user->phone,
                $user->address,
                '<a href="javascript:void(0)" class="btn btn-sm '.($user->active == 1 ? "btn-success" : "btn-danger").' statusChange" data-id="'.$user->id.'"  data-active="'.($user->active == 1 ? 0 : 1).'">'.($user->active == 1 ? "ACTIVE" : "DE-ACTIVE").'</a>',
                date('d-m-Y H:i:s' , strtotime($user->created_at)),
                '<a href="'.url('admin/edit-city-admin/'.$user->id).'" class="btn btn-primary btn-sm editCity" title="Edit"><i class="fa fa-pencil" ></i></a> | <a href="#" class="btn btn-sm btn-danger  userRemove" data-id="' . $user->id . '" title="Delete"><i class="fa fa-trash"></i></a>'
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
        if (!auth()->user()->can('city-admin-create')) {
			abort(403, 'Unauthorized action.');
		}
        $roles = Role::pluck('name','name')->all();
        $cities = City::where('status','ACTIVE')->get();
        return view('admin.city-admin.create',compact('roles','cities'));
    }

    /**
     * @param Request $request
     * @method use for store manager details
     */
    public function store(Request $request) {
        if (!auth()->user()->can('city-admin-create')) {
			abort(403, 'Unauthorized action.');
		}
        $validator = Validator::make($request->all() , [
            'first_name'    => 'required',
            'last_name'     => 'required',
            'city_id'     => 'required',
            'phone'         => 'required|unique:users,phone',
            'email'         => 'required|unique:users,email',
            'password'      => 'required|min:3',
            'address'       => 'required'
        ]);
        if($validator->fails()) {
            return response()->json(['status' => false , 'message' => $validator->errors()->first()]);
            exit;
        }
        else {
            // Profile Image
            if ($request->file('profile_image')) {
                $fileName = '/assets/profile/' . uniqid(time()) . '.' . $request->file('profile_image')->extension();
                $request->file('profile_image')->move(public_path('assets/profile/'), $fileName);
                $profile = $fileName;
            }else{
                $profile = "";
            }
            $data = new User();
            $input['unique_id']     = 'CT0091'.time().rand(100000 , 999999);
            $input['first_name']    = $request->first_name;
            $input['last_name']     = $request->last_name;
            $input['email']         = $request->email;
            $input['city_id']         = $request->city_id;
            $input['phone']         = $request->phone;
            $input['password']      = Hash::make($request->password);
            $input['address']       = $request->address;
            $input['profile_pic']   = $profile;
            $input['name']          = $request->first_name . '' . $request->last_name;
            $input['user_type']     = "CITYADMIN";
            $result = $data->fill($input)->save();

            
            $data->assignRole($request->input('roles'));

            if($result) {
                return response()->json(['status' =>true , 'message' => 'City Admin added successfully']);
                exit;
            }else{
                return response()->json(['status' =>false , 'message' => 'Something went wrong try again later!!']);
                exit;
            }
        }
    }

    /**
     * @param $userId
     * @method use for change use status
     */
    public function statusChange(Request $request) {

        if (!auth()->user()->can('city-admin-edit')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}

        try {
            $where = array('id' => $request->userId);
            $data  = array('active' => $request->status);
            $update = User::where($where)->update($data);
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
     * @param $userId
     * @method use for remove manager for list
     */
    public function reomveCity(Request $request) {
        
        if (!auth()->user()->can('city-admin-delete')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}

        try {
            $where = array('id' => $request->userId);
            $delete = User::where($where)->delete();
            if ($delete) {
                return response()->json(array('status' => true, 'message' => "City Admin deleted successfully"));
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
     * @param $managerId
     * @method use for edit manager
     */
    public function edit($managerId) {
        if (!auth()->user()->can('city-admin-edit')) {
			abort(403, 'Unauthorized action.');
		}
        $cities = City::where('status','ACTIVE')->get();
        $manager = User::findOrFail($managerId);
        $roles = Role::pluck('name','name')->all();
        $userRole = $manager->roles->pluck('name','name')->all();

        return view('admin.city-admin.edit' , compact('manager','roles','userRole','cities'));
    }

    /**
     * @param Request $request
     * @method use for update manager
     */
    public function update(Request $request) {
        if (!auth()->user()->can('city-admin-edit')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}
        if (!auth()->user()->can('city-admin-edit')) {
			abort(403, 'Unauthorized action.');
		}

        $managerData = User::findOrFail($request->managerId);
        $rules = [];
        if($managerData->phone != $request->phone) {
            $rules['phone'] = 'required|unique:users,phone';
        }
        if($managerData->email != $request->email) {
            $rules['email'] = 'required|unique:users,email';
        }
        $rules = [
            'first_name'    => 'required',
            'last_name'     => 'required',
            'city_id'     => 'required',
            'address'       => 'required'
        ];
        $validator = Validator::make($request->all() , $rules);

        if($validator->failed()) {
            return response()->json(['status' => false , 'message' => $validator->errors()->first()]);
            exit;
        }
        else{
            // Profile Pic
            if ($request->file('profile_image')) {
                // Old Image remove
                File::delete(public_path('../' . $managerData->profile_pic));
                $fileName = '/assets/profile/' . uniqid(time()) . '.' . $request->file('profile_image')->extension();
                $request->file('profile_image')->move(public_path('assets/profile/'), $fileName);
                $profile = $fileName;
                $managerData->profile_pic = $profile;
            }

            $managerData->first_name    = $request->first_name;
            $managerData->last_name     = $request->last_name;
            $managerData->email         = $request->email;
            $managerData->city_id         = $request->city_id;
            $managerData->phone         = $request->phone;
            $managerData->address       = $request->address;
            $managerData->name          = $request->first_name . ' ' . $request->last_name;
            if(!empty($request->password)) {
                $managerData->password  = Hash::make($request->password);
            }

            $update = $managerData->update();
            
            $managerData->assignRole($request->input('roles'));

            if($update) {
                return response()->json(['status' => true , 'message' => 'City Admin updated successfully']);
                exit;
            }else{
                return response()->json(['status' => false , 'message' => "Something went wrong try again later !!!"]);
                exit;
            }
        }
    }
}
