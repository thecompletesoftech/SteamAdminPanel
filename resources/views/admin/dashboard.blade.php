@extends('admin.layouts.base')
@section('content')
    @include('admin.layouts.components.header',[
    'title'=> __('header.dashboard'),
    'breadcrumbs'=> Breadcrumbs::render('admin.dashboard')
    ])

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <!--begin::Row-->
            <div class="row gy-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-12">
                    <!--begin::Mixed Widget 2-->
                    <div class="card">
                        <!--begin::Body-->
                        <div class="card-body p-0 ">
                            <!--begin::Stats-->
                            <div class="card-p mt-20 position-relative">
                                <!--begin::Row-->
                                <div class="row g-0" >
                                    <!--begin::Col-->
                                    <div class="col bg-light-primary px-6 py-8 rounded-2 me-7 mb-7">
                                        <!--begin::Svg Icon | path: icons/duotone/Communication/Add-user.svg-->
                                        <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2"  >
                                           <i class="fa fa-user" style="font-size: 25px;color:gray;"></i>


                                        </span>
                                        <!--end::Svg Icon-->
                                        <h4 class="text-dark fw-bold fs-6"  style="margin-top:10px;" ><span>{{getmanager()}}</span>
                                        </h4>

                                        <a href=" {{ route('admin.managerregistrations.index') }}"
                                            class="text-primary fw-bold fs-6">{{ trans_choice('content.dashboard_cards.manager', 1) }}</a>
                                    </div>
                                    <!--end::Col-->



                                    <!--begin::Col-->
                                    <div class="col bg-light-success px-6 py-8 rounded-2 me-7 mb-7">
                                        <!--begin::Svg Icon | path: icons/duotone/Media/Equalizer.svg-->
                                        <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2" >
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <path
                                                    d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"
                                                    fill="#000000" />
                                            </svg> --}}
                                            <i class="fa fa-building" style="font-size:25px;color:gray;"></i>

                                            <h4 class="text-dark fw-bold fs-6 "  style="margin-top:10px;"><span >{{getcompany()}}</span>
                                            </h4>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <a href=" {{ route('admin.companylists.index') }}"
                                            class="text-success fw-bold fs-6">{{ trans_choice('content.dashboard_cards.total_company', 1) }}</a>
                                    </div>
                                    <!--end::Col-->

                                    <!--begin::Col-->
                                    <div class="col bg-light-primary px-6 py-8 rounded-2 mb-7">
                                        <!--begin::Svg Icon | path: icons/duotone/Communication/Add-user.svg-->
                                        <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
                                         <i class="fa fa-users" style="font-size:25px;color:gray;"></i>
                                            <h4 class="text-dark fw-bold fs-6"  style="margin-top:10px;"><span >{{getEngineer()}}</span>
                                            </h4>
                                        </span>
                                        <!--end::Svg Icon-->

                                        <a href="{{ route('admin.employeeregistrations.index') }}"
                                            class="text-primary fw-bold fs-6">{{ trans_choice('content.dashboard_cards.total_engineer', 1) }}</a>
                                    </div>
                                    <!--end::Col-->

                                </div>

                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Mixed Widget 2-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Post-->
@endsection

@push('scripts')
    <script>
        function dashboard() {
            $.ajax({
                    url: `{{ route('admin.dashboard-counts') }}`,
                    type: "get",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                })
                .done(function(response) {
                    console.log(response);
                    $('.new_users').text(response.data.new_users);
                    $('.total_clients').text(response.data.total_clients);
                    $('.yearly_sales_count').text(response.data.yearly_sales_count);

                    $('.total_vendors').text(response.data.total_vendors);

                    $('.total_purchase').text(response.data.total_purchase);

                    $('.total_unpaid_bill').text(response.data.total_unpaid_bill);
                    $('.total_unrecieved_bill').text(response.data.total_unrecieved_bill);
                    $('.total_unrecieved_amount').text((response.data.total_unrecieved_amount).toLocaleString());

                    $('.total_dept_balance').text((response.data.total_dept_balance).toLocaleString());
                    $('.total_asset').text(response.data.total_asset);
                })
                .fail(function() {
                    Swal.fire('Oops...', 'Something went wrong with ajax !', 'error');
                });
        }
        dashboard();
    </script>
@endpush
