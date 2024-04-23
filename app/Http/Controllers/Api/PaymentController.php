<?php

namespace App\Http\Controllers\Api;


use App\Models\Payment;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
   
    public function manualPayment(Request $request) {


     

        $validator = Validator::make($request->all() , [
            'payment_method' => 'required',
 		'mobile_no' => 'required',
		'transaction_no' => 'required',
		'amount' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => false , 'message' => $validator->errors()->first()]);
            exit;
        }
       
      $payment= Payment::where('transaction_no',$request->transaction_no)->first(); 
       
        if($payment) {
            
            return response()->json(['status' => false , 'message' => 'Transaction No Already Taken']);
            exit;
        }else{
            Payment::create([
	'payment_method' =>$request->payment_method,
 		'mobile_no' =>$request->mobile_no,
		'transaction_no' =>$request->transaction_no,
		'amount' =>$request->amount,
		'status'=>0,
	]);
     
        $response = [
            'success' => true,
            'message' => 'Payment successfully Submited & wait for approval',
        ];
        return response()->json($response, 200);
        }
	
	
        
    }
    
    
   
}
