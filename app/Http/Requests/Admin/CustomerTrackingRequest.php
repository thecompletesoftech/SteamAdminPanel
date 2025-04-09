<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CustomerTrackingRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (!request()->is('admin/customertrackings/create')) {
            return [
                'service_generated' => 'required',
                'Pending_assignment' => 'required',
                'assign_engineer' => 'required',
                'engineer_checkin' => 'required',
                'service_process' => 'required',
                'solve_by_engineer' => 'required',
                'service_closed' => 'required',

            ];
        } else {
            return [
                'service_generated' => 'required',
                'Pending_assignment' => 'required',
                'assign_engineer' => 'required',
                'engineer_checkin' => 'required',
                'service_process' => 'required',
                'solve_by_engineer' => 'required',
                'service_closed' => 'required',

            ];
        }
    }

    public function messages()
    {
        return [
            'service_generated.required' => __('validation.required', ['attribute' => 'Generate']),
            'Pending_assignment.required' => __('validation.required', ['attribute' => 'Assignment']),
            'assign_engineer.required' => __('validation.required', ['attribute' => 'Engineer']),
            'engineer_checkin.required' => __('validation.required', ['attribute' => 'Checking ']),
            'service_process.required' => __('validation.required', ['attribute' => 'Processing']),
            'solve_by_engineer.required' => __('validation.required', ['attribute' => 'Slove']),
            'service_closed.required' => __('validation.required', ['attribute' => 'Close']),
        ];
    }

}
