@extends('user.layouts.app')
<!--begin::Page Title-->
@section('title')
<title>{{ $application->business_organization_name_bn }} - আবেদন সংশোধন</title>
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
                    আবেদন সংশোধন
                </h2>
                <!--end::Title-->
                <ol class="breadcrumb text-muted fs-6 fw-normal">
                    <li class="breadcrumb-item"><a href="{{ route('user.trade_license_applications') }}" class="">আবেদন সমূহ</a></li>
                    <li class="breadcrumb-item text-muted">আবেদন</li>
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
        <form class="card-body form" action="{{ route('user.trade_license_applications.correction', $application->id) }}" method="POST" enctype="multipart/form-data" id="tl_application_form">
            @csrf
            @method('PATCH')

            @if($application->latest_activity?->message)
            <!--begin::Alert-->
            <div class="alert alert-dismissible alert-primary d-flex flex-column flex-sm-row p-5 mb-10">
                <!--begin::Icon-->
                <i class="fab fa-facebook-messenger fs-2hx text-primary me-4 mb-5 mb-sm-0"></i>
                <!--end::Icon-->

                <!--begin::Wrapper-->
                <div class="d-flex flex-column pe-0 pe-sm-10">
                    <!--begin::Title-->
                    <h5 class="mb-1 text-primary font-bn fs-4">কর্মকর্তার মন্তব্য</h5>
                    <!--end::Title-->

                    <!--begin::Content-->
                    <span class="font-kohinoor fs-5">{{ $application->latest_activity?->message }}</span>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Close-->
                <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                    <i class="fal fa-times fs-1 text-primary"></i>
                </button>
                <!--end::Close-->
            </div>
            <!--end::Alert-->
            @endif

            <input type="text" name="fiscal_year" value="{{ date('Y').'-'.(date('Y')+1) }}" readonly required hidden>
            <input type="hidden" name="application_id" value="{{ $application->id }}">
            @php
                $needsCorrection = array_key_exists('image', $application->corrections ?? []);
            @endphp

            @if($needsCorrection)
            <!--begin::Input group-->
            <div class="fv-row mb-4">
                <!--begin::Label-->
                <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} cursor-pointer fw-semibold mb-4">
                    <span>
                        <span @class(['required'])>আবেদনকারীর ছবি</span>
                        <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['image']['message'] ?? 'আবেদনকারীর ছবি সংশোধন প্রয়োজন'}}"></i>
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
                        <div class="image-input-wrapper w-125px h-125px border border-gray-300 shadow-none" style="background-image: url('{{ str_replace('localhost', 'localhost:'.env('LOCAL_PORT'), $application->getFirstMediaUrl('owner_image')) }}')"></div>
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
                                required
                                @readonly(!$needsCorrection)
                                />
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
            @endif

            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('owner_name_bn', $application->corrections ?? []);
                @endphp
                @if ($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} cursor-pointer fw-semibold mb-2">
                            <span @class(['text-danger' => $needsCorrection]) required>মালিক/স্বত্বাধিকারীর নাম (বাংলা)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['owner_name_bn']['message'] ?? 'মালিক/স্বত্বাধিকারীর নামে সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-user fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="owner_name_bn" value="{{ $application->owner_name_bn }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('owner_name_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('owner_name', $application->corrections ?? []);
                @endphp

                @if ($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} cursor-pointer fw-semibold mb-2">
                            <span @class(['required'])>মালিক/স্বত্বাধিকারীর নাম (ইংরেজি)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['owner_name']['message'] ?? 'মালিক/স্বত্বাধিকারীর ইংরেজি নামে সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-user fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="owner_name" value="{{ $application->owner_name }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('owner_name')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('father_name_bn', $application->corrections ?? []);
                @endphp
                @if ($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} cursor-pointer fw-semibold mb-2">
                            <span @class(['required'])>পিতার নাম (বাংলা)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['father_name_bn']['message'] ?? 'পিতার নামে সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-{{ COMMON_ICON }} fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="father_name_bn" value="{{ $application->father_name_bn }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('father_name_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
                
                @php
                    $needsCorrection = array_key_exists('father_name', $application->corrections ?? []);
                @endphp
                @if ($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} cursor-pointer fw-semibold mb-2">
                            <span @class(['required'])>পিতার নাম (ইংরেজি)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['father_name']['message'] ?? 'পিতার ইংরেজি নামে সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-{{ COMMON_ICON }} fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="father_name" value="{{ $application->father_name }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('father_name')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('mother_name_bn', $application->corrections ?? []);
                @endphp
                @if ($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} cursor-pointer fw-semibold mb-2">
                            <span @class(['required'])>মাতার নাম (বাংলা)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['mother_name_bn']['message'] ?? 'মাতার নামে সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-{{ COMMON_ICON }} fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="mother_name_bn" value="{{ $application->mother_name_bn }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('mother_name_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('mother_name', $application->corrections ?? []);
                @endphp
                @if ($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} cursor-pointer fw-semibold mb-2">
                            <span @class(['required'])>মাতার নাম (ইংরেজি)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['mother_name']['message'] ?? 'মাতার ইংরেজি নামে সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-{{ COMMON_ICON }} fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="mother_name" value="{{ $application->mother_name }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('mother_name')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('spouse_name_bn', $application->corrections ?? []);
                @endphp
                @if ($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} cursor-pointer fw-semibold mb-2">
                            <span @class(['required'])>স্বামী বা স্ত্রীর নাম (বাংলা)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['spouse_name_bn']['message'] ?? 'স্বামী বা স্ত্রীর নামে সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-{{ COMMON_ICON }} fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="spouse_name_bn" value="{{ $application->spouse_name_bn }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('spouse_name_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('spouse_name', $application->corrections ?? []);
                @endphp
                @if ($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} cursor-pointer fw-semibold mb-2">
                            <span @class(['required'])>স্বামী বা স্ত্রীর নাম (ইংরেজি)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['spouse_name']['message'] ?? 'স্বামী বা স্ত্রীর ইংরেজি নামে সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-{{ COMMON_ICON }} fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="spouse_name" value="{{ $application->spouse_name }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('spouse_name')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
            </div>
            
            <div class="row row-cols-md-3 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('national_id_no', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>জাতীয় পরিচয়পত্র নং (NID)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['national_id_no']['message'] ?? 'জাতীয় পরিচয়পত্র নং সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-address-card fs-3"></i>
                            </div>
                            <input type="text" maxlength="17" pattern="/^[0-9]+$/" class="ls-2 font-roboto fw-normal form-control text-gray-900" name="national_id_no" value="{{ $application->national_id_no }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('national_id_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
                
                @php
                    $needsCorrection = array_key_exists('birth_registration_no', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>অথবা, জন্ম নিবন্ধন নং</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['birth_registration_no']['message'] ?? 'জন্ম নিবন্ধন নং সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-address-card fs-3"></i>
                            </div>
                            <input type="text" maxlength="17" class="ls-2 font-roboto fw-normal form-control text-gray-900" name="birth_registration_no" value="{{ $application->birth_registration_no }}" required @readonly(!$needsCorrection)/> 
                        </div>
                        <!--end::Input-->
                        @error('birth_registration_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
                
                @php
                    $needsCorrection = array_key_exists('passport_no', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>অথবা, পাসপোর্ট নং</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['passport_no']['message'] ?? 'পাসপোর্ট নং সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-address-card fs-3"></i>
                            </div>
                            <input type="text"  maxlength="9" class="ls-2 font-roboto fw-normal form-control text-gray-900" name="passport_no" value="{{ $application->passport_no }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('passport_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
            </div>

            {{-- <div class="separator separator-content my-15">
                <span class="w-200px text-gray-600
                 fs-5 fw-semibold">
                    ব্যবসা প্রতিষ্ঠানের তথ্য
                </span>
            </div> --}}

            <div class="row row-cols-md-2 row-cols-1">
                {{-- <div class="col">
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
                            <input type="text" class="form-control text-gray-900" placeholder="" name="business_organization_name_bn" value="{{ $application->business_organization_name_bn }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('business_organization_name_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div> --}}
                @php
                    $needsCorrection = array_key_exists('business_organization_name_bn', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>ব্যবসা প্রতিষ্ঠানের নাম (বাংলা)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['business_organization_name_bn']['message'] ?? 'ব্যবসা প্রতিষ্ঠানের নামে সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-landmark fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="business_organization_name_bn" value="{{ $application->business_organization_name_bn }}" required @readonly(!$needsCorrection)/> 
                        </div>
                        <!--end::Input-->
                        @error('business_organization_name_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
                {{-- <div class="col">
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
                            <input type="text" class="form-control text-gray-900" placeholder="" name="business_organization_name" value="{{ $application->business_organization_name }}" required/> 
                        </div>
                        <!--end::Input-->
                        @error('business_organization_name')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div> --}}
                @php
                    $needsCorrection = array_key_exists('business_organization_name', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>ব্যবসা প্রতিষ্ঠানের নাম (ইংরেজি)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['business_organization_name']['message'] ?? 'ব্যবসা প্রতিষ্ঠানের নামে সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-landmark fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="business_organization_name" value="{{ $application->business_organization_name }}" required @readonly(!$needsCorrection)/> 
                        </div>
                        <!--end::Input-->
                        @error('business_organization_name')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('nature_of_business_bn', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} cursor-pointer fw-semibold mb-2">
                            <span @class(['required'])>ব্যবসার প্রকৃতি</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['nature_of_business_bn']['message'] ?? 'ব্যবসার প্রকৃতি নির্বাচন করুন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-{{ COMMON_ICON }} fs-3"></i>
                            </div>
                            <select type="text" class="form-control text-gray-900 form-select" placeholder name="nature_of_business_bn" value="{{ $application->nature_of_business_bn }}" required @readonly(!$needsCorrection)>
                                <option value="">ব্যবসার প্রকৃতি নির্বাচন করুন</option>
                                <option value="একক" @selected($application->nature_of_business_bn === 'একক')>একক</option>
                                <option value="যৌথ" @selected($application->nature_of_business_bn === 'যৌথ')>যৌথ</option>
                                <option value="অন্যান্য" @selected($application->nature_of_business_bn === 'অন্যান্য')>অন্যান্য</option>
                            </select> 
                        </div>
                        <!--end::Input-->
                    </div>
                    @error('nature_of_business_bn')
                    <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                    @enderror
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('business_starting_date', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} cursor-pointer fw-semibold mb-2">
                            <span @class(['required'])>ব্যবসা শুরুর তারিখ</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['business_starting_date']['message'] ?? 'ব্যবসা শুরুর তারিখ সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-calendar-star fs-3"></i>
                            </div>
                            <input type="date" class="form-control text-gray-900" placeholder name="business_starting_date" value="{{ Carbon\Carbon::parse($application->business_starting_date)->format('Y-m-d') }}" required @readonly(!$needsCorrection)/> 
                        </div>
                        <!--end::Input-->
                        @error('business_starting_date')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('address_of_business_organization_bn', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} cursor-pointer fw-semibold mb-2">
                            <span @class(['required'])>ব্যবসা প্রতিষ্ঠানের ঠিকানা (বাংলা)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['address_of_business_organization_bn']['message'] ?? 'ব্যবসা প্রতিষ্ঠানের ঠিকানা সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-location-dot fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="address_of_business_organization_bn" value="{{ $application->address_of_business_organization_bn }}" required @readonly(!$needsCorrection)/> 
                        </div>
                        <!--end::Input-->
                        @error('address_of_business_organization_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('address_of_business_organization', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} cursor-pointer fw-semibold mb-2">
                            <span @class(['required'])>ব্যবসা প্রতিষ্ঠানের ঠিকানা (ইংরেজি)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['address_of_business_organization']['message'] ?? 'ব্যবসা প্রতিষ্ঠানের ঠিকানা সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-location-dot fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="" name="address_of_business_organization" value="{{ $application->address_of_business_organization }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('address_of_business_organization')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
            </div>
            
            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('zone_bn', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>অঞ্চল (বাংলা)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['zone_bn']['message'] ?? 'অঞ্চল সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-location-dot fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="zone_bn" value="{{ $application->zone_bn }}" @readonly(!$needsCorrection)/> 
                        </div>
                        <!--end::Input-->
                        @error('zone_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('ward_no', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>ওয়ার্ড নং</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['ward_no']['message'] ?? 'ওয়ার্ড নির্বাচন করুন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group flex-nowrap">
                            <div class="input-group-text">
                                <i class="fal fa-location-dot fs-3"></i>
                            </div>
                            <div class="w-100">
                                <select type="text" class="form-control text-gray-900 form-select font-ador fw-light" name="ward_no" value="{{ $application->ward_no }}" required @readonly(!$needsCorrection)>
                                    <option value="">ওয়ার্ড নির্বাচন করুন</option>
                                    @for ($i = 1; $i <= 30; $i++)
                                        <option value="{{ $i }}" @selected($application->ward_no == $i)>{{ Helpers::convertToBanglaDigits($i) }}</option>
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
                @endif
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('tin_no', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>টি আই এন নং</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['tin_no']['message'] ?? 'টি আই এন নং সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fs-4">TIN</span>
                            </div>
                            <input type="text" class="font-roboto fw-normal ls-1 form-control text-gray-900" placeholder name="tin_no" value="{{ $application->tin_no }}" @readonly(!$needsCorrection)/> 
                        </div>
                        <!--end::Input-->
                        @error('tin_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('bin_no', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>বি আই এন নং</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['bin_no']['message'] ?? 'বি আই এন নং সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fs-4">BIN</span>
                            </div>
                            <input type="text" class="font-roboto fw-normal ls-1 form-control text-gray-900" placeholder name="bin_no" value="{{ $application->bin_no }}" @readonly(!$needsCorrection)/> 
                        </div>
                        <!--end::Input-->
                        @error('bin_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
            </div>

            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('phone_no', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>ফোন নম্বর</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['phone_no']['message'] ?? 'ফোন নম্বর সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fs-4">+88</span>
                            </div>
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" maxlength="11" placeholder name="phone_no" value="{{ $application->phone_no }}" required @readonly(!$needsCorrection)/> 
                        </div>
                        <!--end::Input-->
                        @error('phone_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('email', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>ই-মেইল ঠিকানা</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['email']['message'] ?? 'ই-মেইল ঠিকানা সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-envelope fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="email" value="{{ $application->email }}" @readonly(!$needsCorrection)/> 
                        </div>
                        <!--end::Input-->
                        @error('email')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
            </div>

            <div class="row row-cols-md-2 row-cols-1">
            </div>

            {{-- <div class="separator separator-content my-15">
                <span class="w-300px text-gray-600
                 fs-5 fw-semibold">
                    মালিক/স্বত্বাধিকারীর বর্তমান ঠিকানা
                </span>
            </div> --}}

            <!--Has: Holding No, Road No, Post Code-->
            <div class="row row-cols-md-3 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('ca_holding_no', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>হোল্ডিং নং</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['ca_holding_no']['message'] ?? 'হোল্ডিং নং সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-home fs-3"></i>
                            </div>
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="ca_holding_no" value="{{ $application->ca_holding_no }}" required @readonly(!$needsCorrection)/> 
                        </div>
                        <!--end::Input-->
                        @error('ca_holding_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('ca_road_no', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>রোড নং</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['ca_road_no']['message'] ?? 'রোড নং সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-road fs-3"></i>
                            </div>
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="ca_road_no" value="{{ $application->ca_road_no }}" @readonly(!$needsCorrection)/> 
                        </div>
                        <!--end::Input-->
                        @error('ca_road_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('ca_post_code', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>পোস্ট কোড</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['ca_post_code']['message'] ?? 'পোস্ট কোড সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-mailbox fs-3"></i>
                            </div>
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="ca_post_code" value="{{ $application->ca_post_code }}" @readonly(!$needsCorrection)/> 
                        </div>
                        <!--end::Input-->
                        @error('ca_post_code')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
            </div>
            
            <!--Has: vaillage_bn, village-->
            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('ca_village_bn', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>এলাকা/গ্রামের নাম (বাংলা)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['ca_village_bn']['message'] ?? 'এলাকা/গ্রামের নাম সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_village_bn" value="{{ $application->ca_village_bn }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('ca_village_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('ca_village', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>এলাকা/গ্রামের নাম (ইংরেজি)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['ca_village']['message'] ?? 'এলাকা/গ্রামের নাম সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_village" value="{{ $application->ca_village }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('ca_village')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endif
            </div>
            
            <!--Has: post_office_bn, post_office-->
            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('ca_post_office_bn', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>ডাকঘর (বাংলা)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['ca_post_office_bn']['message'] ?? 'ডাকঘর সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-mailbox fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_post_office_bn" value="{{ $application->ca_post_office_bn }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('ca_post_office_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('ca_post_office', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>ডাকঘর (ইংরেজি)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['ca_post_office']['message'] ?? 'ডাকঘর সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-mailbox fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_post_office" value="{{ $application->ca_post_office }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('ca_post_office')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
            </div>
            
            <!--Has: upazilla police, bn-->
            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('ca_division_bn', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="cursor-pointer fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>বিভাগ</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['ca_division_bn']['message'] ?? 'বিভাগ সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group flex-nowrap">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <select onchange="assignDistricts('caDivisionBn', 'caDistrictBn')" type="text" id="caDivisionBn" class="form-control form-select text-gray-900" placeholder name="ca_division_bn" value="{{ $application->ca_division_bn }}" required @readonly(!$needsCorrection)>
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
                @endif

                @php
                    $needsCorrection = array_key_exists('ca_district_bn', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="cursor-pointer fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>জেলা</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['ca_district_bn']['message'] ?? 'জেলা সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group flex-nowrap">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <select type="text" id="caDistrictBn" class="form-control text-gray-900" placeholder name="ca_district_bn" value="{{ $application->ca_district_bn }}" required @readonly(!$needsCorrection)>
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
                @endif
            </div>
            
            <!--Has: upazilla police, bn-->
            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('ca_upazilla_bn', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="cursor-pointer fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>উপজেলা/থানা (বাংলা)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['ca_upazilla_bn']['message'] ?? 'উপজেলা/থানা সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_upazilla_bn" value="{{ $application->ca_upazilla_bn }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('ca_upazilla_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('ca_upazilla', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="cursor-pointer fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>উপজেলা/থানা (ইংরেজি)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['ca_upazilla']['message'] ?? 'উপজেলা/থানা সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text required">
                                <i class="fal fa-mailbox fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="ca_upazilla" value="{{ $application->ca_upazilla }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('ca_upazilla')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
            </div>


            {{-- <div class="separator separator-content my-15">
                <span class="w-300px text-gray-600
                 fs-5 fw-semibold">
                    স্থায়ী ঠিকানা
                </span>
            </div> --}}

            {{-- <div class="form-check form-switch form-check-custom my-3">
                <input class="form-check-input h-20px w-30px" onchange="sameAsCa(this)" type="checkbox" id="sameAsCurrentAddress" name="same_as_current_address" value="1">
                <label class="form-check form-check-custom" for="sameAsCurrentAddress">
                    <span class="fs-6 fw-semibold text-primary ms-3 user-select-none">
                        বর্তমান ঠিকানার সাথে মিল আছে?
                    </span>
                </label>
            </div> --}}

            <!--Has: Holding No, Road No, Post Code-->
            <div class="row row-cols-md-3 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('pa_holding_no', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>হোল্ডিং নং</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['pa_holding_no']['message'] ?? 'হোল্ডিং নং সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-home fs-3"></i>
                            </div>
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="pa_holding_no" value="{{ $application->pa_holding_no }}" required @readonly(!$needsCorrection)/> 
                        </div>
                        <!--end::Input-->
                        @error('pa_holding_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('pa_road_no', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>রোড নং</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['pa_road_no']['message'] ?? 'রোড নং সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-road fs-3"></i>
                            </div>
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="pa_road_no" value="{{ $application->pa_road_no }}" @readonly(!$needsCorrection)/> 
                        </div>
                        <!--end::Input-->
                        @error('pa_road_no')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('pa_post_code', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>পোস্ট কোড</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['pa_post_code']['message'] ?? 'পোস্ট কোড সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-mailbox fs-3"></i>
                            </div>
                            <input type="text" class="font-roboto fw-normal form-control text-gray-900" placeholder name="pa_post_code" value="{{ $application->pa_post_code }}" @readonly(!$needsCorrection)/> 
                        </div>
                        <!--end::Input-->
                        @error('pa_post_code')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
            </div>
            
            <!--Has: vaillage_bn, village-->
            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('pa_village_bn', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>এলাকা/গ্রামের নাম (বাংলা)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['pa_village_bn']['message'] ?? 'এলাকা/গ্রামের নাম সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_village_bn" value="{{ $application->pa_village_bn }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('pa_village_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('pa_village', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>এলাকা/গ্রামের নাম (ইংরেজি)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['pa_village']['message'] ?? 'এলাকা/গ্রামের নাম সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_village" value="{{ $application->pa_village }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('pa_village')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endif
            </div>
            
            <!--Has: post_office_bn, post_office-->
            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('pa_post_office_bn', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>ডাকঘর (বাংলা)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['pa_post_office_bn']['message'] ?? 'ডাকঘর সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-mailbox fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_post_office_bn" value="{{ $application->pa_post_office_bn }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('pa_post_office_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('pa_post_office', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 cursor-pointer text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>ডাকঘর (ইংরেজি)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['pa_post_office']['message'] ?? 'ডাকঘর সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-mailbox fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_post_office" value="{{ $application->pa_post_office }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('pa_post_office')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
            </div>
            
            <!--Has: upazilla police, bn-->
            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('pa_division_bn', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="cursor-pointer fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>বিভাগ</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['pa_division_bn']['message'] ?? 'বিভাগ সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group flex-nowrap">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <select onchange="assignDistricts('caDivisionBn', 'caDistrictBn')" type="text" id="caDivisionBn" class="form-control form-select text-gray-900" placeholder name="pa_division_bn" value="{{ $application->pa_division_bn }}" required @readonly(!$needsCorrection)>
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
                        @error('pa_division_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('pa_district_bn', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="cursor-pointer fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>জেলা</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['pa_district_bn']['message'] ?? 'জেলা সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group flex-nowrap">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <select type="text" id="caDistrictBn" class="form-control text-gray-900" placeholder name="pa_district_bn" value="{{ $application->pa_district_bn }}" required @readonly(!$needsCorrection)>
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
                @endif
            </div>
            
            <!--Has: upazilla police, bn-->
            <div class="row row-cols-md-2 row-cols-1">
                @php
                    $needsCorrection = array_key_exists('pa_upazilla_bn', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="cursor-pointer fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>উপজেলা/থানা (বাংলা)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['pa_upazilla_bn']['message'] ?? 'উপজেলা/থানা সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-map-marked-alt fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_upazilla_bn" value="{{ $application->pa_upazilla_bn }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('pa_upazilla_bn')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif

                @php
                    $needsCorrection = array_key_exists('pa_upazilla', $application->corrections ?? []);
                @endphp
                @if($needsCorrection)
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="cursor-pointer fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                            <span @class(['required'])>উপজেলা/থানা (ইংরেজি)</span>
                            <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['pa_upazilla']['message'] ?? 'উপজেলা/থানা সংশোধন প্রয়োজন'}}"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text required">
                                <i class="fal fa-mailbox fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder name="pa_upazilla" value="{{ $application->pa_upazilla }}" required @readonly(!$needsCorrection)/>
                        </div>
                        <!--end::Input-->
                        @error('pa_upazilla')
                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->
                </div>
                @endif
            </div>
            
            {{-- <div class="separator separator-content my-15">
                <span class="w-300px text-gray-600
                 fs-5 fw-semibold">
                    আবেদনের সম্পর্কিত তথ্য
                </span>
            </div> --}}

            <input type="hidden" id="documentsInput" value="{{ json_encode($application->documents->pluck('trade_license_required_document_id')->toArray()) }}"/>
            @foreach ($application->documents->chunk(4) as $chunk)
                <div class="row">
                    @foreach ($chunk as $doc)

                    @php
                        $needsCorrection = array_key_exists('document-'.$doc->trade_license_required_document_id, $application->corrections ?? []);
                    @endphp
                    @if($needsCorrection)
                    <div class="col col-lg-3 col-md-4 col-12 mb-4 mb-md-0">
                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class="pb-2 pb-md-0 min-h-0 fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                                <span @class(['required'])>{{ $doc->document_name }}</span>
                                <i class="fab fa-facebook-messenger text-danger fs-4 ms-1" data-bs-toggle="tooltip" title="{{ $application->corrections['document-'.$doc->trade_license_required_document_id]['message'] ?? 'ডকুমেন্ট সংশোধন প্রয়োজন'}}"></i>
                            </label>
                            <!--end::Label-->
    
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline" data-kt-image-input="true">
                                <!--begin::Image preview wrapper-->
                                <a href="{{ str_replace('localhost', 'localhost:'.env('LOCAL_PORT'), $doc->getFirstMediaUrl('document')) }}" target="_blank" class="d-block image-input-wrapper w-200px h-250px position-relative" id="imageWrapper{{ $doc->trade_license_required_document_id }}" style="background-image: url({{ str_replace('localhost', 'localhost:'.env('LOCAL_PORT'), $doc->getFirstMediaUrl('document', 'document-preview')) }})"></a>
                                <!--end::Image preview wrapper-->
    
                                <!--begin::Edit button-->
                                <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-30px h-30px bg-body shadow"
                                data-kt-image-input-action="change"
                                data-bs-toggle="tooltip"
                                data-bs-dismiss="click"
                                title="পরিবর্তন করুন">
                                    <i class="far fa-cloud-arrow-up fs-6"></i>
    
                                    <!--begin::Inputs-->
                                    <input type="file" class="document_input" data-document-id="{{ $doc->trade_license_required_document_id }}" name="documents[{{ $doc->trade_license_required_document_id }}]" accept=".png, .jpg, .jpeg, .pdf" />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->
    
                                <!--begin::Cancel button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow document_cancel"
                                data-kt-image-input-action="cancel"
                                data-bs-toggle="tooltip"
                                data-bs-dismiss="click"
                                data-document-id="{{ $doc->trade_license_required_document_id }}"
                                id="cancelButton{{ $doc->trade_license_required_document_id }}"
                                title="বাতিল করুন">
                                    <i class="far fa-times fs-3"></i>
                                </span>
                                <!--end::Cancel button-->
                            </div>
                            <!--end::Image input-->
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            @endforeach

            <div class="d-flex justify-content-center mt-5">
                <!--begin::Button-->
                <button type="submit" id="tl_application_submit" class="btn btn-success ms-2">
                    <span class="indicator-label">
                        পুনরায় প্রেরণ করুন
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
<script src="{{ asset('assets/js/custom/user/tl-application/review.js') }}"></script>
@endsection

