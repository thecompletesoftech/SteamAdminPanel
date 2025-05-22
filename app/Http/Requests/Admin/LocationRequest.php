<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
   
            return [
                'service_name' => 'required',
                'immidate'=>'required',
            ];
   
    }

    public function messages()
    {
        return [
            'service_name.required' => "Please Enter Services Name",
            'immidate.required' => "Is Immedate Service ? Select One Of Theam ",

        ];
    }

}
