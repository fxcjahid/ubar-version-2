<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (!auth()->user()->can('type-list')) {
			abort(403, 'Unauthorized action.');
		}
        return view('admin.type.index');
    }

    /**
     * @method use for get category list help of ajax
     */
    public function typeAjaxList(Request $request) {
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

        $total = Type::select('types.*' , 'users.name as username')
        ->join('users' , 'types.created_by' , '=' , 'users.id')
        ->orWhere(function ($query) use ($search) {
            $query->orWhere('name', 'like', '%' . $search . '%');
        })->get()->count();

        $type = Type::select('types.*' , 'users.name as username')
            ->join('users' , 'types.created_by' , '=' , 'users.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('name', 'like', '%' . $search . '%');
            })
            ->offset($ofset)->limit($limit)->orderBy($nameOrder , $orderType)->get();


        $i = 1 + $ofset;
        $data = [];
        foreach ($type as $com) {
            $data[] = array(
                $i++,
                $com->t_name,
                '<button class="btn btn-sm btn-secondary">'.$com->t_status.'</button>',
                $com->username,
                '<a href="'.url('admin/edit-type/'.$com->id).'" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-pencil" ></i></a> | <a href="#" class="btn btn-sm btn-danger  remove-type" data-id="' . $com->id . '" title="Delete"><i class="fa fa-trash"></i></a>'
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    /**
     * @return view create category
     */
    public function create() {
        if (!auth()->user()->can('type-create')) {
			abort(403, 'Unauthorized action.');
		}
        return view('admin.type.add');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('type-create')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}
        $validation = Validator::make($request->all() , [
            't_name'          => 'required|unique:types,t_name',
            't_status'   => 'required',
        ]);

        if($validation->fails()) {
            return response()->json(['status' => false , 'message' => $validation->errors()->first()]);
            exit;
        }
        else {

            

            $type = new Type();
            $input['t_name']         = $request->t_name;
            $input['t_status']       = $request->t_status;
            $input['created_by']            = Auth::user()->id;

            $result = $type->fill($input)->save();

            if($result) {
                return response()->json(['status' => true , 'message' => 'Type added successfully']);
                exit;
            }
            else {
                return response()->json(['status' => false , 'message' => 'Something went wrong try again later !!!']);
                exit;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit1($id)
    {
        if (!auth()->user()->can('type-edit')) {
			abort(403, 'Unauthorized action.');
		}
        $type = Type::findOrFail($id);
        return view('admin.type.edit' , compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update1(Request $request)
    {
        if (!auth()->user()->can('type-edit')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}
        $rules = [];
        $checkRules = type::findOrFail($request->id);

        if($checkRules->t_name != $request->t_name) {
            $rules['t_name'] = 'required|unique:types,t_name';
        }
        $rules = [
            't_status'   => 'required',
        ];
        $validation = Validator::make($request->all() , $rules);

        if($validation->fails()) {
            return response()->json(['status' => false , 'message' => $validation->errors()->first()]);
            exit;
        }
        else {

            $type =Type::findOrFail($request->id);
            $type->t_name         = $request->t_name;
            $type->t_status       = $request->t_status;
            $update = $type->update();

            if($update) {
                return response()->json(['status' => true , 'message' => 'Type updated successfully']);
                exit;
            }
            else {
                return response()->json(['status' => false , 'message' => 'Something went wrong try again later !!!']);
                exit;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) {
        if (!auth()->user()->can('type-delete')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}
        try {
            $type = Type::find($request->typeId);
            $result = $type->delete();
            if ($result) {
                return response()->json(array('status' => true, 'message' => "Type remove successfully"));
            } else {
                return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
        }
    }
}
