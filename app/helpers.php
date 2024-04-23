<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;

if (!function_exists('get_image_url')) {
    function get_image_url($image)
    {
        if ($image === null) {
            return null;
        }
        
        return url('/'). $image;
    }
}

if (!function_exists('get_points')) {
    function get_points($id)
    {
        $user = User::where('id', $id)->first();

        if ($user) {
            return $user->points;
        } else {
            return 0;
        }
    }
}
if (!function_exists('get_option')) {
    function get_option($name, $default = null)
    {
        if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
            $setting = DB::table('settings')->where('name', $name)->get();
            if (!$setting->isEmpty()) {
                return $setting[0]->value;
            }
        }

        return $default;
    }
}

if (!function_exists('send_otp')) {
    function send_otp(string $phone, $verification_code = null): string
    {
        $message = 'Your Ubar code is' . $verification_code . ' Please Never shere this code.';
        $post_url = env('SMS_END_POINT');

        $post_values = array(
            'api_token' => env('SMS_API_KEY'),
            'senderid' => env('SMS_SENDER_ID'),
            'message' => $message,
            'contact_number' => $phone,
        );

        $post_string = "";
        foreach ($post_values as $key => $value) {
            $post_string .= "$key=" . urlencode($value) . "&";
        }
        $post_string = rtrim($post_string, "& ");

        $request = curl_init($post_url);
        curl_setopt($request, CURLOPT_HEADER, 0);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
        $post_response = curl_exec($request);

        curl_close($request);

        $array = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $post_response), true);

        if ($array) {
            return $array['status'];
        } else {
            return false;
        }
    }
}

?>
