    @php
        function checkActiveSideBar(array $links)
        {
            foreach ($links as $link) {
                if (request()->is('*admin/' . $link . '*')) {
                    return true;
                }
            }
            return false;
        }
    @endphp

    <!--begin::Aside-->
    <div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
        data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
        data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
        data-kt-drawer-toggle="#kt_aside_mobile_toggle">
        <!--begin::Brand-->
        <div class="aside-logo flex-column-auto" id="kt_aside_logo">
            <!--begin::Logo-->
            <a href="javascript:void(0)" style="text-decoration: none;">
                <img alt="Logo" src="{{ asset('admin/dist/media/logos/steamlogo.png') }}" class="h-55px logo" />
                {{-- <span style="font-size:20px;color:white;font-weight:400px;">Steam House</span> --}}
            </a>
            <!--end::Logo-->
            <!--begin::Aside toggler-->
            <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
                data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                data-kt-toggle-name="aside-minimize">
                <!--begin::Svg Icon | path: icons/duotone/Navigation/Angle-double-left.svg-->
                <span class="svg-icon svg-icon-1 rotate-180">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path
                                d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                                fill="#000000" fill-rule="nonzero"
                                transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                            <path
                                d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                                fill="#000000" fill-rule="nonzero" opacity="0.5"
                                transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
                        </g>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
            <!--end::Aside toggler-->
        </div>
        <!--end::Brand-->
        <!--begin::Aside menu-->
        <div class="aside-menu flex-column-fluid">
            <!--begin::Aside Menu-->
            <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
                data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
                data-kt-scroll-offset="0">
                <!--begin::Menu-->
                <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                    id="#kt_aside_menu" data-kt-menu="true">
                    <div class="menu-item">
                        <div class="menu-content pb-2">
                            <span
                                class="menu-section text-muted text-uppercase fs-8 ls-1">{{ trans_choice('content.sidebar.dashboard', 1) }}</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ checkActiveSideBar(['dashboard']) ? 'menu-item active' : '' }}"
                            href="{{ route('admin.dashboard') }} ">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <path
                                            d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                            fill="#000000" opacity="0.3" />
                                        <path
                                            d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                            fill="#000000" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">{{ trans_choice('content.sidebar.dashboard', 1) }}</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-2">
                            <span
                                class="menu-section text-muted text-uppercase fs-8 ls-1">{{ trans_choice('content.sidebar.menu', 2) }}</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ checkActiveSideBar(['category']) ? 'menu-item active' : '' }}"
                            href="{{ route('admin.category.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fa fa-key " style="color:white;font-size:15px;"></i>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Product Category</span>
                        </a>
                    </div>
                    
                     <div class="menu-item">
                        <a class="menu-link {{ checkActiveSideBar(['fueltype']) ? 'menu-item active' : '' }}"
                            href="{{ route('admin.fueltype.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fa fa-key " style="color:white;font-size:15px;"></i>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Vehicle Fuel Types</span>
                        </a>
                    </div>

                     <div class="menu-item">
                        <a class="menu-link {{ checkActiveSideBar(['vehicletype']) ? 'menu-item active' : '' }}"
                            href="{{ route('admin.vehicletype.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fa fa-key " style="color:white;font-size:15px;"></i>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Vehicle  Types</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ checkActiveSideBar(['VehicleDetails']) ? 'menu-item active' : '' }}"
                            href="{{ route('admin.vehicle.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fa fa-key " style="color:white;font-size:15px;"></i>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Vehicle Manufacturer</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ checkActiveSideBar(['vehiclebrand']) ? 'menu-item active' : '' }}"
                            href="{{ route('admin.vehiclebrand.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fa fa-key " style="color:white;font-size:15px;"></i>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Vehicle Brand</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ checkActiveSideBar(['product']) ? 'menu-item active' : '' }}"
                            href="{{ route('admin.product.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fa fa-key " style="color:white;font-size:15px;"></i>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Manage Product </span>
                        </a>
                    </div>



                    <div class="menu-item">
                        <a class="menu-link {{ checkActiveSideBar(['location']) ? 'menu-item active' : '' }}"
                            href="{{ route('admin.locations.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fa fa-location-arrow " style="color:white;font-size:15px;"></i>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Services</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ checkActiveSideBar(['location']) ? 'menu-item active' : '' }}"
                            href="{{ route('admin.subservices.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fa fa-key " style="color:white;font-size:15px;"></i>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Sub-Services</span>
                        </a>
                    </div>



                    <div class="menu-item">
                        <a class="menu-link {{ checkActiveSideBar(['managerregistration']) ? 'menu-item active' : '' }}"
                            href="{{ route('admin.managerregistrations.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fa fa-user" style="color:white;font-size:15px;"></i>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Manager</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ checkActiveSideBar(['company']) ? 'menu-item active' : '' }}"
                            href="{{ route('admin.companylists.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fa fa-list " style="color:white;font-size:15px;"></i>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Company</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ checkActiveSideBar(['employeeregistration']) ? 'menu-item active' : '' }}"
                            href="{{ route('admin.employeeregistrations.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fa fa-user-check" style="color:white;font-size:15px;"></i>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Engineer</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ checkActiveSideBar(['servicerequest']) ? 'menu-item active' : '' }}"
                            href="{{ route('admin.servicerequests.index') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="fa fa-eye" style="color:white;font-size:15px;"></i>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Service Request</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ checkActiveSideBar(['notifications']) ? 'menu-item active' : '' }}"
                            href="{{ route('admin.notifications.index') }}">
                            <span class="menu-icon">

                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-comment" style="color:white;font-size:15px;"></i>

                                </span>

                            </span>
                            <span class="menu-title">Notification</span>
                        </a>
                    </div>

                </div>
                <!--end::Menu-->
            </div>
            <!--end::Aside Menu-->
        </div>
        <!--end::Aside menu-->
    </div>
    <!--end::Aside-->
