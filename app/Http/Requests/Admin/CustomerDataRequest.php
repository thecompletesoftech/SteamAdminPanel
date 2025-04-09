<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CustomerDataRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (!request()->is('admin/customerdatas/create')) {
            return [
                'customer_name' => 'required',
                'flow' => 'required',
                'pressure' => 'required',
                'temprature' => 'required',
                'totalizer' => 'required',
                'Last_reading_time' => 'required',

            ];
        } else {
            return [
                'customer_name' => 'required',
                'flow' => 'required',
                'pressure' => 'required',
                'temprature' => 'required',
                'totalizer' => 'required',
                'Last_reading_time' => 'required',

            ];
        }
    }

    public function messages()
    {
        return [
            'customer_name.required' => __('validation.required', ['attribute' => 'customer name']),
            'flow.required' => __('validation.required', ['attribute' => 'flow']),
            'pressure.required' => __('validation.required', ['attribute' => 'pressure']),
            'temprature.required' => __('validation.required', ['attribute' => 'temprature']),
            'totalizer.required' => __('validation.required', ['attribute' => 'totalizer']),
            'Last_reading_time.required' => __('validation.required', ['attribute' => 'last reading time']),
        ];
    }

}
