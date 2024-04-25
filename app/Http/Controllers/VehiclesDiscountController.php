<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Models\vehiclesDiscount;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\vehiclesDiscountStore;
use VehicleDiscount;

class VehiclesDiscountController extends Controller
{
    /**
     * Summary of discount data list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = vehiclesDiscount::all();

        return view('admin.vehicle-discount.index', compact('data'));
    }

    /**
     * Summary of create discount for vehicles
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $types = Type::where('t_status', 'APPROVED')->get();
        return view('admin.vehicle-discount.create', compact('types'));
    }

    public function store(vehiclesDiscountStore $request)
    {

        $store = vehiclesDiscount::store($request->all());

        return response()->json($store);
    }
}