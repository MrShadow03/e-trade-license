@extends('user.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>নতুন ট্রেড লাইসেন্স আবেদন | BCC - E-Trade License</title>
@endsection
<!--end::Page Title-->
@section('exclusive_styles')
<link href="{{ asset('/assets/plugins/global/select2.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('/assets/plugins/global/swal2.css') }}" rel="stylesheet" type="text/css">
<style>
    .form label {
        font-size: 14px !important;
    }
    .form input, .form select {
        font-size: 15px !important;
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
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0 font-bn">
                    নতুন ট্রেড লাইসেন্স আবেদন
                </h1>
                <!--end::Title-->
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
        <form class="card-body form" action="{{ route('user.trade_license_applications.store') }}" method="POST" enctype="multipart/form-data" id="tl_application_form">
            @csrf
            <!--begin::Input group-->
            <div class="fv-row mb-4">
                <!--begin::Label-->
                <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                    <span>
                        <span class="required">আবেদনকারীর ছবি</span>
                    </span>
                </label>
                <!--end::Label-->

                <!--begin::Image input wrapper-->
                <div class="mt-1">
                    <!--begin::Image input placeholder-->
                    <!--begin::Image input-->
                    <div class="image-input image-input-outline image-input-placeholder"
                        data-kt-image-input="true">
                        <!--begin::Preview existing avatar-->
                        <div class="image-input-wrapper w-125px h-125px border border-gray-300 shadow-none"></div>
                        <!--end::Preview existing avatar-->
                        @php
                            $oldImage = Session::getOldInput('image');
                        @endphp
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
                                value="{{ $oldImage }}"
                                required/>
                            <!--end::Inputs-->
                        </label>
                        <!--end::Edit-->
                    </div>
                    <div class="form-text text-gray-700">
                        পাসপোর্ট সাইজের ছবি আপলোড করুন <br>
                        ছবির সাইজ সর্বোচ্চ ২০০ কিলোবাইট হতে পারে <br>
                        ফরমেট: jpg, jpeg, png
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
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            মালিক/স্বত্বাধিকারীর নাম (বাংলা)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-user fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="owner_name_bn" value="{{ old('owner_name_bn') }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('owner_name_bn')
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
                            <input type="text" class="form-control text-gray-900" placeholder="" name="owner_name" value="{{ old('owner_name') }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('owner_name')
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
                            <input type="text" class="form-control text-gray-900" placeholder name="father_name_bn" value="{{ old('father_name_bn') }}" required/>
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
                            <input type="text" class="form-control text-gray-900" placeholder="" name="father_name" value="{{ old('father_name') }}" required/> 
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
                            <input type="text" class="form-control text-gray-900" placeholder name="mother_name_bn" value="{{ old('mother_name_bn') }}" required/>
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
                            <input type="text" class="form-control text-gray-900" placeholder="" name="mother_name" value="{{ old('mother_name') }}" required/>
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
                            <input type="text" class="form-control text-gray-900" placeholder name="spouse_name_bn" value="{{ old('spouse_name_bn') }}"/> 
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
                            <input type="text" class="form-control text-gray-900" placeholder="" name="spouse_name" value="{{ old('spouse_name') }}"/>
                        </div>
                        <!--end::Input-->
                        @error('spouse_name')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            
            <div class="row row-cols-md-3 row-cols-1">
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
                            <input type="text" maxlength="17" pattern="/^[0-9]+$/" class="ls-2 font-roboto fw-normal form-control text-gray-900" name="national_id_no" value="{{ old('national_id_no') }}"/>
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
                            অথবা, জন্ম নিবন্ধন নং
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-address-card fs-3"></i>
                            </div>
                            <input type="text" maxlength="17" class="ls-2 font-roboto fw-normal form-control text-gray-900" name="birth_registration_no" value="{{ old('birth_registration_no') }}"/> 
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
                            অথবা, পাসপোর্ট নং
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-address-card fs-3"></i>
                            </div>
                            <input type="text"  maxlength="9" class="ls-2 font-roboto fw-normal form-control text-gray-900" name="passport_no" value="{{ old('passport_no') }}"/>
                        </div>
                        <!--end::Input-->
                        @error('passport_no')
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
                        @error('nature_of_business_bn')
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
                            ব্যবসার ধরন/লাইসেন্স ফি
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group flex-nowrap">
                            <div class="input-group-text">
                                <i class="fal fa-{{ COMMON_ICON }} fs-3"></i>
                            </div>
                            <select type="text" class="form-control text-gray-900 form-select" name="business_category_id" value="{{ old('business_category_id') }}" required>
                                <option value="">ব্যবসার ধরন নির্বাচন করুন</option>
                                @foreach ($businessCategories as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('business_category_id') == $cat->id) >{{ $cat->name_bn }} - {{ Helpers::convertToBanglaDigits(number_format(round($cat->fee), 0, ',')) }} টাকা</option>
                                @endforeach
                            </select> 
                        </div>
                        <!--end::Input-->
                        @error('type_of_business_bn')
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
                            <select type="text" class="form-control text-gray-900 form-select font-ador fw-light" name="ward_no" value="{{ old('ward_no') }}" required>
                                @for ($i = 1; $i <= 30; $i++)
                                    <option value="{{ $i }}">{{ Helpers::convertToBanglaDigits($i) }}</option>
                                @endfor
                            </select>
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
                            অর্থবছর
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group flex-nowrap">
                            <div class="input-group-text">
                                <i class="fal fa-calendars fs-3"></i>
                            </div>
                            <select type="text" class="form-control text-gray-900 form-select font-ador fw-light" data-select2-disable-search name="fiscal_year" value="{{ old('fiscal_year') }}" required>
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}-{{ $i+1 }}">{{ Helpers::convertToBanglaDigits($i) }}-{{ Helpers::convertToBanglaDigits($i+1) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <!--end::Input-->
                        @error('fiscal_year')
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
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="ca_holding_no" value="{{ old('ca_holding_no') }}" required/> 
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
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="ca_road_no" value="{{ old('ca_road_no') }}"/> 
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
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="ca_post_code" value="{{ old('ca_post_code') }}"/> 
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
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_village_bn" value="{{ old('ca_village_bn') }}" required/> 
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
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_village" value="{{ old('ca_village') }}" required/> 
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
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_post_office_bn" value="{{ old('ca_post_office_bn') }}" required/> 
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
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_post_office" value="{{ old('ca_post_office') }}" required/> 
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
                            <select onchange="assignDistricts('caDivisionBn', 'caDistrictBn')" type="text" id="caDivisionBn" class="form-control form-select text-gray-900" placeholder name="ca_division_bn" value="{{ old('ca_division_bn') }}" required>
                                <option value="বরিশাল" @selected(old('ca_division_bn') === 'বরিশাল') >বরিশাল</option>
                                <option value="ঢাকা" @selected(old('ca_division_bn') === 'ঢাকা') >ঢাকা</option>
                                <option value="খুলনা" @selected(old('ca_division_bn') === 'খুলনা') >খুলনা</option>
                                <option value="রাজশাহী" @selected(old('ca_division_bn') === 'রাজশাহী') >রাজশাহী</option>
                                <option value="সিলেট" @selected(old('ca_division_bn') === 'সিলেট') >সিলেট</option>
                                <option value="ময়মনসিংহ" @selected(old('ca_division_bn') === 'ময়মনসিংহ') >ময়মনসিংহ</option>
                                <option value="রংপুর" @selected(old('ca_division_bn') === 'রংপুর') >রংপুর</option>
                                <option value="চট্টগ্রাম" @selected(old('ca_division_bn') === 'চট্টগ্রাম') >চট্টগ্রাম</option>
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
                            <select type="text" id="caDistrictBn" class="form-control text-gray-900" placeholder name="ca_district_bn" value="{{ old('ca_district_bn') }}" required>
                                @foreach ($districts as $district)
                                    <option value="{{ $district }}" @selected(old('ca_district_bn') === $district) >{{ $district }}</option>
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
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_upazilla_bn" value="{{ old('ca_upazilla_bn') }}" required/> 
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
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_upazilla" value="{{ old('ca_upazilla') }}" required/> 
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
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="pa_holding_no" value="{{ old('pa_holding_no') }}" required/> 
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
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="pa_road_no" value="{{ old('pa_road_no') }}"/> 
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
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="pa_post_code" value="{{ old('pa_post_code') }}"/> 
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
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_village_bn" value="{{ old('pa_village_bn') }}" required/> 
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
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_village" value="{{ old('pa_village') }}" required/> 
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
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_post_office_bn" value="{{ old('pa_post_office_bn') }}" required/> 
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
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_post_office" value="{{ old('pa_post_office') }}" required/> 
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
                            <select onchange="assignDistricts('paDivisionBn', 'paDistrictBn')" type="text" id="paDivisionBn" class="form-control form-select text-gray-900" placeholder name="pa_division_bn" value="{{ old('pa_division_bn') }}" required>
                                <option value="বরিশাল" @selected(old('pa_division_bn') === 'বরিশাল') >বরিশাল</option>
                                <option value="ঢাকা" @selected(old('pa_division_bn') === 'ঢাকা') >ঢাকা</option>
                                <option value="খুলনা" @selected(old('pa_division_bn') === 'খুলনা') >খুলনা</option>
                                <option value="রাজশাহী" @selected(old('pa_division_bn') === 'রাজশাহী') >রাজশাহী</option>
                                <option value="সিলেট" @selected(old('pa_division_bn') === 'সিলেট') >সিলেট</option>
                                <option value="ময়মনসিংহ" @selected(old('pa_division_bn') === 'ময়মনসিংহ') >ময়মনসিংহ</option>
                                <option value="রংপুর" @selected(old('pa_division_bn') === 'রংপুর') >রংপুর</option>
                                <option value="চট্টগ্রাম" @selected(old('pa_division_bn') === 'চট্টগ্রাম') >চট্টগ্রাম</option>
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
                            <select type="text" id="paDistrictBn" class="form-control text-gray-900" placeholder name="pa_district_bn" value="{{ old('pa_district_bn') }}" required>
                                @foreach ($districts as $district)
                                    <option value="{{ $district }}" @selected(old('pa_district_bn') === $district) >{{ $district }}</option>
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
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_upazilla_bn" value="{{ old('pa_upazilla_bn') }}" required/> 
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
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_upazilla" value="{{ old('pa_upazilla') }}" required/> 
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
                <span class="w-300px text-gray-600
                 fs-5 fw-semibold">
                    আবেদনের সম্পর্কিত তথ্য
                </span>
            </div>

            <input type="hidden" id="documentsInput" value="{{ json_encode($requiredDocuments->pluck('id')->toArray()) }}"/>
            @foreach ($requiredDocuments as $doc)
                <div class="row row-cols-1">
                    <div class="col">
                        <!--begin::Input group-->
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                                {{ $doc->document_name }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="fal fa-file-pdf fs-3"></i>
                                </div>
                                <input 
                                type="file" 
                                class="form-control file_input text-gray-900" 
                                placeholder name="documents[{{ $doc->id }}]"
                                accept=".pdf,.jpg,.jpeg,.png,.doc"
                                value="{{ old('documents.'.$doc->id) }}"
                                required/> 
                            </div>
                            <!--end::Input-->
                            @error('documents.'.$doc->id)
                            <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--end::Input group-->
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-center mt-5">
                <!--begin::Button-->
                <button type="submit" id="tl_application_submit" class="btn btn-success ms-2">
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
<script src="{{ asset('assets/js/custom/user/tl-application/create.js') }}"></script>
@endsection

