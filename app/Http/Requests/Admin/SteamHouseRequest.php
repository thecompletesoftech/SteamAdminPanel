<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SteamHouseRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (!request()->is('admin/steamhouses/create')) {
            return [
                'pressure' => 'required',
                'temprature' => 'required',
                'flow' => 'required',
                'totalizer' => 'required',
            ];
        } else {
            return [
                'pressure' => 'required',
                'temprature' => 'required',
                'flow' => 'required',
                'totalizer' => 'required',
            ];
        }
    }

    public function messages()
    {
        return [
            'pressure.required' => __('validation.required', ['attribute' => 'pressure']),
            'temprature.required' => __('validation.required', ['attribute' => 'temprature']),
            'flow.required' => __('validation.required', ['attribute' => 'flow']),
            'totalizer.required' => __('validation.required', ['attribute' => 'totalizer']),
        ];
    }

}
