<!--begin::Card body-->
<div class="card-body">

    <!--begin::Input group-->

 <div class="row mb-6">

    
        
        <label class="col-lg-2 col-form-label required fw-bold fs-6">Select Vehicle Type</label>

        <div class="col-lg-4 fv-row">

            <select class="form-control" name="vehicle_type">

                <option value=''>Select Item</option>
               
                @foreach ($Category as $item)
                <option value="{{ $item->id }}" {{$location->vehicle_type== $item->id  ?'selected':''}} > {{ $item->vehicle_type }} </option>
                @endforeach
            </select>
            <!-- {!! Form::text('service_name', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.location', 1)]) !!} -->
        </div>


        <label class="col-lg-2 col-form-label required fw-bold fs-6">vehicle Name</label>

        <div class="col-lg-4 fv-row">
                {!! Form::text('vehicle_name', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => 'vehicle name']) !!}
        </div>

        <label class="col-lg-2 col-form-label mt-2 required fw-bold fs-6">{{ trans_choice('content.pictures', 1) }}</label>
        <div class="col-lg-4 fv-row">
                {!! Form::file('vehicle_image', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => ' mt-2 form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.pictures', 1)]) !!}
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
    

@endpush
