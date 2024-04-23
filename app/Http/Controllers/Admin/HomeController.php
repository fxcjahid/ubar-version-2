<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;

class HomeController extends Controller
{
    public function profile() {
        $user = auth()->user();
        return view('admin.profile',compact('user'));
    }

    public function profileUpdate(Request $request) {

        $user = User::findOrFail(auth()->user()->id);
        $rules = [];
        if($user->phone != $request->phone) {
            $rules['phone'] = 'required|unique:users,phone';
        }
        $rules = [
            'first_name'    => 'required',
            'last_name'     => 'required'
        ];
        $validator = Validator::make($request->all() , $rules);

        if($validator->fails()) {
            return response()->json(['status' => false , 'message' => $validator->errors()->first()]);
            exit;
        }
        else {
            // Profile Image
            if ($request->file('profile_image')) {
                $fileName = '/assets/profile/' . uniqid(time()) . '.' . $request->file('profile_image')->extension();
                $request->file('profile_image')->move(public_path('assets/profile/'), $fileName);
                $profile = $fileName;
            }else{
                $profile = $request->old_profile_image;
            }

            if($request->password && $request->password != $request->password_confirmation){
                return response()->json(['status' => false , 'message' => 'Confirm Password Doesnt Match']);
                exit;
            }


            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone = $request->phone;
            $user->profile_pic = $profile;

            if($request->password){
                $user->password = Hash::make($request->password);
            }


            if($user->save()) {
                return response()->json(['status' =>true , 'message' => 'Profile Update successfully']);
                exit;
            }else{
                return response()->json(['status' =>false , 'message' => 'Something went wrong try again later!!']);
                exit;
            }
        }

    }

    public function admin_email_send()
    {
        return view('admin.email_template.email');
    }

    public function email_test(Request $request)
    {
        try {
            $data['subject'] = $request->subject;
            $data['message'] = $request->message;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            Mail::send('admin.email_template.test_email', compact('data'), function ($message) use ($data) {
                $message->to($data["email"])
                    ->subject($data['subject']);
            });

            return redirect()->back()->with(['success', 'Email Send Successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error', $e->getMessage()]);
        }
    }
}
