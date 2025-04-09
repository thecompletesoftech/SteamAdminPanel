<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (!request()->is('admin/customerdatas/create')) {
            return [
                'Service_request' => 'required|max:150',
                // 'pictures' => 'required',
                'phone' => 'required|numeric|digits:10|starts_with:1,2,3,4,5,6,7,8,9',
                'user_id' => 'required',
                'address' => 'required',
                'manger_id'=>'required',

            ];
        } else {
            return [
                'Service_request' => 'required|max:150',
                // 'pictures' => 'required',
                'phone' => 'required|numeric|digits:10|starts_with:1,2,3,4,5,6,7,8,9',
                'user_id' => 'required',
                'address' => 'required',
                'manger_id'=>'required',

            ];
        }
    }

    public function messages()
    {
        return [
            'Service_request.required' => __('validation.required', ['attribute' => 'Request']),
            // 'pictures.required' => __('validation.required', ['attribute' => 'pictures']),
            'number.required' => __('validation.required', ['attribute' => 'number']),

            'user_id.required' => __('validation.required', ['attribute' => 'Company']),
            'address.required' => __('validation.required', ['attribute' => 'Location']),
            'manger_id.required' => __('validation.required', ['attribute' => 'Manager']),

        ];
    }

}
