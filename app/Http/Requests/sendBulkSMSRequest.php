<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class sendBulkSMSRequest extends FormRequest
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
            'sendmethod' => 'required|in:single,allUser,allDriver,bothSender',
            'number'     => 'nullable|min:10|numeric',
            'message'    => 'required|max:760|min:3',
        ];
    }
}