<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CompanyListRequest extends FormRequest
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

        if (!request()->is('admin/companylists/create')) {
            return [
                'meter_id' => 'required',
                'username' => 'required',
                'name' => 'required|max:150',
                'email' => 'required|email',
                'phone' => 'required|numeric|digits:10',
                'address'=>'required',
                'manager_id'=>'required',
                'password' => 'required',
                'c_address' => 'required',
                'c_password' => 'required_with:password|same:password',
                // 'role' => 'required',
            ];

        } else {
            return [
                'meter_id' => 'required',
                'username' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|numeric|digits:10',
                'address'=>'required',
                'manager_id'=>'required',
                'password' => 'required',
                'c_address' => 'required',
                'c_password' => 'required_with:password|same:password',
                'role' => 'required',
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
            'phone.required' => __('validation.required', ['attribute' => 'Phone']),
            'meter_id.required' => __('validation.required', ['attribute' => 'Meter ID']),
            'address.required' => __('validation.required', ['attribute' => 'Location']),
            'manager_id.required' => __('validation.required', ['attribute' => 'Manager']),
            'password.required' => __('validation.required', ['attribute' => 'password']),
            'address.required' => __('validation.required', ['attribute' => 'Address']),
            'c_password.required' => __('validation.required', ['attribute' => 'confirm password']),
            'role.required' => __('validation.required', ['attribute' => 'role']),
        ];
    }
}
