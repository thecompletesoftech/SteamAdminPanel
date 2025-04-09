<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (!request()->is('admin/reviews/create')) {
            return [
                'star' => 'required',
                'discription' => 'required',

            ];
        } else {
            return [
                'star' => 'required',
                'discription' => 'required',

            ];
        }
    }

    public function messages()
    {
        return [
            'star.required' => __('validation.required', ['attribute' => 'star']),
            'discription.required' => __('validation.required', ['attribute' => 'discription']),
        ];
    }

}
