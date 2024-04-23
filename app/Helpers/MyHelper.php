<?php

namespace App\Helpers;

use App\Models\Privilage;
use App\Models\User;

class MyHelper
{
    public static function getUserPrivilages($userid = null, $module = null, $submodule = null)
    {

        if ($userid === 1) {
            $results = [
                '0' => [
                    'access' => 'Write',
                    'add' => 'on',
                    'edit' => 'on',
                    'delete' => 'on'
                ]
            ];
            $data = [
                'submodule' => '',
                'result' => $results
            ];

            return $data;

        }

        if ($module != null && $userid != null && $submodule === null) {
            $result = Privilage::where(['staff_id' => $userid, 'module' => $module, 'status' => 1])->get();
            if ($result && $result->count() > 0) {
                return $module;
            }
        } elseif ($module != null && $userid != null && $submodule != null) {
            $result1 = Privilage::where(['staff_id' => $userid, 'module' => $module, 'submodule' => $submodule, 'status' => 1])->get();
            if ($result1 && $result1->count() > 0) {
                $data = [
                    'submodule' => $submodule,
                    'result' => $result1
                ];
                return json_decode(json_encode($data), true);
            }
        }
    }

    /**----------------------------------------------------------------------------------------------------------------------
     * @package $userid
     *
     * @Method use to get the user privilages details by passing the user id from privilages table / created by @loveleshSingh 27/08/2019
     */

    public static function checkUserPrivilages($userid = null, $module = null, $submodule = null)
    {
        $checkAdmin = User::findOrFail($userid);
        if ($checkAdmin->user_type === "SUPERADMIN") {
            return 1;
        } else {
            if ($userid != null && $userid === null && $submodule === null) {
                $results = Privilage::where(['staff_id' => $userid, 'status' => 1])->get();
            } elseif ($module != null && $userid != null && $submodule === null) {
                $result = Privilage::where(['staff_id' => $userid, 'module' => $module, 'status' => 1])->get();
                if ($result->count() > 0) {
                    return true;
                }
            } elseif ($module != null && $userid != null && $submodule != null) {
                $result1 = Privilage::where(['staff_id' => $userid, 'module' => $module, 'submodule' => $submodule, 'status' => 1])->get();
                if ($result1->count() > 0) {
                    return true;
                }
            }
        }
    }


    public static function findNearestusers($latitude, $longitude, $radius = 10)
    {
        /*
         * using eloquent approach, make sure to replace the "Restaurant" with your actual model name
         * replace 6371000 with 6371 for kilometer and 3956 for miles
         */
        $restaurants = User::where('user_type', 'DRIVER')->whereNotNull('lat')->selectRaw(" id,name, ride_service, lat, `long`,
        (6371 * 2 * ASIN(SQRT( POWER(SIN(( $latitude - lat) * pi()/180 / 2), 2) +COS( $latitude * pi()/180) * COS(lat * pi()/180) * POWER(SIN(( $longitude - `long`) * pi()/180 / 2), 2) ))) as distance")
            ->having("distance", "<", $radius)
            ->orderBy("distance", 'asc')
            ->where('users.active', 1)
            ->offset(0)
            ->limit(20)
            ->get();

        return $restaurants;
    }


}
