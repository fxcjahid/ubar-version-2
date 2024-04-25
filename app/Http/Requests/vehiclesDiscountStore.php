<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class vehiclesDiscountStore extends FormRequest
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
            'name'            => 'required|max:15',
            'vehicle_type'    => 'required',
            'vehicle_number'  => 'numeric',
            'discount_code'   => 'required|unique:vehicles_discounts,discount_code',
            'discount_type'   => 'required|in:fixed,percent',
            'discount_amount' => 'required|numeric',
            'start_at'        => 'required',
            'expired_at'      => 'required',
            'status'          => 'required',
        ];
    }
}