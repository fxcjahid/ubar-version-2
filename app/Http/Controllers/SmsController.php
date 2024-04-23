<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsController extends Controller
{
    private $responce = ['status' => 200, "messeng" => "ok"];
    private function response(string $messeng = "ok", int $status = 200)
    {
        $this->responce['status'] = $status;
        $this->responce['messeng'] = $messeng;
        return response()->json($this->responce, $status);
    }
    public function send($messeng, $mobail)
    {
        $data = array(
            'api_token' => 'Jj3kcPzoMxIWvHNY57doKQOLKsmB7Bgc85SOeCtp',
            'senderid' => '8801969908427',
            'message' => "$messeng",
            'contact_number' => "$mobail",
        );
        $url = "http://api.smsinbd.com/sms-api/sendsms";
        //request
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
    public function smssend(Request $request){
        $mobail = $request->input("mobail");
        $code   = $request->input("messeng");
        return $this->send($code,$mobail);
    }
}
