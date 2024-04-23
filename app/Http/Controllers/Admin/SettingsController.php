<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function general_settings() {
        return view('admin.settings.general');
    }


    public function store(Request $request) {
        $request->validate([
            'logo' => 'mimes:jpeg,bmp,png,jpg|max:500',
			'favicon' => 'mimes:ico,jpeg,bmp,png,jpg|max:200',
        ]);

        $input = $request->all();
        $config_type = $request->config_type;
        $old_configs = Setting::all();

        $boolean_system_setting = config('system.boolean.'.$config_type);

        if($boolean_system_setting){
            foreach($boolean_system_setting as $v){
                $config = Setting::firstOrCreate(['name' => $v]);
                $config->value = 0;
                $config->save();
            }
        }



        foreach($_POST as $key => $value){
            if($key == "_token"){
                continue;
            }

            $data = array();
            $data['value'] = $value;

            $data['updated_at'] = Carbon::now();
            if(Setting::where('name', $key)->exists()){
                Setting::where('name','=',$key)->update($data);
            }else{
                $data['name'] = $key;
                $data['created_at'] = Carbon::now();

                Setting::insert($data);
            }
        }

        if($request->hasFile('logo')) {

            $fileName = '/assets/profile/' . uniqid(time()) . '.' . $request->file('logo')->extension();
            $request->file('logo')->move(public_path('assets/profile/'), $fileName);
            $profile = $fileName;

            $logo['name']='logo';
            $logo['value'] = $profile;
            

        } else {

            $logo['name']='logo';
            $logo['value'] = $request->get('oldLogo','');

        }

        if($request->hasFile('favicon')) {

            $fileName = '/assets/profile/' . uniqid(time()) . '.' . $request->file('favicon')->extension();
            $request->file('favicon')->move(public_path('assets/profile/'), $fileName);
            $profile1 = $fileName;

            $data1['name']='favicon';
            $data1['value'] = $profile1;

        } else {

            $data1['name']='favicon';
            $data1['value'] = $request->get('oldfavicon','');
            
        }


        if(Setting::where('name', "logo")->exists()){
            Setting::where('name','=',"logo")->update($logo);
        } else {
            $logo['created_at'] = Carbon::now();
            Setting::insert($logo);
        }

        if(Setting::where('name', "favicon")->exists()){
            Setting::where('name','=',"favicon")->update($data1);
        } else {
            $data1['created_at'] = Carbon::now();
            Setting::insert($data1);
        }

        return redirect()->route('admin.general.settings')->with('Configuration Updated');

    }

    // ModudelConfiguraion
    public function ModudelConfiguraion() {
        return view('admin.settings.module_settings');
    }
}
