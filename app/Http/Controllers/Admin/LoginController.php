<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    //
    public function index() {
        return view('admin.login');
    }

    /**
     * @param  Request $request
     * @method use for use login
     */
    public function loginSubmit(Request $request) {
        $validator = Validator::make($request->all() , [
            'email' => [
                'required', 'email:rfc',
                function($attribute, $value, $fail) {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                   $fail($attribute . ' is invalid.');
                }
             }],
             'password' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => false , 'message' => $validator->errors()->first()]);
            exit;
        }else{
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json(['status' => true , 'message' => 'Welcome Back '.Auth::user()->first_name , 'location' => 'admin/dashboard']);
                exit;
            }else{
                return response()->json(['status' => false , 'message' => "Credentials Not Match!!"]);
                exit;
            }
        }
    }

    /**
     * @param Request $request
     * @method use for logout
     */
    public function logout() {
        $admin = Auth::user()->id;
        $input['updated_at'] = date('Y-m-d h:i:s');
        User::where('id', $admin)->update($input);
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}
