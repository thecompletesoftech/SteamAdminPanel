
<!--begin::Card body-->
<div class="card-body">

    <!--begin::Input group-->

    {{-- <div class="row mb-6">

        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.assign_manager', 1) }}</label>
        <div class="col-lg-4 fv-row">
            <select  name="manager_id" class="form-control form-control-lg form-control-solid classic" style="margin-top: 5px;">
                <option>{{ trans_choice('content.assign_manager', 1) }}</option>
                            @foreach($manager as $data)
                            <option   value="{{ $data->id }}">{{ $data->name}}</option>
                            @endforeach
            </select>
        </div>

        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.location', 1) }}</label>
        <div class="col-lg-4 fv-row">
            <select  name="location_id" class="form-control form-control-lg form-control-solid classic" style="margin-top: 5px;">
                <option>{{ trans_choice('content.location', 1) }}</option>
                            @foreach($location as $data)
                            <option   value="{{ $data->location_id }}">{{ $data->location}}</option>
                            @endforeach
            </select>
        </div>

    </div> --}}

    <div class="row mb-6">

        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.manager', 1) }}</label>
        <div class="col-lg-4 fv-row">
                {{-- {!! Form::text('manager', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.managers', 1)]) !!} --}}
                <select class="form-control form-control-solid" name="manager">
                    <option >--select--</option>
                    @foreach($manager as $data)
                    <option value="{{$data->id}}">{{$data->name}}</option>
            @endforeach
                </select>
            </div>
            {{-- <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.location', 1) }}</label> --}}
        {{-- <div class="col-lg-4 fv-row">
                {!! Form::text('manager', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.managers', 1)]) !!}
                <select class="form-control form-control-solid" name="location">
                    <option >--select--</option>
                    @foreach($location as $data)
                    <option value="{{$data->id}}">{{$data->location}}</option>
            @endforeach
                </select>
            </div> --}}




        {{-- <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.location', 1) }}</label>
        <div class="col-lg-4 fv-row">
                {!! Form::text('location', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.location', 1)]) !!}
        </div>
    </div> --}}

    <div class="row mb-6">

        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.emp_img', 1) }}</label>
        <div class="col-lg-4 fv-row">
                {!! Form::file('emp_img', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.emp_img', 1)]) !!}
        </div>
        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.emo_name', 1) }}</label>
        <div class="col-lg-4 fv-row">
                {!! Form::text('emo_name', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.emo_names', 1)]) !!}
        </div>
    </div>

    <div class="row mb-6">
        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.emo_expert', 1) }}</label>

        <div class="col-lg-4 fv-row">
                {!! Form::text('emo_expert', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.emo_experts', 1)]) !!}
        </div>

        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.emo_contact', 1) }}</label>
        <div class="col-lg-4 fv-row">
                {!! Form::text('emo_contact', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.emo_contacts', 1)]) !!}
        </div>

    </div>




    <!--end::Input group-->

</div>
<!--end::Card body-->

@push('scripts')

    <script>

    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link   href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
        $(function(){
            $('.datetimepicker').datetimepicker();
        });
    </script>

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\Admin\EmployeesRequest', 'form') !!}

@endpush
