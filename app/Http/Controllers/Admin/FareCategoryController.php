<?php

namespace App\Http\Controllers\Admin;

use App\Models\FareCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FareCategoryController extends Controller
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
        return view('admin.fare-category.index');
    }

    /**
     * @method use for get category list help of ajax
     */
    public function fareCategoryAjaxList(Request $request) {
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

        $total = FareCategory::with('user','category','type')
        ->orWhere(function ($query) use ($search) {
            $query->orWhere('name', 'like', '%' . $search . '%');
        })->get()->count();

        $type = FareCategory::with('user','category','type')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('name', 'like', '%' . $search . '%');
            })
            ->offset($ofset)->limit($limit)->orderBy($nameOrder , $orderType)->get();


        $i = 1 + $ofset;
        $data = [];
        foreach ($type as $com) {
            $data[] = array(
                $i++,
                $com->name,
                $com->start_time,
                $com->end_time,
                '<button class="btn btn-sm btn-secondary">'.$com->status.'</button>',
                $com->user->name,
                '<a href="'.url('admin/fare-category/'.$com->id.'/edit').'" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-pencil" ></i></a> | <a href="#" class="btn btn-sm btn-danger  remove-type" data-id="' . $com->id . '" title="Delete"><i class="fa fa-trash"></i></a>'
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
        return view('admin.fare-category.add');
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
            'name'          => 'required|unique:fare_categories,name',
            'start_time'          => 'required',
            'end_time'          => 'required',
        ]);

        if($validation->fails()) {
            return response()->json(['status' => false , 'message' => $validation->errors()->first()]);
            exit;
        }
        else {

            

            $type = new FareCategory();
            $input['name']         = $request->name;
            $input['start_time']         = $request->start_time;
            $input['end_time']         = $request->end_time;
            $input['status']       = "ACTIVE";
            $input['created_by']            = Auth::user()->id;

            $result = $type->fill($input)->save();

            if($result) {
                return response()->json(['status' => true , 'message' => 'Fare Category added successfully']);
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
    public function edit($id)
    {
        if (!auth()->user()->can('type-edit')) {
			abort(403, 'Unauthorized action.');
		}
        $fare = FareCategory::findOrFail($id);
        return view('admin.fare-category.edit' , compact('fare'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!auth()->user()->can('type-edit')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}
        $rules = [];
        $checkRules = FareCategory::findOrFail($request->id);

        if($checkRules->name != $request->name) {
            $rules['name'] = 'required|unique:fare_categories,name';
        }
        $rules = [
            'status'   => 'required',
            'start_time'   => 'required',
            'end_time'   => 'required',
        ];
        $validation = Validator::make($request->all() , $rules);

        if($validation->fails()) {
            return response()->json(['status' => false , 'message' => $validation->errors()->first()]);
            exit;
        }
        else {

            $type =FareCategory::findOrFail($request->id);
            $type->name         = $request->name;
            $type->start_time         = $request->start_time;
            $type->end_time         = $request->end_time;
            $type->status       = $request->status;
            $update = $type->update();

            if($update) {
                return response()->json(['status' => true , 'message' => 'Fare Category updated successfully']);
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
            $type = FareCategory::find($request->typeId);
            $result = $type->delete();
            if ($result) {
                return response()->json(array('status' => true, 'message' => "Fare Category remove successfully"));
            } else {
                return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
        }
    }
}
