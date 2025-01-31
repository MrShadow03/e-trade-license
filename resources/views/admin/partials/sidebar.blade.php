<div id="kt_app_sidebar" class="app-sidebar flex-column print-display-none" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="#" class="d-flex mt-3">
            <img alt="Logo" src="{{ asset('assets/img/default-dark.png') }}"
                class="h-40px app-sidebar-logo-default">
            <img alt="Logo" src="{{ asset('assets/img/Barisal_City_Corporation_logo_white.png') }}"
                class="h-30px app-sidebar-logo-minimize">
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <!--begin::Minimized sidebar setup:
        if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on") {
            1. "src/js/layout/sidebar.js" adds "sidebar_minimize_state" cookie value to save the sidebar minimize state.
            2. Set data-kt-app-sidebar-minimize="on" attribute for body tag.
            3. Set data-kt-toggle-state="active" attribute to the toggle element with "kt_app_sidebar_toggle" id.
            4. Add "active" class to to sidebar toggle element with "kt_app_sidebar_toggle" id.
        }-->
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate "
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">

            <i class="fal fa-chevrons-left fs-4 rotate-180"></i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->

    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
        data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link {{ request()->url() == route('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-home-2 fs-2"></i>
                        </span>
                        <span class="menu-title font-bn">
                            ড্যাশবোর্ড
                        </span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
                
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click"
                @class([
                    'menu-item',
                    'menu-accordion',
                    'here show' => request()->url() == route('admin.trade_license_applications') || (request()->url() == route('admin.trade_license_applications.amendments') && auth()->user()->can(   'approve-pending-amendment-approval-applications'))
                ])>
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-note-2 fs-2"></i>
                        </span>
                        <span class="menu-title font-bn">
                            <span>আবেদনসমূহ</span>
                            @if (auth()->user()->getPendingApplicationCount() + auth()->user()->getPendingAmendmentApplicationCount())
                            <span class="badge badge-danger font-kohinoor py-0 badge-circle w-15px h-15px ms-3 fw-normal">{{ Helpers::convertToBanglaDigits(auth()->user()->getPendingApplicationCount()) }}</span>
                            @endif
                        </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->url() == route('admin.trade_license_applications') ? 'active' : '' }}" href="{{ route('admin.trade_license_applications') }}">
                                <span class="menu-icon">
                                    <i class="far fa-sparkles fs-4"></i>
                                </span>
                                <span class="menu-title font-bn">
                                    <span>নতুন এবং নবায়ন</span>
                                    @if (auth()->user()->getPendingApplicationCount())
                                    <span class="badge badge-danger font-kohinoor py-0 badge-circle w-15px h-15px ms-3 fw-normal">{{ Helpers::convertToBanglaDigits(auth()->user()->getPendingApplicationCount()) }}</span>
                                    @endif
                                </span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->

                        @canany(['verify-amendment-fee-payment', 'deny-amendment-fee-payment', 'approve-pending-amendment-approval-applications'])
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->url() == route('admin.trade_license_applications.amendments') ? 'active' : '' }}" href="{{ route('admin.trade_license_applications.amendments') }}">
                                <span class="menu-icon">
                                    <i class="far fa-eraser fs-4"></i>
                                </span>
                                <span class="menu-title font-bn">সংশোধন</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                        @endcanany

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->url() == route('admin.trade_license_applications.all') ? 'active' : '' }}" href="{{ route('admin.trade_license_applications.all') }}">
                                <span class="menu-icon">
                                    <i class="far fa-sparkles fs-4"></i>
                                </span>
                                <span class="menu-title font-bn">
                                    <span>সকল আবেদন</span>
                                </span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7 font-bn">
                            ব্যবস্থাপনা
                        </span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->
                
                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link {{ request()->url() == route('admin.admins') ? 'active' : '' }}" href="{{ route('admin.admins') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-profile-user fs-2"></i>
                        </span>
                        <span class="menu-title font-bn">
                            এডমিনগণ
                        </span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
                
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->

    <!--begin::Footer-->
    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        <form action="{{ route('admin.logout') }}" onclick="this.submit()" method="POST"
            class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100"
            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click">
            @csrf
            <span class="btn-label font-bn">
                লগ আউট
            </span>
            <i class="far fa-sign-out-alt btn-icon fs-4 m-0"></i>
        </form>
    </div>
    <!--end::Footer-->
</div>
