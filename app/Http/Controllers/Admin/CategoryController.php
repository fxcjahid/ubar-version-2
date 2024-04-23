<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\Driver;
use App\Models\Type;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    public function index() {
        return view('admin.category.index');
    }

    /**
     * @method use for get category list help of ajax
     */
    public function categoryListAjax(Request $request) {
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

        $total = Category::select('categories.*' , 'users.name')
        ->join('users' , 'categories.created_by' , '=' , 'users.id')
        ->orWhere(function ($query) use ($search) {
            $query->orWhere('category_name', 'like', '%' . $search . '%');
            $query->orWhere('category_description', 'like', '%' . $search . '%');
            $query->orWhere('category_type', 'like', '%' . $search . '%');
        })->get()->count();

        $category = Category::select('categories.*' , 'users.name')
            ->join('users' , 'categories.created_by' , '=' , 'users.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('category_name', 'like', '%' . $search . '%');
                $query->orWhere('category_description', 'like', '%' . $search . '%');
                $query->orWhere('category_type', 'like', '%' . $search . '%');
            })
            ->offset($ofset)->limit($limit)->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];
        foreach ($category as $com) {
            $data[] = array(
                $i++,
                '<img src="'.url($com->category_icon).'" style="width: 50px; height: 50px;" class="rounded">',
                $com->type_name,
                $com->category_name,
                $com->person,
                '<button class="btn btn-sm btn-secondary">'.$com->category_status.'</button>',
                $com->name,
                '<a href="'.url('admin/edit-category/'.$com->id).'" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-pencil" ></i></a> | <a href="#" class="btn btn-sm btn-danger  remove-category" data-id="' . $com->id . '" title="Delete"><i class="fa fa-trash"></i></a>'
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
        public function getCategory($id)
    {

        $cities = Category::where("type_id",$id)
                    ->pluck('category_name','id');
        return json_encode($cities);
    }

    public function create() {
        if (!auth()->user()->can('category-create')) {
			abort(403, 'Unauthorized action.');
		}
        $types = Type::where('t_status','APPROVED')->get();
        return view('admin.category.add',compact('types'));
    }

    /**
     * @param Request $request
     * @method use for store category data
     */
    public function store(Request $request) {
        if (!auth()->user()->can('category-create')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}
        $validation = Validator::make($request->all() , [
            'category'          => 'required|unique:categories,category_name',
            'category_status'   => 'required',
            'description'       => 'required',
        ]);

        if($validation->fails()) {
            return response()->json(['status' => false , 'message' => $validation->errors()->first()]);
            exit;
        }
        else {

            // Category Image
            if ($request->file('category_image')) {
                $fileName = '/assets/category/images/' . uniqid(time()) . '.' . $request->file('category_image')->extension();
                $request->file('category_image')->move(public_path('assets/category/images/'), $fileName);
                $categoryImage = $fileName;
            }else{
                $categoryImage = "";
            }

            // Category Icon
            if ($request->file('category_icon')) {
                $fileNameIcon = '/assets/category/icons/' . uniqid(time()) . '.' . $request->file('category_icon')->extension();
                $request->file('category_icon')->move(public_path('assets/category/icons/'), $fileNameIcon);
                $icon = $fileNameIcon;
            }else{
                $icon = "";
            }

            $type = Type::findOrFail($request->type);

            $category = new Category();
            $input['category_name']         = $request->category;
            $input['category_status']       = $request->category_status;
            $input['category_description']  = $request->description;
            $input['category_icon']         = $icon;
            $input['category_image']        = $categoryImage;
            $input['created_by']            = Auth::user()->id;
            $input['person']                = $request->person;
            $input['type_id']                = $type->id;
            $input['type_name']                = $type->t_name;

            $result = $category->fill($input)->save();

            if($result) {
                return response()->json(['status' => true , 'message' => 'Category added successfully']);
                exit;
            }
            else {
                return response()->json(['status' => false , 'message' => 'Something went wrong try again later !!!']);
                exit;
            }
        }
    }

    /**
     * @param $categoryId
     * @method use for remove category
     */
    public function destroy(Request $request) {
        
        if (!auth()->user()->can('category-delete')) {
			return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
                exit;
		}
        try {
            $category = Category::find($request->categoryId);
            File::delete(public_path('../' . $category->category_icon));
            File::delete(public_path('../' . $category->category_image));
            $result = $category->delete();
            if ($result) {
                return response()->json(array('status' => true, 'message' => "Category remove successfully"));
            } else {
                return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Something went wrong"));
        }
    }

    /**
     * @param $categoryId
     * @return edit view
     */
    public function edit($categoryId) {

        if (!auth()->user()->can('category-edit')) {
			abort(403, 'Unauthorized action.');
		}

        $types = Type::where('t_status','APPROVED')->get();
        $category = Category::findOrFail($categoryId);
        return view('admin.category.edit' , compact('category','types'));
    }

    /**
     * @param Request $request
     * @method use for update category
     */
    public function update(Request $request) {
        if (!auth()->user()->can('category-edit')) {
			abort(403, 'Unauthorized action.');
		}
        $rules = [];
        $checkRules = Category::findOrFail($request->categoryId);

        if($checkRules->category_name != $request->category) {
            $rules['category'] = 'required|unique:categories,category_name';
        }
        $rules = [
            'category_status'   => 'required',
            'description'       => 'required',
        ];
        $validation = Validator::make($request->all() , $rules);

        if($validation->fails()) {
            return response()->json(['status' => false , 'message' => $validation->errors()->first()]);
            exit;
        }
        else {

            $category =Category::findOrFail($request->categoryId);
            // Category Image
            if ($request->file('category_image')) {
                File::delete(public_path('../' . $category->category_image));
                $fileName = '/assets/category/images/' . uniqid(time()) . '.' . $request->file('category_image')->extension();
                $request->file('category_image')->move(public_path('assets/category/images/'), $fileName);
                $categoryImage = $fileName;
                $category->category_image        = $categoryImage;
            }

            // Category Icon
            if ($request->file('category_icon')) {
                File::delete(public_path('../' . $category->category_icon));
                $fileNameIcon = '/assets/category/icons/' . uniqid(time()) . '.' . $request->file('category_icon')->extension();
                $request->file('category_icon')->move(public_path('assets/category/icons/'), $fileNameIcon);
                $icon = $fileNameIcon;
                $category->category_icon         = $icon;
            }

            $type = Type::findOrFail($request->type);

            $category->category_name         = $request->category;
            $category->category_status       = $request->category_status;
            $category->category_description  = $request->description;
            $category->person                = $request->person;
            $category->type_id                = $type->id;
            $category->type_name                = $type->t_name;


            $update = $category->update();

            if($update) {
                return response()->json(['status' => true , 'message' => 'Category updated successfully']);
                exit;
            }
            else {
                return response()->json(['status' => false , 'message' => 'Something went wrong try again later !!!']);
                exit;
            }
        }
    }

}
