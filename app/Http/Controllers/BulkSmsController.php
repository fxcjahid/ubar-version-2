<?php

/**
 * Summary of namespace App\Http\Controllers
 * @author Fxc Jahid <fxcjahid3@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\SendBulkSMSJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\sendBulkSMSRequest;

class BulkSmsController extends Controller
{
    public $postUrl;
    public $apiToken;
    public $senderId;

    public function __construct()
    {
        $this->postUrl  = env('SMS_END_POINT');
        $this->apiToken = env('SMS_API_KEY');
        $this->senderId = env('SMS_SENDER_ID');
    }

    public function index()
    {
        $balance = self::checkingBalance();

        return view('admin.bulkSms.index', compact('balance'));
    }

    /**
     * Sends bulk SMS based on the selected method.
     *
     * @param \App\Http\Requests\sendBulkSMSRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(sendBulkSMSRequest $request)
    {
        if ($request->has('sendmethod')) {
            switch ($request->sendmethod) {
                case 'single':
                    $this->sendSingleSMS($request);
                    break;
                case 'allUser':
                    $this->sendBulkSMSByUserType('user', $request);
                    break;
                case 'allDriver':
                    $this->sendBulkSMSByUserType('driver', $request);
                    break;
                case 'bothSender':
                    $this->sendBulkSMSByUserType('both', $request);
                    break;
                default:
                    // Handle unknown send method
                    break;
            }
        }

        return redirect()->back()->with([
            'message' => 'Send SMS was successfully.',
        ]);
    }

    /**
     * Sends a single SMS message.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function sendSingleSMS(Request $request)
    {
        SendBulkSMSJob::dispatch($request->number, $request->message)->onQueue('high');
    }

    /**
     * Sends bulk SMS messages based on user type (user/driver/both).
     *
     * @param string $userType
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function sendBulkSMSByUserType($userType, Request $request)
    {
        if ($userType === 'both') {
            $users = User::whereIn('user_type', ['USER', 'DRIVER'])->whereNotNull('phone')->get();
        } else {
            $users = User::where('user_type', '=', $userType)->whereNotNull('phone')->get();
        }

        foreach ($users as $user) {
            SendBulkSMSJob::dispatch($user->phone, $request->message)->onQueue('default');
        }
    }

    /**
     * Sends bulk SMS message.
     *
     * @param int $number
     * @param string $message
     * @return array
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
        return $response->json();
    }

    /**
     * Checking SMS Balance   
     */
    public function checkingBalance()
    {
        $postData = [
            'api_token' => $this->apiToken,
        ];

        $response = Http::post('http://api.smsinbd.com/sms-api/balance', $postData);

        return $response['nonmask'];
    }
}