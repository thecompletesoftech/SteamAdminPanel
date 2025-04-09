<div class="card-body">



    <div class="row mb-6">

        <label class="col-lg-2 col-form-label required fw-bold fs-6">Location</label>
        <div class="col-lg-4 fv-row">
            <select class="form-control form-control-solid" name="address">
                <option>--Select location--</option>
                @foreach ($location as $data)
                    <option value="{{ $data->location_id }}"
                        {{ $user->address == $data->location_id ? 'selected' : '' }}>{{ $data->location }}</option>
                @endforeach
            </select>
        </div>


        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.manager', 1) }}</label>
        <div class="col-lg-4 fv-row">
            {{-- {!! Form::text('manager', null, ['min' => 2, 'max' => 6, 'value' => 2, 'class' => 'form-control form-control-lg form-control-solid', 'placeholder' => trans_choice('content.managers', 1)]) !!} --}}
            <select class="form-control form-control-solid" name="manager_id">
                <option>--Select Manager--</option>
                @foreach ($manager as $data)
                    <option value="{{ $data->id }}" {{ $user->manager_id == $data->id ? 'selected' : '' }}>
                        {{ $data->name }}</option>
                @endforeach
            </select>
        </div>



    </div>

    <div class="row mb-6">

        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.name', 1) }}</label>
        <div class="col-lg-4 fv-row">
            {!! Form::text('name', null, [
                'min' => 2,
                'max' => 6,
                'value' => 2,
                'class' => 'form-control form-control-lg form-control-solid',
                'placeholder' => trans_choice('content.registration_name', 1),
            ]) !!}
        </div>

        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.phone', 1) }}</label>
        <div class="col-lg-4 fv-row">
            {!! Form::number('phone', null, [
                'min' => 2,
                'max' => 6,
                'value' => 2,
                'class' => 'form-control form-control-lg form-control-solid',
                'placeholder' => trans_choice('content.registration_number', 1),
            ]) !!}
        </div>




    </div>

    <div class="row mb-6">



        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.email', 1) }}</label>
        <div class="col-lg-4 fv-row">
            {!! Form::text('email', null, [
                'min' => 2,
                'max' => 6,
                'value' => 2,
                'class' => 'form-control form-control-lg form-control-solid',
                'placeholder' => trans_choice('content.registration_email', 1),
            ]) !!}
        </div>

        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('username', 1) }}</label>
        <div class="col-lg-4 fv-row">
            <input type="text" class="form-control form-control-lg form-control-solid" value="{{ $user->username }}"
                readonly placeholder="Engineer">
        </div>

    </div>

    <div class="row mb-6">

        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.password', 1) }}</label>
        <div class="col-lg-4 fv-row">
            <div class="input-group">
                <input type="password" id="password" name="password"  value="{{ $user->password }}"
                    class="form-control form-control-lg form-control-solid" placeholder="Password">
                <div class="input-group-append">
                    <span class="input-group-text" style="display:flex;align-items:center;">
                        <i class="fa fa-eye-slash pt-2" id="togglePassword" style="cursor: pointer; height:2rem;"></i>
                    </span>
                </div>
            </div>
        </div>

        <label
            class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.c_password', 1) }}</label>
        <div class="col-lg-4 fv-row">
            <div class="input-group">
                <input type="password" id="c_password" name="c_password" value="{{ $user->password }}"
                    class="form-control form-control-lg form-control-solid" placeholder="confirm password">
                <div class="input-group-append">
                    <span class="input-group-text" style="display:flex;align-items:center;">
                        <i class="fa fa-eye-slash pt-2" id="togglePassword1" style="cursor: pointer; height:2rem;"></i>
                    </span>
                </div>
            </div>
        </div>

    </div>

    <div class="row mb-6">


        <label class="col-lg-2 col-form-label fw-bold fs-6">{{ trans_choice('content.about', 1) }}</label>

        <div class="col-lg-4 fv-row">
            {!! Form::text('about', null, [
                'min' => 2,
                'max' => 6,
                'value' => 2,
                'class' => 'form-control form-control-lg form-control-solid',
                'placeholder' => trans_choice('content.registration_about', 1),
            ]) !!}
        </div>


    </div>

    <div class="row mb-6">

        <label class="col-lg-2 col-form-label fw-bold fs-6">{{ trans_choice('content.image', 1) }}</label>
        <div class="col-lg-4 fv-row">
            <input type="file" name="image" class="form-control form-control-lg form-control-solid">
            @if ($user->image)
                <img src="{{ url('/') }}/uploads/{{ $user->image }}" style="width:50px; height:50px;" />
                {{-- @else --}}
                {{-- <input type="file" name="image" class="form-control form-control-lg form-control-solid"> --}}
            @endif
        </div>




        <label class="col-lg-2 col-form-label required fw-bold fs-6">{{ trans_choice('content.role', 1) }}</label>

        <div class="col-lg-4 fv-row">


            <select class="form-control form-control-solid" name="role">
                <option value="2">Engineer</option>
            </select>
        </div>



    </div>


</div>
<!--end::Card body-->

@push('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const passwordField = document.querySelector("#password");
            const passwordField1 = document.querySelector("#c_password");

            const togglePassword = document.querySelector("#togglePassword");
            const togglePassword1 = document.querySelector("#togglePassword1");

            togglePassword.addEventListener("click", function() {
                const type = passwordField.getAttribute("type") === "password" ? "text" : "password";

                passwordField.setAttribute("type", type);

                // Toggle the eye icon
                if (type === "password") {
                    togglePassword.classList.remove("fa-eye");
                    togglePassword.classList.add("fa-eye-slash");
                } else {
                    togglePassword.classList.remove("fa-eye-slash");
                    togglePassword.classList.add("fa-eye");
                }



            });

            togglePassword1.addEventListener("click", function() {

                const type = passwordField1.getAttribute("type") === "password" ? "text" : "password";
                passwordField1.setAttribute("type", type);

                // Toggle the eye icon
                if (type === "password") {
                    togglePassword1.classList.remove("fa-eye");
                    togglePassword1.classList.add("fa-eye-slash");
                } else {
                    togglePassword1.classList.remove("fa-eye-slash");
                    togglePassword1.classList.add("fa-eye");
                }
            });

        });
    </script>


    {!! JsValidator::formRequest('App\Http\Requests\Admin\EmployeesEditRequest', 'form') !!}
@endpush
