@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>আবেদন যোগ করুন</title>
@endsection
<!--end::Page Title-->
@section('exclusive_styles')
<link href="{{ asset('/assets/plugins/global/select2.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('/assets/plugins/global/swal2.css') }}" rel="stylesheet" type="text/css">
<style>
    .form label {
        font-size: 14px !important;
        font-weight: 600 !important;
    }
    .form input, .form select {
        font-size: 15px !important;
        font-family: 'Kohinoor', 'HindSiliguri', sans-serif;
    }
</style>
@endsection
@php
    const COMMON_ICON = 'pen-clip';
    const LABEL_INTENSITY = '800';
@endphp
<!--begin::toolbar-->
@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">

        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">

            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 font-bn">
                <!--begin::Title-->
                <h2 class="page-heading d-flex text-dark flex-column justify-content-center font-ador fw-semibold">
                    {{ $application->business_organization_name_bn }} - এর মালিকানা হস্থানান্তর আবেদন
                </h2>
                <!--end::Title-->
                <ol class="breadcrumb text-muted fs-6 fw-normal">
                    <li class="breadcrumb-item"><a href="{{ route('user.trade_license_applications') }}" class="">আবেদন সমূহ</a></li>
                    <li class="breadcrumb-item text-muted">মালিকানা হস্থানান্তর</li>
                </ol>  
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Toolbar container-->
    </div>
@endsection
<!--end::toolbar-->

<!--begin::Main Content-->
@section('content')
<div id="kt_app_content_container" class="app-container container-lg">
    <div class="card card-flush font-bn">
        <!--begin::Form-->
        <form class="card-body form" action="#" method="POST" enctype="multipart/form-data" id="form">
            @csrf
            @method('POST')
            
            <!--begin::Input group-->
            <div class="fv-row mb-4">
                <!--begin::Label-->
                <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                    <span>
                        <span class="required">নতুন স্বত্বাধিকারীর ছবি</span>
                    </span>
                </label>
                <!--end::Label-->

                <!--begin::Image input wrapper-->
                <div class="mt-1">
                    <!--begin::Image input placeholder-->
                    <!--begin::Image input-->
                    <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                        <!--begin::Preview existing avatar-->
                        <div id="ownerImage" class="blockable image-input-wrapper w-125px h-125px border border-gray-300 shadow-none" style="background-image:url({{ $application->business_organization_name ? Helpers::getImageUrl($application, 'owner_image') : '#' }})"></div>
                        <!--end::Preview existing avatar-->

                        <!--begin::Edit-->
                        <label
                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                            title="পরবর্তন করুন">
                            <i class="fal fa-arrow-up-from-bracket fs-5"></i>
                            <!--begin::Inputs-->
                                <input 
                                type="file" 
                                class="file_input" 
                                name="image" 
                                accept=".png, .jpg, .jpeg" 
                                data-fv-file="true"
                                data-fv-file-extension="jpg, jpeg, png"
                                data-fv-file-type="image/jpeg, image/png"
                                data-fv-file-maxSize="200000"
                                data-fv-file-message="ছবির ফরমেট jpg, jpeg, png হতে হবে এবং সাইজ সর্বোচ্চ ২০০ কিলোবাইট হতে পারে"
                                required/>
                            <!--end::Inputs-->
                        </label>
                        <!--end::Edit-->

                        <!--begin::Cancel button-->
                        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow document_cancel"
                        data-kt-image-input-action="cancel"
                        data-bs-toggle="tooltip"
                        data-bs-dismiss="click"
                        title="বাতিল করুন">
                            <i class="far fa-times fs-3"></i>
                        </span>
                        <!--end::Cancel button-->
                    </div>
                    <!--end::Image input-->
                    @error('image')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <!--end::Image input wrapper-->
            </div>
            <!--end::Input group-->
            
            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            জাতীয় পরিচয়পত্র নং (NID)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-address-card fs-3"></i>
                            </div>
                            <input type="text" oninput="getUserDetails(this.value)" maxlength="17" pattern="/^[0-9]+$/" class="ls-2 font-roboto fw-bold form-control text-gray-700" name="national_id_no" value="{{ $application->user?->national_id_no }}"/>
                        </div>
                        <!--end::Input-->
                        @error('national_id_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            ফোন নাম্বার
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-phone-alt fs-3"></i>
                            </div>
                            <input type="text" maxlength="11" class="ls-2 font-roboto fw-bold form-control text-gray-700" name="phone" value="{{ $application->user?->phone }}"/> 
                        </div>
                        <!--end::Input-->
                        @error('phone')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            
            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            জন্ম নিবন্ধন নং
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-address-card fs-3"></i>
                            </div>
                            <input type="text" maxlength="17" class="ls-2 font-roboto fw-bold form-control text-gray-700" name="birth_registration_no" value="{{ $application->user?->birth_registration_no }}"/> 
                        </div>
                        <!--end::Input-->
                        @error('birth_registration_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            পাসপোর্ট নং
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-address-card fs-3"></i>
                            </div>
                            <input type="text"  maxlength="9" class="ls-2 font-roboto fw-bold form-control text-gray-700" name="passport_no" value="{{ $application->user?->passport_no }}"/>
                        </div>
                        <!--end::Input-->
                        @error('passport_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            মালিক/স্বত্বাধিকারীর নাম (বাংলা)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-user fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="name_bn" value="{{ $application->user?->name_bn }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('name_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            মালিক/স্বত্বাধিকারীর নাম (ইংরেজি)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-user fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="name" value="{{ $application->user?->name }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('name')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            পিতার নাম (বাংলা)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-{{ COMMON_ICON }} fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="father_name_bn" value="{{ $application->user?->father_name_bn }}" required/>
                        </div> 
                        <!--end::Input-->
                        @error('father_name_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            পিতার নাম (ইংরেজি)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-{{ COMMON_ICON }} fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="father_name" value="{{ $application->user?->father_name }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('father_name')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            মাতার নাম (বাংলা)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-{{ COMMON_ICON }} fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="mother_name_bn" value="{{ $application->user?->mother_name_bn }}" required/>
                        </div>
                        <!--end::Input-->
                        @error('mother_name_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            মাতার নাম (ইংরেজি)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-{{ COMMON_ICON }} fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="mother_name" value="{{ $application->user?->mother_name }}" required/>
                        </div>
                        <!--end::Input-->
                        @error('mother_name')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            স্বামী বা স্ত্রীর নাম (বাংলা)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-{{ COMMON_ICON }} fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="spouse_name_bn" value="{{ $application->user?->spouse_name_bn }}"/> 
                        </div>
                        <!--end::Input-->
                        @error('spouse_name_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            স্বামী বা স্ত্রীর নাম (ইংরেজি)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-{{ COMMON_ICON }} fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="spouse_name" value="{{ $application->user?->spouse_name }}"/>
                        </div>
                        <!--end::Input-->
                        @error('spouse_name')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>

            <div class="separator separator-content my-15">
                <span class="w-200px text-gray-600
                 fs-5 fw-semibold">
                    ব্যবসা প্রতিষ্ঠানের তথ্য
                </span>
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            ব্যবসা প্রতিষ্ঠানের নাম (বাংলা)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-landmark fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="business_organization_name_bn" value="{{ old('business_organization_name_bn') }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('business_organization_name_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            ব্যবসা প্রতিষ্ঠানের নাম (ইংরেজি)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-landmark fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="business_organization_name" value="{{ old('business_organization_name') }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('business_organization_name')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            ব্যবসার প্রকৃতি
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-{{ COMMON_ICON }} fs-3"></i>
                            </div>
                            <select type="text" class="form-control text-gray-900 form-select" placeholder name="nature_of_business_bn" value="{{ old('nature_of_business_bn') }}" required>
                                <option value="">ব্যবসার প্রকৃতি নির্বাচন করুন</option>
                                <option value="একক" @selected(old('nature_of_business_bn') === 'একক')>একক</option>
                                <option value="যৌথ" @selected(old('nature_of_business_bn') === 'যৌথ')>যৌথ</option>
                                <option value="অন্যান্য" @selected(old('nature_of_business_bn') === 'অন্যান্য')>অন্যান্য</option>
                            </select> 
                        </div>
                        <!--end::Input-->
                    </div>
                    @error('nature_of_business_bn')
                    <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                    @enderror
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            ব্যবসার ধরন/লাইসেন্স ফি
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group flex-nowrap">
                            <div class="input-group-text">
                                <i class="fal fa-{{ COMMON_ICON }} fs-3"></i>
                            </div>
                            <div class="w-100">
                                <select type="text" class="form-control text-gray-900 form-select font-kohinoor" name="business_category_id" value="{{ old('business_category_id') }}" required>
                                    <option value="">ব্যবসার ধরন নির্বাচন করুন</option>
                                    @foreach ($businessCategories as $cat)
                                        <option value="{{ $cat->id }}" @selected(old('business_category_id') == $cat->id) >{{ $cat->name_bn }} - {{ Helpers::convertToBanglaDigits(number_format(round($cat->fee), 0, ',')) }} টাকা</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                        <!--end::Input-->
                    </div>
                    @error('type_of_business_bn')
                    <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                    @enderror
                    <!--end::Input group-->
                </div>
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            ব্যবসা প্রতিষ্ঠানের ঠিকানা (বাংলা)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-location-dot fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="address_of_business_organization_bn" value="{{ old('address_of_business_organization_bn') }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('address_of_business_organization_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            ব্যবসা প্রতিষ্ঠানের ঠিকানা (ইংরেজি)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-location-dot fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="address_of_business_organization" value="{{ old('address_of_business_organization') }}" required/>
                        </div>
                        <!--end::Input-->
                        @error('address_of_business_organization')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            
            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            অঞ্চল (বাংলা)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-location-dot fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="zone_bn" value="{{ old('zone_bn') }}"/> 
                        </div>
                        <!--end::Input-->
                        @error('zone_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            ওয়ার্ড নং
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group flex-nowrap">
                            <div class="input-group-text">
                                <i class="fal fa-location-dot fs-3"></i>
                            </div>
                            <div class="w-100">
                                <select type="text" class="form-control text-gray-900 form-select font-kohinoor" name="ward_no" value="{{ old('ward_no') }}" required>
                                    <option value="">ওয়ার্ড নির্বাচন করুন</option>
                                    @for ($i = 1; $i <= 30; $i++)
                                        <option value="{{ $i }}" @selected(old('ward_no') == $i)>{{ Helpers::convertToBanglaDigits($i) }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <!--end::Input-->
                        @error('ward_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            টি আই এন নং
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fs-4">TIN</span>
                            </div>
                            <input type="text" class="font-roboto fw-normal ls-1 form-control text-gray-900" placeholder name="tin_no" value="{{ old('tin_no') }}"/> 
                        </div>
                        <!--end::Input-->
                        @error('tin_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            বি আই এন নং
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fs-4">BIN</span>
                            </div>
                            <input type="text" class="font-roboto fw-normal ls-1 form-control text-gray-900" placeholder name="bin_no" value="{{ old('bin_no') }}"/> 
                        </div>
                        <!--end::Input-->
                        @error('bin_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            ফোন নম্বর
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fs-4">+88</span>
                            </div>
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" maxlength="11" placeholder name="phone_no" value="{{ old('phone_no') }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('phone_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            ই-মেইল ঠিকানা
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-envelope fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="email" value="{{ old('email') }}"/> 
                        </div>
                        <!--end::Input-->
                        @error('email')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            সাইনবোর্ডের ধরন (ফিট)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group flex-nowrap">
                            <div class="input-group-text">
                                <i class="fal fa-calendars fs-3"></i>
                            </div>
                            <div class="w-100">
                                <select type="text" class="form-control text-gray-900 form-select font-kohinoor" name="signboard_id" required>
                                    @foreach ($signboards as $item)
                                        <option value="{{ $item->id }}" @selected(old('signboard_id') == $item->id)>
                                            {{ Helpers::convertToBanglaDigits($item->dimension) }} - {{ Helpers::convertToBanglaDigits(number_format(round($item->fee), 0, ',')) }} টাকা
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end::Input-->
                        @error('signboard_id')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            ব্যবসা শুরুর তারিখ
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-calendar-star fs-3"></i>
                            </div>
                            <input type="date" class="form-control text-gray-900" placeholder name="business_starting_date" value="{{ old('business_starting_date') }}"/> 
                        </div>
                        <!--end::Input-->
                        @error('business_starting_date')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>

            <div class="separator separator-content my-15">
                <span class="w-300px text-gray-600
                 fs-5 fw-semibold">
                    মালিক/স্বত্বাধিকারীর বর্তমান ঠিকানা
                </span>
            </div>

            <!--Has: Holding No, Road No, Post Code-->
            <div class="row row-cols-md-3 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            হোল্ডিং নং
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-home fs-3"></i>
                            </div>
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="ca_holding_no" value="{{ $application->user?->ca_holding_no }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('ca_holding_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            রোড নং
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-road fs-3"></i>
                            </div>
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="ca_road_no" value="{{ $application->user?->ca_road_no }}"/> 
                        </div>
                        <!--end::Input-->
                        @error('ca_road_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            পোস্ট কোড
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-mailbox fs-3"></i>
                            </div>
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="ca_post_code" value="{{ $application->user?->ca_post_code }}"/> 
                        </div>
                        <!--end::Input-->
                        @error('ca_post_code')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            
            <!--Has: vaillage_bn, village-->
            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            এলাকা/গ্রামের নাম (বাংলা)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_village_bn" value="{{ $application->user?->ca_village_bn }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('ca_village_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            এলাকা/গ্রামের নাম (ইংরেজি)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_village" value="{{ $application->user?->ca_village }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('ca_village')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            
            <!--Has: post_office_bn, post_office-->
            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            ডাকঘর (বাংলা)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-mailbox fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_post_office_bn" value="{{ $application->user?->ca_post_office_bn }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('ca_post_office_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            ডাকঘর (ইংরেজি)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-mailbox fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_post_office" value="{{ $application->user?->ca_post_office }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('ca_post_office')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            
            <!--Has: upazilla police, bn-->
            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            বিভাগ
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <select onchange="assignDistricts('caDivisionBn', 'caDistrictBn')" type="text" id="caDivisionBn" class="form-control form-select text-gray-900" placeholder name="ca_division_bn" value="" required>
                                <option value="বরিশাল" @selected($application->signboard_id === 'বরিশাল') >বরিশাল</option>
                                <option value="ঢাকা" @selected($application->signboard_id === 'ঢাকা') >ঢাকা</option>
                                <option value="খুলনা" @selected($application->signboard_id === 'খুলনা') >খুলনা</option>
                                <option value="রাজশাহী" @selected($application->signboard_id === 'রাজশাহী') >রাজশাহী</option>
                                <option value="সিলেট" @selected($application->signboard_id === 'সিলেট') >সিলেট</option>
                                <option value="ময়মনসিংহ" @selected($application->signboard_id === 'ময়মনসিংহ') >ময়মনসিংহ</option>
                                <option value="রংপুর" @selected($application->signboard_id === 'রংপুর') >রংপুর</option>
                                <option value="চট্টগ্রাম" @selected($application->signboard_id === 'চট্টগ্রাম') >চট্টগ্রাম</option>
                            </select>
                        </div>
                        <!--end::Input-->
                        @error('ca_division_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            জেলা
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group flex-nowrap">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <select type="text" id="caDistrictBn" class="form-control text-gray-900" placeholder name="ca_district_bn" value="" required>
                                @foreach ($districts as $district)
                                    <option value="{{ $district }}" @selected($application->ca_district_bn === $district) >{{ $district }}</option>
                                @endforeach
                            </select> 
                        </div>
                        <!--end::Input-->
                        @error('ca_district_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            
            <!--Has: upazilla police, bn-->
            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            উপজেলা/থানা (বাংলা)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_upazilla_bn" value="{{ $application->user?->ca_upazilla_bn }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('ca_upazilla_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            উপজেলা/থানা (ইংরেজি)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text required">
                                <i class="fal fa-mailbox fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_upazilla" value="{{ $application->user?->ca_upazilla }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('ca_upazilla')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>


            <div class="separator separator-content my-15">
                <span class="w-300px text-gray-600
                 fs-5 fw-semibold">
                    স্থায়ী ঠিকানা
                </span>
            </div>

            <div class="form-check form-switch form-check-custom my-3">
                <input class="form-check-input h-20px w-30px" onchange="sameAsCa(this)" type="checkbox" id="sameAsCurrentAddress" name="same_as_current_address" value="1">
                <label class="form-check form-check-custom" for="sameAsCurrentAddress">
                    <span class="fs-6 fw-semibold text-primary ms-3 user-select-none">
                        বর্তমান ঠিকানার সাথে মিল আছে?
                    </span>
                </label>
            </div>

            <!--Has: Holding No, Road No, Post Code-->
            <div class="row row-cols-md-3 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            হোল্ডিং নং
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-home fs-3"></i>
                            </div>
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="pa_holding_no" value="{{ $application->user?->pa_holding_no }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('pa_holding_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            রোড নং
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-road fs-3"></i>
                            </div>
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="pa_road_no" value="{{ $application->user?->pa_road_no }}"/> 
                        </div>
                        <!--end::Input-->
                        @error('pa_road_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            পোস্ট কোড
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-mailbox fs-3"></i>
                            </div>
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="pa_post_code" value="{{ $application->user?->pa_post_code }}"/> 
                        </div>
                        <!--end::Input-->
                        @error('pa_post_code')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            
            <!--Has: vaillage_bn, village-->
            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            এলাকা/গ্রামের নাম (বাংলা)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_village_bn" value="{{ $application->user?->pa_village_bn }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('pa_village_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            এলাকা/গ্রামের নাম (ইংরেজি)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_village" value="{{ $application->user?->pa_village }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('pa_village')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            
            <!--Has: post_office_bn, post_office-->
            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            ডাকঘর (বাংলা)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-mailbox fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_post_office_bn" value="{{ $application->user?->pa_post_office_bn }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('pa_post_office_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            ডাকঘর (ইংরেজি)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-mailbox fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_post_office" value="{{ $application->user?->pa_post_office }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('pa_post_office')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            
            <!--Has: upazilla police, bn-->
            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            বিভাগ
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <select onchange="assignDistricts('paDivisionBn', 'paDistrictBn')" type="text" id="paDivisionBn" class="form-control form-select text-gray-900" placeholder name="pa_division_bn" required>
                                <option value="বরিশাল" @selected($application->pa_division_bn === 'বরিশাল') >বরিশাল</option>
                                <option value="ঢাকা" @selected($application->pa_division_bn === 'ঢাকা') >ঢাকা</option>
                                <option value="খুলনা" @selected($application->pa_division_bn === 'খুলনা') >খুলনা</option>
                                <option value="রাজশাহী" @selected($application->pa_division_bn === 'রাজশাহী') >রাজশাহী</option>
                                <option value="সিলেট" @selected($application->pa_division_bn === 'সিলেট') >সিলেট</option>
                                <option value="ময়মনসিংহ" @selected($application->pa_division_bn === 'ময়মনসিংহ') >ময়মনসিংহ</option>
                                <option value="রংপুর" @selected($application->pa_division_bn === 'রংপুর') >রংপুর</option>
                                <option value="চট্টগ্রাম" @selected($application->pa_division_bn === 'চট্টগ্রাম') >চট্টগ্রাম</option>
                            </select>
                        </div>
                        <!--end::Input-->
                        @error('pa_division_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            জেলা
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group flex-nowrap">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <select type="text" id="paDistrictBn" class="form-control text-gray-900" placeholder name="pa_district_bn" required>
                                @foreach ($districts as $district)
                                    <option value="{{ $district }}" @selected($application->pa_district_bn === $district) >{{ $district }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Input-->
                        @error('pa_district_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            
            <!--Has: upazilla police, bn-->
            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            উপজেলা/থানা (বাংলা)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_upazilla_bn" value="{{ $application->user?->pa_upazilla_bn }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('pa_upazilla_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            উপজেলা/থানা (ইংরেজি)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-mailbox fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_upazilla" value="{{ $application->user?->pa_upazilla }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('pa_upazilla')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            
            <div class="separator separator-content my-15">
                <span class="w-200px text-gray-600
                 fs-5 fw-semibold">
                    প্রয়োজনীয় নথিপত্র
                </span>
            </div>

            <input type="hidden" id="documentsInput" value="{{ json_encode($application->documents->pluck('trade_license_required_document_id')->toArray()) }}"/>
                <div class="row">
                    <div class="col col-lg-3 col-md-4 col-12 mb-4 mb-md-0">
                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class="pb-2 pb-md-0 min-h-0 fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                                <span>
                                    <span class="required">নতুন স্বত্বাধিকারীর জাতীয় পরিচয় পত্র</span>
                                </span>
                            </label>
                            <!--end::Label-->
    
                            
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline" data-kt-image-input="true">
                                <!--begin::Image preview wrapper-->
                                <div class="d-block image-input-wrapper w-200px h-250px position-relative" id="imageWrapper1">
                                    <i class="fal fa-file-invoice image_wrapper_icon text-danger"></i>
                                </div>
                                <!--end::Image preview wrapper-->

                                <!--begin::Edit button-->
                                <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-30px h-30px bg-body shadow"
                                data-kt-image-input-action="change"
                                data-bs-toggle="tooltip"
                                data-bs-dismiss="click"
                                title="আপলোড করুন"
                                for="fileInput1"
                                >
                                    <i class="far fa-cloud-arrow-up fs-6"></i>

                                    <!--begin::Inputs-->
                                    <input type="file" class="document_input" id="fileInput1" data-document-id="1" name="owners-nid" accept=".png, .jpg, .jpeg, .pdf" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->

                                <!--begin::Cancel button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow document_cancel"
                                data-kt-image-input-action="cancel"
                                data-bs-toggle="tooltip"
                                data-bs-dismiss="click"
                                data-document-id="1"
                                id="cancelButton1"
                                title="বাতিল করুন">
                                    <i class="far fa-times fs-3"></i>
                                </span>
                                <!--end::Cancel button-->
                            </div>
                            <!--end::Image input-->
                        </div>
                    </div>
                    <div class="col col-lg-3 col-md-4 col-12 mb-4 mb-md-0">
                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class="pb-2 pb-md-0 min-h-0 fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                                <span>
                                    <span class="required">মালিকানা হস্থান্তর দলিল</span>
                                </span>
                            </label>
                            <!--end::Label-->
    
                            
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline" data-kt-image-input="true">
                                <!--begin::Image preview wrapper-->
                                <div class="d-block image-input-wrapper w-200px h-250px position-relative" id="imageWrapper2">
                                    <i class="fal fa-file-invoice image_wrapper_icon text-danger"></i>
                                </div>
                                <!--end::Image preview wrapper-->

                                <!--begin::Edit button-->
                                <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-30px h-30px bg-body shadow"
                                data-kt-image-input-action="change"
                                data-bs-toggle="tooltip"
                                data-bs-dismiss="click"
                                title="আপলোড করুন"
                                for="fileInput2"
                                >
                                    <i class="far fa-cloud-arrow-up fs-6"></i>

                                    <!--begin::Inputs-->
                                    <input type="file" class="document_input" id="fileInput2" data-document-id="2" name="ownership-transfer-deed" accept=".png, .jpg, .jpeg, .pdf" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->

                                <!--begin::Cancel button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow document_cancel"
                                data-kt-image-input-action="cancel"
                                data-bs-toggle="tooltip"
                                data-bs-dismiss="click"
                                data-document-id="2"
                                id="cancelButton2"
                                title="বাতিল করুন">
                                    <i class="far fa-times fs-3"></i>
                                </span>
                                <!--end::Cancel button-->
                            </div>
                            <!--end::Image input-->
                        </div>
                    </div>
                </div>

            <div class="d-flex justify-content-center mt-5">
                <!--begin::Button-->
                <button type="submit" id="button" class="btn btn-success ms-2">
                    <span class="indicator-label">
                        আবেদন জমা দিন
                    </span>
                    <span class="indicator-progress">অপেক্ষা করুন...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
                <!--end::Button-->
            </div>
        </form>
        <!--end::Form-->
    </div>
</div>
@endsection
<!--end::Main Content-->

@section('exclusive_scripts')
<script src="{{ asset('assets/plugins/custom/axios/axios.min.js') }}"></script>
<script>
    const form = document.getElementById('form');

    $(document).ready(function() {
        $('[name="national_id_no"]').maxlength({
            threshold: 13,
            warningClass: "badge badge-primary",
            limitReachedClass: "badge badge-success",
            limitExceededClass: "badge badge-danger"
        });
        $('[name="phone"]').maxlength({
            threshold: 11,
            warningClass: "badge badge-primary",
            limitReachedClass: "badge badge-success",
            limitExceededClass: "badge badge-danger"
        });
        $('[name="birth_registration_no"]').maxlength({
            threshold: 17,
            warningClass: "badge badge-danger",
            limitReachedClass: "badge badge-success",
            limitExceededClass: "badge badge-danger"
        });
        $('[name="passport_no"]').maxlength({
            warningClass: "badge badge-danger",
            limitReachedClass: "badge badge-success",
            limitExceededClass: "badge badge-danger"
        });
        $('[name="business_category_id"]').select2();
        $('[name="ward_no"]').select2();
        $('[name="signboard_id"]').select2();
    });

    var imageInputElement = document.querySelectorAll(".document_input");
        imageInputElement.forEach(function (element) {
            element.addEventListener("change", function (e) {
                var fileName = e.target.files[0].name;
                var ext = fileName.split('.').pop();
                var documentId = e.target.getAttribute('data-document-id');
                var imageWrapper = document.querySelector('#imageWrapper'+documentId);
                imageWrapper.innerHTML = '';

                if (ext == 'pdf') {
                    if (imageWrapper) {
                        let i = document.createElement('i');
                        i.className = 'fa fa-file-pdf image_wrapper_icon text-danger';
                        let span = document.createElement('span');
                        span.className = 'p-2 text-muted fs-7';
                        // keep the first 10 characters of the file name and add ... at the end with the extension
                        span.innerHTML = fileName.substring(0, 10) + '...' + ext;
                        imageWrapper.appendChild(span);
                        imageWrapper.appendChild(i);
                    }

                }
            }
        );
    });

    var documentCancel = document.querySelectorAll(".document_cancel");

    documentCancel.forEach(function (element) {
        element.addEventListener("click", function (e) {
            var documentId = element.getAttribute('data-document-id');
            var imageWrapper = document.querySelector('#imageWrapper'+documentId);

            imageWrapper.innerHTML = '';
        });
    });


    var divisionsAndDistricts = [
        [
            "চট্টগ্রাম",
            [
                "কুমিল্লা",
                "ফেনী",
                "ব্রাহ্মণবাড়িয়া",
                "রাঙ্গামাটি",
                "নোয়াখালী",
                "চাঁদপুর",
                "লক্ষ্মীপুর",
                "চট্টগ্রাম",
                "কক্সবাজার",
                "খাগড়াছড়ি",
                "বান্দরবান",
            ],
        ],
        [
            "রাজশাহী",
            [
                "সিরাজগঞ্জ",
                "পাবনা",
                "বগুড়া",
                "রাজশাহী",
                "নাটোর",
                "জয়পুরহাট",
                "চাঁপাইনবাবগঞ্জ",
                "নওগাঁ",
            ],
        ],
        [
            "খুলনা",
            [
                "যশোর",
                "সাতক্ষীরা",
                "মেহেরপুর",
                "নড়াইল",
                "চুয়াডাঙ্গা",
                "কুষ্টিয়া",
                "মাগুরা",
                "খুলনা",
                "বাগেরহাট",
                "ঝিনাইদহ",
            ],
        ],
        [
            "বরিশাল",
            ["ঝালকাঠি", "পটুয়াখালী", "পিরোজপুর", "বরিশাল", "ভোলা", "বরগুনা"],
        ],
        ["সিলেট", ["সিলেট", "মৌলভীবাজার", "হবিগঞ্জ", "সুনামগঞ্জ"]],
        [
            "ঢাকা",
            [
                "নরসিংদী",
                "গাজীপুর",
                "শরীয়তপুর",
                "নারায়ণগঞ্জ",
                "টাঙ্গাইল",
                "কিশোরগঞ্জ",
                "মানিকগঞ্জ",
                "ঢাকা",
                "মুন্সিগঞ্জ",
                "রাজবাড়ী",
                "মাদারীপুর",
                "গোপালগঞ্জ",
                "ফরিদপুর",
            ],
        ],
        [
            "রংপুর",
            [
                "পঞ্চগড়",
                "দিনাজপুর",
                "লালমনিরহাট",
                "নীলফামারী",
                "গাইবান্ধা",
                "ঠাকুরগাঁও",
                "রংপুর",
                "কুড়িগ্রাম",
            ],
        ],
        ["ময়মনসিংহ", ["শেরপুর", "ময়মনসিংহ", "জামালপুর", "নেত্রকোণা"]],
    ];
    const assignDistricts = (divisionElementID, districtElementID) => {
        const divisionElement = document.getElementById(divisionElementID);
        const districtElement = document.getElementById(districtElementID);
        const division = divisionElement.value;
        const districts = divisionsAndDistricts.find((item) => item[0] === division)[1];
        districtElement.innerHTML = "";
        districts.forEach((district) => {
            const option = document.createElement("option");
            option.value = district;
            option.text = district;
            districtElement.appendChild(option);
        });

        // Trigger change event
        districtElement.dispatchEvent(new Event("change"));
    };

    const ownerImage = document.getElementById("ownerImage");

    const ownerNameBn = document.querySelector('[name="name_bn"]');
    const ownerName = document.querySelector('[name="name"]');
    const fatherNameBn = document.querySelector('[name="father_name_bn"]');
    const fatherName = document.querySelector('[name="father_name"]');
    const motherNameBn = document.querySelector('[name="mother_name_bn"]');
    const motherName = document.querySelector('[name="mother_name"]');
    const spouseNameBn = document.querySelector('[name="spouse_name_bn"]');
    const spouseName = document.querySelector('[name="spouse_name"]');
    const nationalIdNo = document.querySelector('[name="national_id_no"]');
    const phone = document.querySelector('[name="phone"]');
    const birthRegistrationNo = document.querySelector('[name="birth_registration_no"]');
    const passportNo = document.querySelector('[name="passport_no"]');

    const caHoldingNo = document.querySelector('[name="ca_holding_no"]');
    const caRoadNo = document.querySelector('[name="ca_road_no"]');
    const caPostCode = document.querySelector('[name="ca_post_code"]');
    const caVillageBn = document.querySelector('[name="ca_village_bn"]');
    const caVillage = document.querySelector('[name="ca_village"]');
    const caPostOfficeBn = document.querySelector('[name="ca_post_office_bn"]');
    const caPostOffice = document.querySelector('[name="ca_post_office"]');
    const caDivisionBn = document.querySelector('[name="ca_division_bn"]');
    const caDistrictBn = document.querySelector('[name="ca_district_bn"]');
    const caUpazillaBn = document.querySelector('[name="ca_upazilla_bn"]');
    const caUpazilla = document.querySelector('[name="ca_upazilla"]');

    const paHoldingNo = document.querySelector('[name="pa_holding_no"]');
    const paRoadNo = document.querySelector('[name="pa_road_no"]');
    const paPostCode = document.querySelector('[name="pa_post_code"]');
    const paVillageBn = document.querySelector('[name="pa_village_bn"]');
    const paVillage = document.querySelector('[name="pa_village"]');
    const paPostOfficeBn = document.querySelector('[name="pa_post_office_bn"]');
    const paPostOffice = document.querySelector('[name="pa_post_office"]');
    const paDivisionBn = document.querySelector('[name="pa_division_bn"]');
    const paDistrictBn = document.querySelector('[name="pa_district_bn"]');
    const paUpazillaBn = document.querySelector('[name="pa_upazilla_bn"]');
    const paUpazilla = document.querySelector('[name="pa_upazilla"]');

    const sameAsCurrentCheckbox = document.getElementById("sameAsCurrentAddress");

    [caHoldingNo, caRoadNo, caPostCode, caVillageBn, caVillage, caPostOfficeBn, caPostOffice, caDivisionBn, caDistrictBn, caUpazillaBn, caUpazilla].forEach((element) => {
        ['keyup', 'change', 'input'].forEach((event) => {
            element?.addEventListener(event, () => {
                if (sameAsCurrentCheckbox.checked) {
                    sameAsCa(sameAsCurrentCheckbox, element.getAttribute('name').replace('ca_', 'pa_'));
                }
            });
        });
    });

    const autofillInputs = [ownerNameBn, ownerName, fatherNameBn, fatherName, motherNameBn, motherName, spouseNameBn, spouseName, phone, birthRegistrationNo, passportNo, caHoldingNo, caRoadNo, caPostCode, caVillageBn, caVillage, caPostOfficeBn, caPostOffice, caDivisionBn, caDistrictBn, caUpazillaBn, caUpazilla, paHoldingNo, paRoadNo, paPostCode, paVillageBn, paVillage, paPostOfficeBn, paPostOffice, paDivisionBn, paDistrictBn, paUpazillaBn, paUpazilla]

    const sameAsCa = (element, revalidationField = null) => {

        if (element.checked) {
            paHoldingNo.value = caHoldingNo.value;
            paRoadNo.value = caRoadNo.value;
            paPostCode.value = caPostCode.value;
            paVillageBn.value = caVillageBn.value;
            paVillage.value = caVillage.value;
            paPostOfficeBn.value = caPostOfficeBn.value;
            paPostOffice.value = caPostOffice.value;
            paDivisionBn.value = caDivisionBn.value;
            paDistrictBn.value = caDistrictBn.value;
            paUpazillaBn.value = caUpazillaBn.value;
            paUpazilla.value = caUpazilla.value;

            // Trigger change event for all elements
            [paDivisionBn, paDistrictBn].forEach((element) => {
                element.dispatchEvent(new Event("change"));
            });
            
            const validator = KTSigninGeneral.getValidator();

            if (revalidationField) {
                validator.revalidateField(revalidationField);
            }else {
                validator.validate().then(function (status) {
                    if (status == 'Valid') {
                        // Valid form, proceed with your logic
                    } else {
                        // Invalid form, handle accordingly
                    }
                });
            }
        } 
    };

    var imageInputElement = document.querySelectorAll(".document_input");
        imageInputElement.forEach(function (element) {
            element.addEventListener("change", function (e) {
                var fileName = e.target.files[0].name;
                var ext = fileName.split('.').pop();
                var documentId = e.target.getAttribute('data-document-id');
                var imageWrapper = document.querySelector('#imageWrapper'+documentId);
                imageWrapper.innerHTML = '';

                if (ext == 'pdf') {
                    if (imageWrapper) {
                        let i = document.createElement('i');
                        i.className = 'fa fa-file-pdf image_wrapper_icon text-danger';
                        let span = document.createElement('span');
                        span.className = 'p-2 text-muted fs-7';
                        // keep the first 10 characters of the file name and add ... at the end with the extension
                        span.innerHTML = fileName.substring(0, 10) + '...' + ext;
                        imageWrapper.appendChild(span);
                        imageWrapper.appendChild(i);
                    }
                }
            }
        );
    });

    const checkFormValidity = (form, validator, submitButton) => {
        submitButton.addEventListener('click', function (e) {
            // Prevent default button action
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    if (status == 'Valid') {
                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click
                        submitButton.disabled = true;

                        // submit form
                        form.submit();
                    }else{
                        Swal.fire({
                            title: `আবেদন সম্পাদন করা যাবে না!`,
                            text: "সকল প্রয়োজনীয় তথ্য সঠিকভাবে প্রদান করুন।",
                            icon: "error",
                            confirmButtonText: "ঠিক আছে",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                title: "font-bn",
                                container: "font-bn",
                            }
                        });
                    }
                })
            }
        });
    }

    const requiredAndBengali = (regex = /^[\u0980-\u09FF ]+$/, notEmptyMessage="অবশ্যই প্রদান করতে হবে") => ({
        notEmpty: {
            message: notEmptyMessage
        },
        callback: {
            message: 'শুধুমাত্র বাংলা অক্ষর গ্রহণযোগ্য',
            callback: function(value, validator, field) {
                // Check if value is either a valid email or a valid phone number
                var input = value.element;
                value = value.value;


                if (value.trim() === '') {
                    return true; // Skip validation if field is empty
                }
                
                var bengaliPattern = regex;

                if (bengaliPattern.test(value)) {
                    return true;
                }

                //delete the last character from the input
                input.value = input.value.slice(0, -1);
                
                return false;
            }
        }
    });

    const requiredAndEnglish = (regex = /^[A-Za-z\. ]+$/, notEmptyMessage="অবশ্যই প্রদান করতে হবে") => ({
        notEmpty: {
            message: notEmptyMessage
        },
        callback: {
            message: 'শুধুমাত্র ইংরেজি অক্ষর গ্রহণযোগ্য',
            callback: function(value, validator, field) {
                // Check if value is either a valid email or a valid phone number
                var input = value.element;
                value = value.value;

                if (value.trim() === '') {
                    return true; // Skip validation if field is empty
                }
                
                var englishPattern = regex;

                if (englishPattern.test(value)) {
                    return true;
                }

                //delete the last character from the input
                input.value = input.value.slice(0, -1);
                return false;
            }
        }
    });

    var formValidator = FormValidation.formValidation(
        form,
        {
            fields: {
                'image': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        },
                        file: {
                            extension: 'jpeg,jpg,png',
                            type: 'image/jpeg,image/png',
                            maxSize: 1024*1024*2,   // 2MB
                            message: 'ফাইল ফরম্যাট: jpeg, jpg, png | সর্বোচ্চ আকার ২ মেগাবাইট'
                        }
                    }
                },
                'name_bn': {
                    validators: requiredAndBengali(),
                },
                'name': {
                    validators: requiredAndEnglish(),
                },
                'father_name_bn': {
                    validators: requiredAndBengali(),
                },
                'father_name': {
                    validators: requiredAndEnglish(),
                },
                'mother_name_bn': {
                    validators: requiredAndBengali(),
                },
                'mother_name': {
                    validators: requiredAndEnglish(),
                },
                'spouse_name_bn': {
                    validators: {
                        callback: {
                            message: 'শুধুমাত্র বাংলা অক্ষর গ্রহণযোগ্য',
                            callback: function(value, validator, field) {
                                // Check if value is either a valid email or a valid phone number
                                var input = value.element;
                                value = value.value;

                                if (value.trim() === '') {
                                    return true; // Skip validation if field is empty
                                }
                                
                                var bengaliPattern = /^[\u0980-\u09FF ]+$/;

                                if (bengaliPattern.test(value)) {
                                    return true;
                                }

                                //delete the last character from the input
                                input.value = input.value.slice(0, -1);

                                return false;
                            }
                        }
                    }
                },
                'spouse_name': {
                    validators: {
                        callback: {
                            message: 'শুধুমাত্র ইংরেজি অক্ষর গ্রহণযোগ্য',
                            callback: function(value, validator, field) {
                                // Check if value is either a valid email or a valid phone number
                                var input = value.element;
                                value = value.value;

                                if (value.trim() === '') {
                                    return true; // Skip validation if field is empty
                                }
                                
                                var englishPattern = /^[A-Za-z ]+$/;

                                if (englishPattern.test(value)) {
                                    return true;
                                }

                                //delete the last character from the input
                                input.value = input.value.slice(0, -1);
                                
                                return false;
                            }
                        }
                    }
                },
                'national_id_no': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        },
                        stringLength: {
                            min: 13,
                            max: 17,
                            message: 'জাতীয় পরিচয়পত্র নং ১৩ থেকে ১৭ অক্ষরের মধ্যে হতে হবে'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                        },
                    }
                },
                'phone': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        },
                        stringLength: {
                            min: 11,
                            max: 11,
                            message: 'ফোন নাম্বার ১১ অক্ষরের হতে হবে'
                        },
                        regexp: {
                            regexp: /^01[3-9]\d{8}$/,
                            message: 'সঠিক ফোন নাম্বার প্রদান করুন'
                        }
                    }
                },
                'birth_registration_no': {
                    validators: {
                        stringLength: {
                            min: 17,
                            max: 17,
                            message: 'জন্ম নিবন্ধন নং ১৭ অক্ষরের হতে হবে'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                        }
                    }
                },
                'passport_no': {
                    validators: {
                        stringLength: {
                            min: 9,
                            max: 9,
                            message: 'পাসপোর্ট নং ৯ অক্ষরের হতে হবে'
                        }
                    }
                },
                'ca_holding_no': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                        }
                    }
                },
                'ca_road_no': {
                    validators: 
                    {
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                        }
                    }
                },
                'ca_post_code': {
                    validators: {
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                        }
                    }
                },
                'ca_village_bn': {
                    validators: requiredAndBengali(/^[\u0980-\u09FF\,\.\- ]+$/)
                },
                'ca_village': {
                    validators: requiredAndEnglish(/^[A-Za-z0-9\,\.\- ]+$/)
                },
                'ca_post_office_bn': {
                    validators: requiredAndBengali(/^[\u0980-\u09FF\,\.\- ]+$/)
                },
                'ca_post_office': {
                    validators: requiredAndEnglish(/^[A-Za-z0-9\,\.\- ]+$/)
                },
                'ca_upazilla_bn': {
                    validators: requiredAndBengali(/^[\u0980-\u09FF\,\.\- ]+$/)
                },
                'ca_upazilla': {
                    validators: requiredAndEnglish(/^[A-Za-z0-9\,\.\- ]+$/)
                },
                'pa_holding_no': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                        }
                    }
                },
                'pa_road_no': {
                    validators: 
                    {
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                        }
                    }
                },
                'pa_post_code': {
                    validators: {
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                        }
                    }
                },
                'pa_village_bn': {
                    validators: requiredAndBengali(/^[\u0980-\u09FF\,\.\- ]+$/)
                },
                'pa_village': {
                    validators: requiredAndEnglish(/^[A-Za-z0-9\,\.\- ]+$/)
                },
                'pa_post_office_bn': {
                    validators: requiredAndBengali(/^[\u0980-\u09FF\,\.\- ]+$/)
                },
                'pa_post_office': {
                    validators: requiredAndEnglish(/^[A-Za-z0-9\,\.\- ]+$/)
                },
                'pa_upazilla_bn': {
                    validators: requiredAndBengali(/^[\u0980-\u09FF\,\.\- ]+$/)
                },
                'pa_upazilla': {
                    validators: requiredAndEnglish(/^[A-Za-z0-9\,\.\- ]+$/)
                },
                'owners-nid': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        },
                        file: {
                            extension: 'jpeg,jpg,png,pdf',
                                    type: 'image/jpeg,image/png,application/pdf',
                                    maxSize: 1024*1024*1,  // 1MB
                                    message: 'সঠিক ফাইল ফরম্যাট: jpeg, jpg, png, pdf | সর্বোচ্চ আকার ১ মেগাবাইট'

                        }
                    }
                },
                'ownership-transfer-deed': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        },
                        file: {
                            extension: 'jpeg,jpg,png,pdf',
                                    type: 'image/jpeg,image/png,application/pdf',
                                    maxSize: 1024*1024*1,  // 1MB
                                    message: 'সঠিক ফাইল ফরম্যাট: jpeg, jpg, png, pdf | সর্বোচ্চ আকার ১ মেগাবাইট'

                        }
                    }
                }
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    // eleValidClass: ''
                })
            }
        }
    );

    const formSubmitButton = document.getElementById('button');
    checkFormValidity(form, formValidator, formSubmitButton);

    var blockableEl = document.querySelector('.blockable');
    var blockUI = new KTBlockUI(blockableEl);
    const getUserDetails = (nid) => {
        if (nid.length >= 13) {
            blockUI.block();
            let host = window.location.origin;
            let url = `${host}/api/v1/users/${nid}`;
            axios.get(url)
            .then((response) => {
                blockUI.release();
                let data = response.data.data;
                let imageUrl = data.imageUrl?.replace('localhost', 'localhost:8000') || '#';

                ownerImage.style.backgroundImage = `url(${imageUrl})`;
                ownerNameBn.value = data.ownerNameBn;
                ownerName.value = data.ownerName;
                fatherNameBn.value = data.fatherNameBn;
                fatherName.value = data.fatherName;
                motherNameBn.value = data.motherNameBn;
                motherName.value = data.motherName;
                spouseNameBn.value = data.spouseNameBn;
                spouseName.value = data.spouseName;

                phone.value = data.phone;
                birthRegistrationNo.value = data.birthRegistrationNo;
                passportNo.value = data.passportNo;
                caHoldingNo.value = data.caHoldingNo;
                caRoadNo.value = data.caRoadNo;
                caPostCode.value = data.caPostCode;
                caVillageBn.value = data.caVillageBn;
                caVillage.value = data.caVillage;
                caPostOfficeBn.value = data.caPostOfficeBn;
                caPostOffice.value = data.caPostOffice;
                caDivisionBn.value = data.caDivisionBn;
                caDistrictBn.value = data.caDistrictBn;
                caUpazillaBn.value = data.caUpazillaBn;
                caUpazilla.value = data.caUpazilla;
                paHoldingNo.value = data.paHoldingNo;
                paRoadNo.value = data.paRoadNo;
                paPostCode.value = data.paPostCode;
                paVillageBn.value = data.paVillageBn;
                paVillage.value = data.paVillage;
                paPostOfficeBn.value = data.paPostOfficeBn;
                paPostOffice.value = data.paPostOffice;
                paDivisionBn.value = data.paDivisionBn;
                paDistrictBn.value = data.paDistrictBn;
                paUpazillaBn.value = data.paUpazillaBn;
                paUpazilla.value = data.paUpazilla;

                formValidator.validate();

                autofillInputs.forEach((element) => {
                    if(element.value){
                        element.readOnly = true;
                    }
                });
                
            })
            .catch((error) => {
                blockUI.release();
                ownerImage.style = '';
                ownerNameBn.value = '';
                ownerName.value = '';
                fatherNameBn.value = '';
                fatherName.value = '';
                motherNameBn.value = '';
                motherName.value = '';
                spouseNameBn.value = '';
                spouseName.value = '';
                phone.value = '';
                birthRegistrationNo.value = '';
                passportNo.value = '';
                caHoldingNo.value = '';
                caRoadNo.value = '';
                caPostCode.value = '';
                caVillageBn.value = '';
                caVillage.value = '';
                caPostOfficeBn.value = '';
                caPostOffice.value = '';
                caDivisionBn.value = '';
                caDistrictBn.value = '';
                caUpazillaBn.value = '';
                caUpazilla.value = '';
                paHoldingNo.value = '';
                paRoadNo.value = '';
                paPostCode.value = '';
                paVillageBn.value = '';
                paVillage.value = '';
                paPostOfficeBn.value = '';
                paPostOffice.value = '';
                paDivisionBn.value = '';
                paDistrictBn.value = '';
                paUpazillaBn.value = '';
                paUpazilla.value = '';

                autofillInputs.forEach((element) => {
                    element.readOnly = false;
                });
            });
        }
    } 

    ['national_id_no', 'birth_registration_no', 'passport_no'].forEach((name) => {
        const element = document.querySelector(`[name="${name}"]`);
        element.addEventListener('input', () => {
            const validator = formValidator;
            validator.revalidateField('national_id_no');
            validator.revalidateField('birth_registration_no');
            validator.revalidateField('passport_no');
        });
    });
</script>
@endsection

