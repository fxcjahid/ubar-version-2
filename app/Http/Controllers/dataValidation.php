<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\dataValidationRequest;

class dataValidation extends Controller
{
    /**
     * Validation existsing data
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function exists(Request $request)
    {
        $request = $request->only([
            'email',
            'phone',
        ]);

        $validator = Validator::make($request, [
            'email' => 'email|unique:users,email',
            'phone' => 'numeric|unique:users,phone',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'exists'  => true,
                'status'  => 200,
                'message' => $validator->errors(),
            ], 200);
        }

        return response()->json([
            'exists'  => false,
            'status'  => 200,
            'message' => 'The data is not exists',
        ], 200);
    }
}