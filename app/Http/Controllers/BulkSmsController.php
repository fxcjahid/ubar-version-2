<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\sendBulkSMSRequest;

class BulkSmsController extends Controller
{
    public $postUrl = "http://api.smsinbd.com/sms-api/sendsms";
    public $apiToken = 'Jj3kcPzoMxIWvHNY57doKQOLKsmB7Bgc85SOeCtp';
    public $senderId = '8801969908427';

    public function index()
    {
        return view('admin.bulkSms.index');
    }

    /**
     * Summary of send
     * @param \App\Http\Requests\sendBulkSMSRequest $request
     * @return mixed
     */
    public function send(sendBulkSMSRequest $request)
    {
        return redirect()->back()->with(
            self::sendBulkSMS($request->number, $request->message,
            ));
    }

    /**
     * Summary of sendBulkSMS
     * @param int $number
     * @param string $message
     * @return mixed
     */
    public function sendBulkSMS(int $number, string $message)
    {
        if (is_null($number) || is_null($message)) {
            return response()->json(['error' => 'Number and message are required.'], 400);
        }

        $postData = [
            'api_token'      => $this->apiToken,
            'senderid'       => $this->senderId,
            'contact_number' => $number,
            'message'        => $message,
        ];

        // Send HTTP POST request using Laravel's HTTP client
        $response = Http::post($this->postUrl, $postData);

        // Decode the JSON response
        $array = $response->json();

        return $array;
    }

}