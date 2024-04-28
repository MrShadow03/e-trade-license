@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>Advance Settings | Admin</title>
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
        tbody.hide-child {
            display: none;
        }

        .show-child {
            display: table-row-group !important;
        }
        .image-input-placeholder {
            background-image: url('{{ asset("assets/admin/assets/media/svg/avatars/blank.svg") }}');
        }

        [data-bs-theme="dark"] .image-input-placeholder {
            background-image: url('{{ asset("assets/admin/assets/media/svg/avatars/blank-dark.svg") }}');
        }

    </style>
@endsection
<!--end::Page Custom Styles-->

<!--begin::toolbar-->
@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6 ">

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

    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Advance Settings</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->

        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            <form class="form" action="{{ route('admin.profile.advance.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-8">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Product VAT</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <div class="input-group input-group-solid mb-5">
                                        <span class="input-group-text">%</span>
                                        <input type="number" class="form-control" name="product_VAT" placeholder="product VAT" aria-label="product VAT" value="{{ $details['product_VAT'] }}" 
                                        @hasrole('super_admin')
                                        @else
                                        readonly
                                        @endhasrole
                                        />
                                    </div>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-8">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Payment methods</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <div class="input-group input-group-solid mb-5">
                                        <div class="symbol symbol-30px input-group-text">
                                            <img src="{{ asset('assets/admin/assets/media/logos/bkash.png') }}" alt="bkash logo">
                                        </div>
                                        <input type="text" class="form-control" name="bkash_primary" placeholder="bKash Primary" aria-label="product VAT" value="{{ $payment_methods->where('name', 'bkash')->first()->primary_number }}"/>
                                    </div>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <div class="input-group input-group-solid mb-5">
                                        <div class="symbol symbol-30px input-group-text">
                                            <img src="{{ asset('assets/admin/assets/media/logos/bkash.png') }}" alt="bkash logo">
                                        </div>
                                        <input type="text" class="form-control" name="bkash_secondary" placeholder="bKash Secondary" aria-label="product VAT" value="{{ $payment_methods->where('name', 'bkash')->first()->secondary_number ?? '' }}"/>
                                    </div>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <div class="input-group input-group-solid mb-5">
                                        <div class="symbol symbol-30px input-group-text">
                                            <img src="{{ asset('assets/admin/assets/media/logos/nagad.png') }}" alt="nagad logo">
                                        </div>
                                        <input type="text" class="form-control" name="nagad_primary" placeholder="Nagad Primary" aria-label="product VAT" value="{{ $payment_methods->where('name', 'nagad')->first()->primary_number ?? '' }}"/>
                                    </div>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <div class="input-group input-group-solid mb-5">
                                        <div class="symbol symbol-30px input-group-text">
                                            <img src="{{ asset('assets/admin/assets/media/logos/nagad.png') }}" alt="nagad logo">
                                        </div>
                                        <input type="text" class="form-control" name="nagad_secondary" placeholder="Nagad Secondary" aria-label="product VAT" value="{{ $payment_methods->where('name', 'nagad')->first()->secondary_number ?? '' }}"/>
                                    </div>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    
                </div>
                <!--end::Card body-->

                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Basic info-->
</div>
<!--end::Content container-->
@endsection
<!--end::Main Content-->

<!--begin::Page Vendors Javascript and custom JS-->
@section('exclusive_scripts')
<script src="{{ asset('assets/admin/assets/js/custom/account/settings/signin-methods.js') }}"></script>
<script src="{{ asset('assets/admin/assets/js/custom/account/settings/profile-details.js') }}"></script>
<script>
    $(document).ready(function() {
        $('[data-toggle="toggle"]').click(function() {
            //toggle class .show-child
            $(this).parents().next('.hide-child').toggleClass('show-child');
        });
    });
</script>
@endsection
<!--end::Page Vendors Javascript and custom JS-->
