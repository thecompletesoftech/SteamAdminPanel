<!--begin::Card body-->
<div class="card-body">

    <!--begin::Input group-->

    <div class="row mb-8">

        <label class="col-lg-2 col-form-label required fw-bold fs-6">Select-Services</label>

        <div class="col-lg-4 fv-row">

            <select class="form-control" name="id">

                <option value=''>Select Item</option>

                @foreach ($data as $item)
                <option {{ $item->id==$sub_services->id ?'selected':'' }} value="{{ $item->id }}"> {{ $item->service_name }} </option>
                @endforeach
            </select>
            <!-- {!! Form::text('service_name', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.location', 1)]) !!} -->
        </div>

        <div class="row mb-8">
            <label class="col-lg-2 col-form-label required fw-bold fs-6">Sub -Services Title</label>


            <div class="col-lg-4 fv-row  ">
                <input value="{{ $sub_services->sub_service_name }}" class="form-control " placeholder="Sub-Services name" name="sub_service_name" type="text">


            </div>
        </div>

    </div>



    <!--end::Input group-->

</div>
<!--end::Card body-->

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
    function toggleSelect(show, id) {
        const select = document.getElementById("show" + id);
        show ? select.classList.remove("hidden") : select.classList.add("hidden");
    }
</script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

{!! JsValidator::formRequest('App\Http\Requests\Admin\LocationRequest', 'form') !!}


@endpush