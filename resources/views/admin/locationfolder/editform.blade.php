<!--begin::Card body-->
<div class="card-body">

    <!--begin::Input group-->

    <div class="row mb-6">

        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.location', 1) }}</label>

        <div class="col-lg-4 fv-row">
                {!! Form::text('service_name', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.location', 1)]) !!}
        </div>

            <label class="col-lg-3 col-form-label required fw-bold fs-5">Is - Service Immidate ?</label>

        <div class="col-lg-3 fv-row">
        <label class="col-form-label  fs-5">Yes</label> {!!Form::radio('immidate', '0', [ 'class' => 'form-control form-control-lg form-control-solid'])!!}
        &nbsp;&nbsp;&nbsp;<label class="col-form-label  fs-5">No</label>{!!Form::radio('immidate', '1', [ 'class' => 'form-control form-control-lg form-control-solid'])!!}
                <!-- {!! Form::text('contact_no', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.contact', 1)]) !!} -->
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\LocationRequest', 'form') !!}

@endpush
