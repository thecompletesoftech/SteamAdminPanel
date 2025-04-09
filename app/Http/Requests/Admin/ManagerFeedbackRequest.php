<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ManagerFeedbackRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (!request()->is('admin/managerfeedbacks/create')) {
            return [

                'discription' => 'required',

            ];
        } else {
            return [

                'discription' => 'required',

            ];
        }
    }

    public function messages()
    {
        return [
            'discription.required' => __('validation.required', ['attribute' => 'discription']),
        ];
    }

}
