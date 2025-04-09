<!--begin::Card body-->
<div class="card-body">

    <!--begin::Input group-->

    <div class="row mb-6">



        <label class="col-lg-2 col-form-label required fw-bold fs-6">Location</label>
        <div class="col-lg-4 fv-row">
                {{-- {!! Form::text('manager', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.managers', 1)]) !!} --}}
                <select class="form-control form-control-solid" name="address">
                    <option value="">--Select Location--</option>

                    @foreach($location as $data)
                    <option value="{{$data->location_id}}">{{$data->location}}</option>

                    @endforeach
                </select>
            </div>

            <label class="col-lg-2 col-form-label required fw-bold fs-6">Company</label>
            <div class="col-lg-4 fv-row">
                    {{-- {!! Form::text('manager', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.managers', 1)]) !!} --}}
                    <select class="form-control form-control-solid" name="user_id">
                        <option value="">--Select Company--</option>
                        @foreach($company as $data)
                        <option value="{{$data->id}}">{{$data->name}}</option>
                        @endforeach
                    </select>
                </div>
    </div>

    <div class="row mb-6">
        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.manager_id', 1) }}</label>
        <div class="col-lg-4 fv-row">
                {{-- {!! Form::text('manager', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.managers', 1)]) !!} --}}

                <select name="manger_id"
                                class="form-control form-control-solid">
                                <option value="">--Select Manager--</option>
                                @foreach($manager as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                                @endforeach
                            </select>
            </div>


    </div>

    <div class="row mb-6">
        {{-- <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.emp_id', 1) }}</label>
            <div class="col-lg-4 fv-row">
                    <select class="form-control form-control-solid" name="emp_id">
                        <option >--Select Employee--</option>
                        @foreach($employee as $data)
                        <option value="{{$data->id}}">{{$data->name}}</option>
                        @endforeach
                    </select>
                </div> --}}

        {{-- <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.emp_id', 1) }}</label>
        <div class="col-lg-4 fv-row">
                {!! Form::text('emp_id', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.emp_id', 1)]) !!}
        </div> --}}
        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.Service_request', 1) }}</label>
        <div class="col-lg-4 fv-row">
                {!! Form::text('Service_request', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.Service_request', 1)]) !!}
        </div>
        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.pictures', 1) }}</label>
        <div class="col-lg-4 fv-row">
            <input type="file" name="pictures" class="form-control form-control-lg form-control-solid">
        </div>
    </div>

    <div class="row mb-6">




        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.phone', 1) }}</label>

        <div class="col-lg-4 fv-row">
                {!! Form::number('phone', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.phone', 1)]) !!}
        </div>
        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.discription', 1) }}</label>

        <div class="col-lg-4 fv-row">
                {!! Form::text('discription', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.discriptions', 1)]) !!}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
        $(function(){
            $('.datetimepicker').datetimepicker();
        });
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript">
            $("document").ready(function () {

                $('select[name="address"]').on('change', function () {
                    var catId = $(this).val();

                    if (catId) {
                        $.ajax({
                            url: '/admin/managerregistrations/locationdata/' + catId,
                            type: "GET",
                            // url: '{{url('/admin/managerregistrations/locationdata?cat_id=')}}/' + catId,
                            dataType: "json",
                            alert("Data");
                            success: function (data) {

                                $('select[name="manger_id"]').empty();
                                $.each(data, function (key, value) {
                                    $('select[name="manger_id"]').append('<option value=" ' + key + '">' + value + '</option>');
                                })
                            }

                        })
                    } else {
                        $('select[name="manger_id"]').empty();
                    }
                });


            });
        </script>





    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\Admin\ServiceRequest', 'form') !!}

@endpush
