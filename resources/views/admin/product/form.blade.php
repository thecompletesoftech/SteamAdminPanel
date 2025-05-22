<!--begin::Card body-->
<div class="card-body">

    <!--begin::Input group-->

    <div class="row mb-6">

    
        <label class="col-lg-2 col-form-label required fw-bold fs-6">Select-Category</label>

        <div class="col-lg-4 fv-row mb-2">

            <select class="form-control" name="product_category">

                <option value=''>Select Item</option>
               
                @foreach ($Category as $item)
                <option value="{{ $item->id }}"> {{ $item->cat_name }} </option>
                @endforeach
            </select>
            <!-- {!! Form::text('service_name', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.location', 1)]) !!} -->
        </div>

        <label class="col-lg-2 col-form-label required fw-bold fs-6">Product Name</label>

        <div class="col-lg-4 fv-row">
                {!! Form::text('product_name', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => 'Product name']) !!}
        </div>

        <label class="col-lg-2 col-form-label mt-2 required fw-bold fs-6">{{ trans_choice('content.pictures', 1) }}</label>
        <div class="col-lg-4 fv-row">
                {!! Form::file('pictures', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => ' mt-2 form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.pictures', 1)]) !!}
        </div>

        <label class="col-lg-2 col-form-label required fw-bold fs-6">Product price</label>

        <div class="col-lg-4 fv-row">
                {!! Form::text('product_price', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'mt-2 form-control form-control-lg form-control-solid', 'placeholder' => 'Product price']) !!}
        </div>

        <label class="col-lg-2 col-form-label required fw-bold fs-6">Product specification</label>

        <div class="col-lg-4 fv-row">
                {!! Form::text('product_specification', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'mt-2 form-control form-control-lg form-control-solid', 'placeholder' => 'Product specification']) !!}
        </div>

        <label class="col-lg-2 col-form-label required fw-bold fs-6">Product in-stock Qty</label>

        <div class="col-lg-4 fv-row">
                {!! Form::text('product_stock', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'mt-2 form-control form-control-lg form-control-solid', 'placeholder' => 'Product in-stock Qty']) !!}
        </div>

            <label class="col-lg-3 col-form-label required fw-bold fs-5">Status</label>

        <div class="col-lg-3 fv-row">
        <label class="col-form-label  fs-5">Publish</label> {!!Form::radio('product_status', '0', [ 'class' => 'form-control form-control-lg form-control-solid'])!!}
        &nbsp;&nbsp;&nbsp;<label class="col-form-label  fs-5">Draft</label>{!!Form::radio('product_status', '1', [ 'class' => 'form-control form-control-lg form-control-solid'])!!}
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
