<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ManagerEditRequest extends FormRequest
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
                'username' => 'required',
                'name' => 'required|max:150',
                'email' => 'required|email',
                'phone' => 'max:10|digits:10',
                // 'about' => 'required',
                'password' => 'required',
                'c_password' => 'same:password',
                // 'role' => 'required',



            ];

        } else {
            return [
                //  'meter_id' => 'required|unique:users,meter_id',
                'username' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'max:10|digits:10',
                // 'about' => 'required',
                'password' => 'required',
                'c_password' => 'same:password',
                // 'role' => 'required',
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
            // 'username.unique' => __('validation.unique', ['attribute' => 'Username']),
            'phone.required' => __('validation.required', ['attribute' => 'Phone']),
            'phone.phone' => __('validation.phone', ['attribute' => 'Phone']),
            'phone.unique' => __('validation.unique', ['attribute' => 'Phone']),
            'meter_id.required' => __('validation.required', ['attribute' => 'Manager Id']),
            'about.required' => __('validation.required', ['attribute' => 'About']),
            'phone.required' => __('validation.required', ['attribute' => 'phone']),
            'password.required' => __('validation.required', ['attribute' => 'password']),
            'c_password.required' => __('validation.required', ['attribute' => 'confirm password']),
            'role.required' => __('validation.required', ['attribute' => 'role']),
        ];
    }
}
