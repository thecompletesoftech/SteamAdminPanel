<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeFeedbackRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (!request()->is('admin/employeefeedbacks/create')) {
            return [

                'pictures' => 'required',
                'remark' => 'required',

            ];
        } else {
            return [

                'pictures' => 'required',
                'remark' => 'required',

            ];
        }
    }

    public function messages()
    {
        return [
            'pictures.required' => __('validation.required', ['attribute' => 'pictures']),
            'remark.required' => __('validation.required', ['attribute' => 'remark']),
        ];
    }

}
