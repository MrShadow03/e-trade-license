@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>Settings Overview | Admin</title>
@endsection
<!--end::Page Title-->

<!--begin::Page Custom Styles(used by this page)-->
@section('exclusive_styles')
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/admin/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assets/admin/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css">
    <!--end::Vendor Stylesheets-->
    <style>
        .image-input-placeholder {
            background-image: url('{{ asset("assets/admin/assets/media/svg/avatars/blank.svg") }}');
        }

        [data-bs-theme="dark"] .image-input-placeholder {
            background-image: url('{{ asset("assets/admin/assets/media/svg/avatars/blank-dark.svg") }}');
        }
        iframe {
            width: 100% !important;
            height: 400px !important;
        }

    </style>
@endsection
<!--end::Page Custom Styles-->

<!--begin::toolbar-->
@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">

        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">

            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Profile
                </h1>
                <!--end::Title-->

                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home </a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Profile</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar container-->
    </div>
@endsection
<!--end::toolbar-->

<!--begin::Main Content-->
@section('content')
<!--begin::Content container-->
<div id="kt_app_content_container" class="app-container  container-xxl ">

    <!--begin::Profile navbar-->
    @include('admin.pages.profile.partials.profile_navbar')
    <!--end::Profile navbar-->
    <!--begin::details View-->
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <!--begin::Card header-->
        <div class="card-header cursor-pointer">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Profile Details</h3>
            </div>
            <!--end::Card title-->

            <!--begin::Action-->
            <a href="{{ route('admin.profile.settings') }}" class="btn btn-sm btn-primary align-self-center" id="submit_button">
                <span class="indicator-label">
                    Edit Profile
                </span>
                <span class="indicator-progress">
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </a>
            <!--end::Action-->
        </div>
        <!--begin::Card header-->

        <!--begin::Card body-->
        <div class="card-body p-9">
            <!--begin::Row-->
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Organization Name</label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $details['name'] }}</span>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->

            <!--begin::Input group-->
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">
                    Phone Number

                    <span class="ms-1" data-bs-toggle="tooltip" title="Phone number must be active">
                        <i class="ki-duotone ki-information fs-7">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i> 
                    </span>
                </label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8 d-flex align-items-center">
                    <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $details['phone'] }}</span>
                    <span class="badge badge-success">Verified</span>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Email</label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8">
                    <a href="#" class="fw-semibold fs-6 text-gray-800 text-hover-primary">{{ $details['email'] }}</a>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">
                    Address

                    <span class="ms-1" data-bs-toggle="tooltip" title="Country of origination">
                        <i class="ki-duotone ki-information fs-7">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i> 
                    </span>
                </label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8">
                    <span class="fw-semibold fs-6 text-gray-800">{{ $details['address'] }}</span>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->

            <div class="separator my-10"></div>
            
            <!--begin::Input group-->
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">
                    CEO Profile
                    <span class="ms-1" data-bs-toggle="tooltip" title="Country of origination">
                        <i class="ki-duotone ki-information fs-7">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i> 
                    </span>
                </label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8 row">
                    <div class="symbol symbol-75px">
                        <div class="symbol-label" style="background-image:url('{{ asset('storage') . '/' . $details['CEO_image'] }}')"></div>
                    </div>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->
            
            <!--begin::Input group-->
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">
                </label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8 row">
                    <span class="fw-bold fs-6 text-gray-800">{{ $details['CEO_name'] }}</span>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">
                    CEO Message
                    <span class="ms-1" data-bs-toggle="tooltip" title="Country of origination">
                        <i class="ki-duotone ki-information fs-7">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i> 
                    </span>
                </label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8 row">
                    <span class="fs-6 text-gray-800">{{ $details['CEO_message'] }} lorem100</span>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="row mb-10">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Allow Changes</label>
                <!--begin::Label-->

                <!--begin::Label-->
                <div class="col-lg-8">
                    <span class="fw-semibold fs-6 text-gray-800">Yes</span>
                </div>
                <!--begin::Label-->
            </div>
            <!--end::Input group-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::details View-->
    <!--begin::Connected Accounts-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_connected_accounts" aria-expanded="true" aria-controls="kt_account_connected_accounts">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Connected Accounts</h3>
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Content-->
        <div id="kt_account_settings_connected_accounts" class="collapse show">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">

                <!--begin::Items-->
                <div class="py-2">
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <img src="{{ asset('assets/admin/assets/media/svg/brand-logos/facebook-4.svg') }}" class="w-30px me-6" alt="">

                            <div class="d-flex flex-column">
                                <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">Facebook</a>
                                <div class="fs-6 fw-semibold text-gray-400">{{ $details['facebook'] }}</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="form-check form-check-solid form-check-custom form-switch">
                                <input class="form-check-input w-45px h-30px" type="checkbox" id="googleswitch" checked="">
                                <label class="form-check-label" for="googleswitch"></label>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->

                    <div class="separator separator-dashed my-5"></div>
                    
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <img src="{{ asset('assets/admin/assets/media/svg/brand-logos/whatsapp.svg') }}" class="w-30px me-6" alt="">

                            <div class="d-flex flex-column">
                                <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">WhatsApp</a>
                                <div class="fs-6 fw-semibold text-gray-400">{{ $details['whatsapp'] }}</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="form-check form-check-solid form-check-custom form-switch">
                                <input class="form-check-input w-45px h-30px" type="checkbox" id="googleswitch" checked="">
                                <label class="form-check-label" for="googleswitch"></label>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->

                    <div class="separator separator-dashed my-5"></div>

                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <img src="{{ asset('assets/admin/assets/media/svg/brand-logos/twitter.svg') }}" class="w-30px me-6" alt="">

                            <div class="d-flex flex-column">
                                <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">Twitter</a>
                                <div class="fs-6 fw-semibold text-gray-400">{{ $details['twitter'] }}</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="form-check form-check-solid form-check-custom form-switch">
                                <input class="form-check-input w-45px h-30px" type="checkbox" id="githubswitch" checked="">
                                <label class="form-check-label" for="githubswitch"></label>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->

                    <div class="separator separator-dashed my-5"></div>

                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <img src="{{ asset('assets/admin/assets/media/svg/brand-logos/linkedin-2.svg') }}" class="w-30px me-6" alt="">

                            <div class="d-flex flex-column">
                                <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">Linkedin</a>
                                <div class="fs-6 fw-semibold text-gray-400">{{ $details['linkedin'] }}</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="form-check form-check-solid form-check-custom form-switch">
                                <input class="form-check-input w-45px h-30px" type="checkbox" id="slackswitch">
                                <label class="form-check-label" for="slackswitch"></label>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->

                    <div class="separator separator-dashed my-5"></div>
                    
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <img src="{{ asset('assets/admin/assets/media/svg/brand-logos/youtube-3.svg') }}" class="w-40px me-6" alt="">

                            <div class="d-flex flex-column">
                                <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">YouTube</a>
                                <div class="fs-6 fw-semibold text-gray-400">{{ $details['youtube'] }}</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="form-check form-check-solid form-check-custom form-switch">
                                <input class="form-check-input w-45px h-30px" type="checkbox" id="slackswitch">
                                <label class="form-check-label" for="slackswitch"></label>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Items-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Connected Accounts-->
    <!--begin::Map-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_connected_accounts" aria-expanded="true" aria-controls="kt_account_connected_accounts">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Map</h3>
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Content-->
        <div id="kt_account_settings_connected_accounts" class="collapse show">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">

                <!--begin::Items-->
                <div class="py-2 text-center">
                    {!! $details['map'] !!}
                </div>
                <!--end::Items-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Map-->
</div>
<!--end::Content container-->
@endsection
<!--end::Main Content-->
<!--begin::Page Vendors Javascript and custom JS-->
@section('exclusive_scripts')

    <script>
        var button = document.querySelector("#submit_button");

        // Handle button click event
        button.addEventListener("click", function() {
            // Activate indicator
            button.setAttribute("data-kt-indicator", "on");

            // Disable indicator after 3 seconds
            setTimeout(function() {
                button.removeAttribute("data-kt-indicator");
            }, 500);
        });
    </script>
@endsection
<!--end::Page Vendors Javascript and custom JS-->
