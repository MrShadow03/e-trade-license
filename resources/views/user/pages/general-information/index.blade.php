@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>সাধারণ তথ্য | Admin</title>
@endsection
<!--end::Page Title-->

<!--begin::Page Custom Styles(used by this page)-->
@section('exclusive_styles')
    <!--begin::Vendor Stylesheets(used for this page only)-->
    {{-- <link href="{{ asset('assets/admin/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css"> --}}
    {{-- <link href="{{ asset('assets/admin/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"> --}}
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
<!--begin::Main Content-->
@section('content')
<div id="kt_app_content_container" class="app-container container-xxl font-bn">
    <div class="card card-flush pb-0 bgi-position-y-center bgi-no-repeat mb-10 mt-5">
        <!--begin::Card header-->
        <div class="card-header pt-10">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="symbol symbol-circle me-5">
                        <div class="symbol-label bg-transparent text-primary border border-secondary border-dashed">
                            <i class="ki-duotone ki-information fs-2x text-primary">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>                
                        </div>
                    </div>
                    <!--end::Icon-->
    
                    <!--begin::Title-->
                    <div class="d-flex flex-column">
                        <h2 class="font-bn">
                            সাধারণ তথ্যাবলী
                        </h2>
                        <div class="text-muted fw-bold font-noto">
                            সর্বশেষ আপডেট: {{ App\Helpers\Helpers::convertToBanglaDigits(Carbon\Carbon::parse($infos->updated_at)->locale('bn-BD')->diffForHumans()) }} | {{ $infos->updated_by }}
                        </div> 
                    </div>
                    <!--end::Title-->
                </div>
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pb-0">

        </div>
        <!--end::Card body-->
    </div>
    <div class="card card-flush">
    
        <!--begin::Card body-->
        <form action="{{ route('admin.infos.update', 1) }}" id="generalInfoForm" method="POST" enctype="multipart/form-data" class="card-body">
            @csrf
            @method('PATCH')
            <!--begin::Input group-->
            <div class="row mb-4">
                <!--begin::col-->
                <div class="col-md-6 mb-md-0 mb-4">
                    <div class="d-flex flex-column fv-row fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">
                                প্রাতিষ্ঠানিক নাম
                            </span>
                        </label>
                        <!--end::Label-->
                        
                        <input type="text" class="form-control" name="name" value="{{ $infos->name }}">
                        
                        @error('name')
                        <div class="fv-plugins-message-container invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <!--end::col-->
                <div class="col-md-6 mb-0">
                    <!--begin::Label-->
                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                        <span class="required">
                            ফোন নম্বর
                        </span>
                    </label>
                    <!--end::Label-->
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="la la-phone fs-1"></i>
                        </span>
                        <input name="phone" type="text" class="form-control" value="{{ $infos->phone }}" aria-label="phone" aria-describedby="phone number"/>
                    </div>

                    @error('phone')
                    <div class="fv-plugins-message-container invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <!--begin::col-->
                <div class="col-md-6 mb-md-0 mb-4">
                    <div class="d-flex flex-column fv-row fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">
                                ই-মেইল
                            </span>
                        </label>
                        <!--end::Label-->
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="la la-envelope fs-1"></i>
                            </span>
                            <input name="email" type="text" class="form-control" value="{{ $infos->email }}" aria-label="email" aria-describedby="email"/>
                        </div>

                        @error('email')
                        <div class="fv-plugins-message-container invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <!--end::col-->
                <!--begin::col-->
                <div class="col-md-6 mb-0">
                    <div class="d-flex flex-column fv-row fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">
                                অভিযোগ ই-মেইল
                            </span>
                        </label>
                        <!--end::Label-->
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="la la-envelope fs-1"></i>
                            </span>
                            <input name="complaint_email" type="text" class="form-control" value="{{ $infos->complaint_email }}" aria-label="complaint email" aria-describedby="complaint email"/>
                        </div>

                        @error('complaint_email')
                        <div class="fv-plugins-message-container invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <!--end::col-->
            </div>

            <div class="row mb-4">
                <!--begin::col-->
                <div class="col-md-6 mb-md-0 mb-4">
                    <div class="d-flex flex-column fv-row fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">
                                ঠিকানা
                            </span>
                        </label>
                        <!--end::Label-->
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="la la-map-marker fs-1"></i>
                            </span>
                            <input name="address" type="text" class="form-control" value="{{ $infos->address }}" aria-label="address" aria-describedby="address"/>
                        </div>

                        @error('address')
                        <div class="fv-plugins-message-container invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <!--end::col-->
                <!--begin::col-->
                <div class="col-md-6 mb-0">
                    <div class="d-flex flex-column fv-row fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span>
                                ম্যাপ লিংক
                            </span>
                        </label>
                        <!--end::Label-->
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="la la-chain fs-1"></i>
                            </span>
                            <input name="location_iframe" type="text" class="form-control" value="{{ $infos->location_iframe }}" aria-label="Google Map Link" aria-describedby="Google Map Link"/>
                        </div>

                        @error('location_iframe')
                        <div class="fv-plugins-message-container invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <!--end::col-->
            </div>

            <div class="row mb-4">
                <!--begin::col-->
                <div class="col-md-2 mb-md-0 mb-4">
                    <label class="fs-6 fw-semibold mb-4 d-block">
                        <span>
                            ব্যানারে ব্যবহৃত লোগো
                        </span>
                        <span class="ms-1" data-bs-toggle="tooltip" title="ব্যানারে ব্যবহৃত ছবি আপলোড করুন">
                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </span>
                    </label>
                    <div class="image-input image-input-outline" data-kt-image-input="true">
                        <!--begin::Image preview wrapper-->
                        <div class="image-input-wrapper" style="background-image: url('{{ asset('storage').'/'.$infos->banner_logo }}')"></div>
                        <!--end::Image preview wrapper-->

                        <!--begin::Edit button-->
                        <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="change"
                        data-bs-toggle="tooltip"
                        data-bs-dismiss="click"
                        title="ছবি পরিবর্তন করুন">
                            <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

                            <!--begin::Inputs-->
                            <input type="file" name="banner_logo" accept=".png" />
                            <!--end::Inputs-->
                        </label>
                        <!--end::Edit button-->
                    </div>
                    <div class="form-text">ফাইল টাইপ: png | সর্বোচ্চ সাইজ: 100KB</div>

                    @error('banner_logo')
                    <div class="fv-plugins-message-container invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <!--end::col-->
                
                <!--begin::col-->
                <div class="col-md-2 mb-md-0 mb-4">
                    <label class="fs-6 fw-semibold mb-4 d-block">
                        <span>
                            অফিসিয়াল লোগো
                        </span>
                        <span class="ms-1" data-bs-toggle="tooltip" title="দেখার সুবিধার্থে ভালো কোয়ালিটির ছবি আপলোড করুন">
                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </span>
                    </label>
                    <div class="image-input image-input-outline" data-kt-image-input="true">
                        <!--begin::Image preview wrapper-->
                        <div class="image-input-wrapper" style="background-image: url('{{ asset('storage').'/'.$infos->official_logo }}')"></div>
                        <!--end::Image preview wrapper-->

                        <!--begin::Edit button-->
                        <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="change"
                        data-bs-toggle="tooltip"
                        data-bs-dismiss="click"
                        title="ছবি পরিবর্তন করুন">
                            <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

                            <!--begin::Inputs-->
                            <input type="file" name="official_logo" accept=".png" />
                            <!--end::Inputs-->
                        </label>
                        <!--end::Edit button-->
                    </div>
                    <div class="form-text">ফাইল টাইপ: png | সর্বোচ্চ সাইজ: 100KB</div>
                    @error('official_logo')
                    <div class="fv-plugins-message-container invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <!--end::col-->
                
                <!--begin::col-->
                <div class="col-md-2 mb-md-0">
                    <label class="fs-6 fw-semibold mb-4 d-block">
                        <span>
                            ম্যাপের ছবি
                        </span>
                        <span class="ms-1" data-bs-toggle="tooltip" title="দেখার সুবিধার্থে ভালো কোয়ালিটির ছবি আপলোড করুন">
                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </span>
                    </label>
                    <div class="image-input image-input-outline" data-kt-image-input="true">
                        <!--begin::Image preview wrapper-->
                        <div class="image-input-wrapper" style="background-image: url('{{ asset('storage').'/'.$infos->map_image }}')"></div>
                        <!--end::Image preview wrapper-->

                        <!--begin::Edit button-->
                        <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="change"
                        data-bs-toggle="tooltip"
                        data-bs-dismiss="click"
                        title="ছবি পরিবর্তন করুন">
                            <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

                            <!--begin::Inputs-->
                            <input type="file" name="map_image" accept=".png, .jpg, .jpeg" />
                            <!--end::Inputs-->
                        </label>
                        <!--end::Edit button-->
                    </div>
                    <div class="form-text">ফাইল টাইপ: png, jpg | সর্বোচ্চ সাইজ: 500KB</div>
                    @error('map_image')
                    <div class="fv-plugins-message-container invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <!--end::col-->
            </div>

            @can('edit-general-information')
            <!--begin::Actions-->
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-success btn-flex">
                    <i class="fa fa-save fs-3 me-1"></i>
                    <span class="indicator-label"
                    onclick="submitForm(event)"
                    >
                        আপডেট করুন
                    </span>
                    <span class="indicator-progress">
                        অপেক্ষা করুন...<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
            <!--end::Actions-->
            @endcan
        </form>
        <!--end::Card body-->
    </div>
</div>
@endsection
<!--end::Main Content-->


@section('exclusive_scripts')
    <script>
        function submitForm(event){
            let form = document.getElementById('generalInfoForm');
            event.preventDefault();
            Swal.fire({
                title: 'আপনি কি নিশ্চিত?',
                text: "আপনি কি সাধারণ তথ্য আপডেট করতে চান?",
                icon: "info",
                showCancelButton: true,
                cancelButtonText: 'বাতিল করুন',
                confirmButtonText: "হ্যাঁ, আপডেট করুন",
                customClass: {
                    confirmButton: "btn btn-success font-bn order-2",
                    cancelButton: 'btn btn-secondary font-bn order-1 right-gap',
                    title: "font-bn",
                    container: "font-bn",
                }
            }).then(function(result) {
                if (result.value) {
                    form.submit();
                }
            });
        }
    </script>
@endsection
