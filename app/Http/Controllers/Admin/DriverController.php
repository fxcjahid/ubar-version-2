<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Type;
use App\Models\User;
use App\Models\Category;
use App\Models\DriverDoc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AdminStoreDriverRequest;

class DriverController extends Controller
{
    //
    public function index()
    {

        if (! auth()->user()->can('driver-list')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.driver.index');
    }

    /**
     * @method use for show manager list ajax
     */
    public function driverListAjax(Request $request)
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

        $total = User::select('users.*')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('name', 'like', '%' . $search . '%');
                $query->orWhere('email', 'like', '%' . $search . '%');
                $query->orWhere('phone', 'like', '%' . $search . '%');
            })
            ->where(['user_type' => "DRIVER"])
            ->get()->count();

        $drivers = User::where(function ($query) use ($search) {
            $query->orWhere('name', 'like', '%' . $search . '%');
            $query->orWhere('email', 'like', '%' . $search . '%');
            $query->orWhere('phone', 'like', '%' . $search . '%');
        })
            ->where(['user_type' => "DRIVER"])
            ->offset($ofset)->limit($limit)->orderBy($nameOrder, $orderType)->with('driverDoc')->get();
        $i       = 1 + $ofset;
        $data    = [];
        foreach ($drivers as $driver) {
            if ($driver->driverDoc && $driver->driverDoc->driver_licence_front_pic) {
                $driver_licence_front_pic = url($driver->driverDoc->driver_licence_front_pic);
            } else {
                $driver_licence_front_pic = '';
            }
            $data[] = array(
                $i++,
                $driver->unique_id,
                ($driver->profile_pic ? '<img src="' . url($driver->profile_pic) . '"  class="rounded" style="width: 50px; height: 50px;"> ' : '<img src="' . url('assets/images/profile.png') . '"  class="rounded" style="width: 50px; height: 50px;">'),
                $driver->name,
                $driver->email,
                $driver->phone,
                $driver->address,
                '<a href="javascript:void(0)" class="btn btn-sm ' . ($driver->active == 1 ? "btn-success" : "btn-danger") . ' statusChange" data-id="' . $driver->id . '"  data-active="' . ($driver->active == 1 ? 0 : 1) . '">' . ($driver->active == 1 ? "ACTIVE" : "DE-ACTIVE") . '</a>',
                date('d-m-Y H:i:s', strtotime($driver->created_at)),
                '<a href="' . url('admin/edit-driver/' . $driver->id) . '" class="btn btn-primary btn-sm editCity" title="Edit"><i class="fa fa-pencil" ></i></a> | <a href="#" class="btn btn-sm btn-danger  driverRemove" data-id="' . $driver->id . '" title="Delete"><i class="fa fa-trash"></i></a> | <a href="' . route('admin.driver.document.view', ['id' => $driver->id]) . '" class="btn btn-primary btn-sm viewImg" title="view document"><i class="fa fa-image" ></i></a>'
            );
        }
        $records['recordsTotal']    = $total;
        $records['recordsFiltered'] = $total;
        $records['data']            = $data;
        echo json_encode($records);
    }

    public function documentView($id)
    {
        $data = DriverDoc::where('driver_id', '=', $id)->firstOrFail();

        $items[] = [
            'name' => 'Driver Licence Front Picture',
            'url'  => $data->driver_licence_front_pic,
        ];

        $items[] = [
            'name' => 'Driver Licence Back Picture',
            'url'  => $data->driver_licence_back_pic,
        ];

        $items[] = [
            'name' => 'Car Picture',
            'url'  => $data->car_pic,
        ];

        $items[] = [
            'name' => 'Car Front Side Picture',
            'url'  => $data->car_front_side_pic,
        ];

        $items[] = [
            'name' => 'Car Back Side Picture',
            'url'  => $data->car_back_side_pic,
        ];

        $items[] = [
            'name' => 'Car Registration Picture',
            'url'  => $data->car_registration_pic,
        ];

        $items[] = [
            'name' => 'Car Tax Token Picture',
            'url'  => $data->car_tax_token_licence,
        ];

        $items[] = [
            'name' => 'Car Fitness Picture',
            'url'  => $data->car_fitness_licence,
        ];

        $items[] = [
            'name' => 'Car Insurance Picture',
            'url'  => $data->car_insurance_licence,
        ];

        $items[] = [
            'name' => 'Car Route Permit Picture',
            'url'  => $data->car_insurance_licence,
        ];

        $items[] = [
            'name' => 'Extra Picture',
            'url'  => $data->add_extra_pic,
        ];

        $items[] = [
            'name' => 'Electricity Bill Picture',
            'url'  => $data->electricity_bill_pic,
        ];

        $items[] = [
            'name' => 'Bank Check Book Picture',
            'url'  => $data->bank_check_book_pic,
        ];

        return view('admin.driver.document_view', compact('items'));
    }

    /**
     * @return view create
     */
    public function create()
    {
        if (! auth()->user()->can('driver-create')) {
            abort(403, 'Unauthorized action.');
        }

        $services = Category::get();
        $types    = Type::get();
        $cities   = City::get();

        return view('admin.driver.create', compact('cities', 'types', 'services'));
    }


    private function validation($request, $user_id = null)
    {
        $validator = Validator::make($request->all(), [
            'first_name'        => 'required',
            'last_name'         => 'nullable',
            'phone'             => 'required|unique:users,phone,' . $user_id . ',id',
            'email'             => 'required|unique:users,email,' . $user_id . ',id',
            'password'          => 'nullable|min:5',
            'city_id'           => 'required|exists:cities,id',
            'lat'               => 'nullable|numeric',
            'long'              => 'nullable|numeric',
            'speed'             => 'nullable|numeric',
            'heading'           => 'nullable|string',
            'app_token'         => 'nullable|string',
            'address'           => 'nullable|string',
            'reset_expires'     => 'nullable|date',
            'licence_number'    => 'nullable|numeric',
            'car_owner_mobile'  => 'nullable|numeric',
            'emergency_number'  => 'nullable|numeric',
            'car_model'         => 'nullable|string',
            'car_cc'            => 'nullable|string',
            'car_number'        => 'nullable|string',
            'car_register_year' => 'nullable|date',
            'profile_pic'       => 'nullable',
            'status'            => 'nullable|numeric',
            'gender'            => 'nullable|numeric',
            'ride_service'      => 'nullable',
            'ride_package'      => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Retrieve the validated input...
        return $validator->validated();
    }

    /**
     * Summary of store driver 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(AdminStoreDriverRequest $request)
    {


        // // Handle profile image upload 
        // if ($request->file('profile_pic')) {
        //     $fileName = '/assets/user/' . uniqid(time()) . '.' . $request->file('profile_pic')->extension();
        //     $request->file('profile_pic')->move(public_path('assets/user/'), $fileName);
        //     $validated['profile_pic'] = $fileName;
        // }


        // Merge additional fields with the validated data
        $userData = array_merge($request->all(), [
            'unique_id' => 'DRV91' . rand(100000, 999999),
            'name'      => $request->first_name . ' ' . $request->last_name,
            'password'  => Hash::make($request->password),
            'user_type' => "DRIVER",
            // Add other user fields here
        ]);

        try {
            tap(User::create($userData), function ($user) use ($request) {

                //Created Driver Document

                DriverDoc::create([
                    'driver_id'                => $user->id,
                    'driver_licence_front_pic' => $this->uploadFile($request->file('driver_licence_front_pic')),
                    'driver_licence_back_pic'  => $this->uploadFile($request->file('driver_licence_back_pic')),
                    'car_pic'                  => $this->uploadFile($request->file('car_pic')),
                    'electricity_bill_pic'     => $this->uploadFile($request->file('electricity_bill_pic')),
                    'bank_check_book_pic'      => $this->uploadFile($request->file('bank_check_book_pic')),
                    'car_front_side_pic'       => $this->uploadFile($request->file('car_front_side_pic')),
                    'car_back_side_pic'        => $this->uploadFile($request->file('car_back_side_pic')),
                    'car_registration_pic'     => $this->uploadFile($request->file('car_registration_pic')),
                    'gps_tracking'             => $request->gps_tracking,
                    'cctv_sur'                 => 'hmm', // Assuming this field is always 'hmm'
                ]);
            });

            return redirect()
                ->route('admin.driver')
                ->with('success', 'Driver added successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Function to upload a file and return its path
    private function uploadFile($file)
    {
        if ($file) {
            $filePath = '/assets/driver/document/' . uniqid(time()) . '.' . $file->extension();
            $file->move(public_path('assets/driver/document/'), $filePath);
            return $filePath;
        }
        return null;
    }

    /**
     * @param $userId
     * @method use for change use status
     */
    public function statusChange(Request $request)
    {

        if (! auth()->user()->can('driver-edit')) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
            exit;
        }

        try {
            $where  = array('id' => $request->userId);
            $data   = array('active' => $request->status);
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
    public function reomveDriver(Request $request)
    {
        if (! auth()->user()->can('driver-delete')) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
            exit;
        }
        try {
            $where  = array('id' => $request->userId);
            $delete = User::where($where)->delete();
            if ($delete) {
                return response()->json(array('status' => true, 'message' => "Driver deleted successfully"));
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
    public function edit($userId)
    {
        if (! auth()->user()->can('driver-edit')) {
            abort(403, 'Unauthorized action.');
        }

        $services = Category::get();
        $types    = Type::get();
        $cities   = City::get();
        $user     = User::findOrFail($userId);
        return view('admin.driver.edit', compact('user', 'cities', 'services', 'types'));
    }

    public function docs($userId)
    {
        if (! auth()->user()->can('driver-edit')) {
            abort(403, 'Unauthorized action.');
        }

        $services = Category::get();
        $types    = Type::get();
        $cities   = City::get();
        $user     = User::findOrFail($userId);
        return view('admin.driver.docs', compact('user', 'cities', 'services', 'types'));
    }

    /**
     * @param Request $request
     * @method use for update manager
     */
    public function update(Request $request, User $user)
    {
        if (! auth()->user()->can('driver-edit')) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
        }


        $validated = $this->validation($request, $user->id);

        // Profile Image
        if ($request->file('profile_pic')) {
            $fileName = '/assets/user/' . uniqid(time()) . '.' . $request->file('profile_pic')->extension();
            $request->file('profile_pic')->move(public_path('assets/user/'), $fileName);
            $validated['profile_pic'] = $fileName;
        }

        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];

        if ($request->password) {
            $validated['password'] = Hash::make($validated['password']);
        }
        try {
            $user->update($validated);
            return redirect()->back()->with(['success' => 'Driver Update Successfully']);
        } catch (\Exception $e) {
            if ($request->file('profile_pic')) {
                $imagePath = public_path($validated['profile_pic']);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
            return redirect()->back()->with(['error', $e->getMessage()]);
        }
    }

    public function updateDocs(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'driver_licence_front_pic' => 'nullable|mimes:jpeg,jpg,png,webp',
            'driver_licence_back_pic'  => 'nullable|mimes:jpeg,jpg,png,webp',
            'car_pic'                  => 'nullable|mimes:jpeg,jpg,png,webp',
            'electricity_bill_pic'     => 'nullable|mimes:jpeg,jpg,png,webp',
            'bank_check_book_pic'      => 'nullable|mimes:jpeg,jpg,png,webp',
            'car_front_side_pic'       => 'nullable|mimes:jpeg,jpg,png,webp',
            'car_back_side_pic'        => 'nullable|mimes:jpeg,jpg,png,webp',
            'car_registration_pic'     => 'nullable|mimes:jpeg,jpg,png,webp',
            'gps_tracking'             => 'required',
        ]);

        if (! auth()->user()->can('driver-edit')) {
            return response()->json(array('status' => false, 'message' => "Opps!! , Dont have Permission"));
            exit;
        }

        $driverdoc = DriverDoc::where('driver_id', $user->id)->first();

        if ($request->file('driver_licence_front_pic')) {
            if ($driverdoc && File::exists($driverdoc->driver_licence_front_pic)) {
                File::delete($driverdoc->driver_licence_front_pic);
            }

            $driver_licence_front_pic = '/assets/driver/document/' . uniqid(time()) . '.' . $request->file('driver_licence_front_pic')->extension();
            $request->file('driver_licence_front_pic')->move(public_path('assets/driver/document/'), $driver_licence_front_pic);
        } else {
            $driver_licence_front_pic = null;
        }

        if ($request->file('driver_licence_back_pic')) {
            if ($driverdoc && File::exists($driverdoc->driver_licence_back_pic)) {
                File::delete($driverdoc->driver_licence_back_pic);
            }

            $driver_licence_back_pic = '/assets/user/' . uniqid(time()) . '.' . $request->file('driver_licence_back_pic')->extension();
            $request->file('driver_licence_back_pic')->move(public_path('assets/driver/document/'), $driver_licence_back_pic);
        } else {
            $driver_licence_back_pic = null;
        }

        if ($request->file('car_pic')) {
            if ($driverdoc && File::exists($driverdoc->car_pic)) {
                File::delete($driverdoc->car_pic);
            }

            $car_pic = '/assets/user/' . uniqid(time()) . '.' . $request->file('car_pic')->extension();
            $request->file('car_pic')->move(public_path('assets/driver/document/'), $car_pic);
        } else {
            $car_pic = null;
        }

        if ($request->file('electricity_bill_pic')) {
            if ($driverdoc && File::exists($driverdoc->electricity_bill_pic)) {
                File::delete($driverdoc->electricity_bill_pic);
            }

            $electricity_bill_pic = '/assets/user/' . uniqid(time()) . '.' . $request->file('electricity_bill_pic')->extension();
            $request->file('electricity_bill_pic')->move(public_path('assets/driver/document/'), $electricity_bill_pic);
        } else {
            $electricity_bill_pic = null;
        }

        if ($request->file('bank_check_book_pic')) {
            if ($driverdoc && File::exists($driverdoc->bank_check_book_pic)) {
                File::delete($driverdoc->bank_check_book_pic);
            }

            $bank_check_book_pic = '/assets/user/' . uniqid(time()) . '.' . $request->file('bank_check_book_pic')->extension();
            $request->file('bank_check_book_pic')->move(public_path('assets/driver/document/'), $bank_check_book_pic);
        } else {
            $bank_check_book_pic = null;
        }

        if ($request->file('car_front_side_pic')) {
            if ($driverdoc && File::exists($driverdoc->car_front_side_pic)) {
                File::delete($driverdoc->car_front_side_pic);
            }

            $car_front_side_pic = '/assets/user/' . uniqid(time()) . '.' . $request->file('car_front_side_pic')->extension();
            $request->file('car_front_side_pic')->move(public_path('assets/driver/document/'), $car_front_side_pic);
        } else {
            $car_front_side_pic = null;
        }

        if ($request->file('car_back_side_pic')) {
            if ($driverdoc && File::exists($driverdoc->car_back_side_pic)) {
                File::delete($driverdoc->car_back_side_pic);
            }

            $car_back_side_pic = '/assets/user/' . uniqid(time()) . '.' . $request->file('car_back_side_pic')->extension();
            $request->file('car_back_side_pic')->move(public_path('assets/driver/document/'), $car_back_side_pic);
        } else {
            $car_back_side_pic = null;
        }

        if ($request->file('car_registration_pic')) {
            if ($driverdoc && File::exists($driverdoc->car_registration_pic)) {
                File::delete($driverdoc->car_registration_pic);
            }

            $car_registration_pic = '/assets/user/' . uniqid(time()) . '.' . $request->file('car_registration_pic')->extension();
            $request->file('car_registration_pic')->move(public_path('assets/driver/document/'), $car_registration_pic);
        } else {
            $car_registration_pic = null;
        }

        if ($driverdoc) {
            $driverdoc->driver_licence_front_pic = $driver_licence_front_pic;
            $driverdoc->driver_licence_back_pic  = $driver_licence_back_pic;
            $driverdoc->car_pic                  = $car_pic;
            $driverdoc->electricity_bill_pic     = $electricity_bill_pic;
            $driverdoc->bank_check_book_pic      = $bank_check_book_pic;
            $driverdoc->car_front_side_pic       = $car_front_side_pic;
            $driverdoc->car_back_side_pic        = $car_back_side_pic;
            $driverdoc->car_registration_pic     = $car_registration_pic;
            $driverdoc->gps_tracking             = $request->gps_tracking;
            $driverdoc->save();
        } else {
            DriverDoc::create(['driver_id' => $user->id, 'driver_licence_front_pic' => $driver_licence_front_pic, 'driver_licence_back_pic' => $driver_licence_back_pic, 'car_pic' => $car_pic, 'electricity_bill_pic' => $electricity_bill_pic, 'bank_check_book_pic' => $bank_check_book_pic, 'car_front_side_pic' => $car_front_side_pic, 'car_back_side_pic' => $car_back_side_pic, 'car_registration_pic' => $car_registration_pic, 'gps_tracking' => $request->gps_tracking, 'cctv_sur' => 'hmm']);
        }

        return redirect('/admin/driver')->with(['success' => 'Driver Update Successfully']);
    }

    /**
     * @return view new driver view
     */
    public function newDriver()
    {
        if (! auth()->user()->can('new-driver-list')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.driver.new-driver');
    }

    /**
     * @method use for show new driver list ajax
     */
    public function newDriverListAjax(Request $request)
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

        $total = User::select('users.*')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('name', 'like', '%' . $search . '%');
                $query->orWhere('email', 'like', '%' . $search . '%');
                $query->orWhere('phone', 'like', '%' . $search . '%');
            })
            ->where(['user_type' => "DRIVER"])
            ->where(['user_register_from' => "WEB"])
            ->get()->count();

        $drivers = User::select('users.*')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('name', 'like', '%' . $search . '%');
                $query->orWhere('email', 'like', '%' . $search . '%');
                $query->orWhere('phone', 'like', '%' . $search . '%');
            })
            ->where(['user_type' => "DRIVER"])
            ->where(['user_register_from' => "WEB"])
            ->offset($ofset)->limit($limit)->orderBy($nameOrder, $orderType)->get();
        $i       = 1 + $ofset;
        $data    = [];
        foreach ($drivers as $driver) {
            $data[] = array(
                $i++,
                $driver->unique_id,
                ($driver->profile_pic ? '<img src="' . url($driver->profile_pic) . '"  class="rounded" style="width: 50px; height: 50px;"> ' : '<img src="' . url('assets/images/profile.png') . '"  class="rounded" style="width: 50px; height: 50px;">'),
                $driver->name,
                $driver->email,
                $driver->phone,
                $driver->gender,
                $driver->address,
                '<a href="javascript:void(0)" class="btn btn-sm ' . ($driver->active == 1 ? "btn-success" : "btn-danger") . ' statusChange" data-id="' . $driver->id . '"  data-active="' . ($driver->active == 1 ? 0 : 1) . '">' . ($driver->active == 1 ? "ACTIVE" : "DE-ACTIVE") . '</a>',
                date('d-m-Y H:i:s', strtotime($driver->created_at)),
                '<a href="' . url('admin/edit-driver/' . $driver->id) . '" class="btn btn-primary btn-sm editCity" title="Edit"><i class="fa fa-pencil" ></i></a> | <a href="#" class="btn btn-sm btn-danger  driverRemove" data-id="' . $driver->id . '" title="Delete"><i class="fa fa-trash"></i></a>'
            );
        }
        $records['recordsTotal']    = $total;
        $records['recordsFiltered'] = $total;
        $records['data']            = $data;
        echo json_encode($records);
    }
}