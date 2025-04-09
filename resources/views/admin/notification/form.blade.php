
<div class="card-body">



    <div class="row mb-6">

        <label
            class="col-lg-2 col-form-label required fw-bold fs-6">Type</label>

        <div class="col-lg-4 fv-row">

            <select name="role" class="form-control form-control-lg form-control-solid">
            <option value="">Select</option>
            <option value="1">Manager</option>
            <option value="0">Company</option>
            <option value="2">Employee</option>
            </select>

        </div>



    </div>


<div class="row mb-6">

       <label
           class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.title_name', 1) }}</label>

       <div class="col-lg-4 fv-row">
       {!! Form::text('notification', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.title_name', 1)]) !!}

       </div>



   </div>






    <div class="row mb-6">

        <label
            class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.message_title', 1) }}</label>

        <div class="col-lg-4 fv-row">
        {!! Form::textarea('message', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.message_title', 1)]) !!}

        </div>



    </div>



</div>


@push('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\Admin\NotificationRequest', 'form') !!}
@endpush
