<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function services()
    {
        $services = Category::select('id', 'category_name', 'category_status')->where('category_status', 'APPROVED')->get();
        return response()->json(['status' => true, 'message' => 'Service Lists.', 'data' => $services]);
    }

    public function packages()
    {
        $types = Type::select('id', 't_name', 't_status')->where('t_status', 'APPROVED')->get();
        return response()->json(['status' => true, 'message' => 'Package Lists.', 'data' => $types]);
    }
}
