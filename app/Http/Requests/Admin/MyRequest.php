<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MyRequest extends FormRequest
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

        if (!request()->is('admin/users/create')) {
            return [
                //  'meter_id' => 'required|unique:users,meter_id',
                'username' => 'unique:users,username',


            ];
        } else {
            return [
                //  'meter_id' => 'required|unique:users,meter_id',
                'username' => 'unique:users,username',
            ];

        }
    }

    public function messages()
    {
        return [
            // 'meater_id.required' => __('validation.required', ['attribute' => 'Manager Id']),
            'name.required' => __('validation.required', ['attribute' => 'Name']),
            'email.required' => __('validation.required', ['attribute' => 'Email']),
            'email.email' => __('validation.email', ['attribute' => 'Email']),
            'email.unique' => __('validation.unique', ['attribute' => 'Email']),
            'username.required' => __('validation.required', ['attribute' => 'Username']),
            'username.unique' => __('validation.unique', ['attribute' => 'Username']),
        ];

    }
}
