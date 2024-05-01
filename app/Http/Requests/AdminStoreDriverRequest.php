<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminStoreDriverRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'         => 'required',
            'last_name'          => 'required',
            'phone'              => 'required|unique:users,phone',
            'email'              => 'required|unique:users,email',
            'gender'             => 'required',
            'password'           => 'required',
            'address'            => 'required',
            'experience_in_car'  => 'required',
            'experience_in_year' => 'required',
            'licence_number'     => 'required',
            'nid_number'         => 'required',
            'owner_name'         => 'required',
            'owner_bank_acc'     => 'required',
        ];
    }
}