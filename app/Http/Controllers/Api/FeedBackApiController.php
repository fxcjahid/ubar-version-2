<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DriverFeedBack;
use App\Models\User;
use App\Models\UserFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FeedBackApiController extends Controller
{
    private function validation(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'driver_id' => 'required|exists:users,id',
            'booking_id' => 'required|numeric',
            'star' => 'required|numeric',
            'feedback' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()]);
        }

        return $validator->validated();;
    }

    private function calculate_point($star)
    {
        $point = 0;
        if ($star >= 3 && $star < 4) {
            $point = (($star - 3) * (100 - 50) / (4 - 3)) + 50;
        } elseif($star > 4 && $star < 5) {
            $point = (($star - 4) * (200 - 101) / (5 - 4)) + 101;
        }
        return $point;
    }

    public function driver_store(Request $request)
    {
        $input = $this->validation($request);

        $point = $this->calculate_point($input['star']);
        $input['point'] = $point;

        $driver = User::find($input['driver_id']);
        $point = $point + $driver->points;

        try {
            DB::beginTransaction();

            DriverFeedBack::create($input);
            $driver->update(['points' => $point]);

            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Driver Feedback stored']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function user_store(Request $request)
    {
        $input = $this->validation($request);

        $point = $this->calculate_point($input['star']);
        $input['point'] = $point;

        $user = User::find($input['user_id']);
        $point = $point + $user->points;

        try {
            DB::beginTransaction();

            UserFeedback::create($input);
            $user->update(['points' => $point]);

            DB::commit();
            return response()->json(['status' => 200, 'message' => 'User Feedback stored']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
