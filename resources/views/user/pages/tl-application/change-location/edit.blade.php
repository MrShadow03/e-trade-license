@extends('user.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>{{ $application->business_organization_name_bn }} - আবেদন পরিবর্তন</title>
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
                    {{ $application->business_organization_name_bn }} - এর স্থানান্তর আবেদন
                </h2>
                <!--end::Title-->
                <ol class="breadcrumb text-muted fs-6 fw-normal">
                    <li class="breadcrumb-item"><a href="{{ route('user.trade_license_applications') }}" class="">আবেদন সমূহ</a></li>
                    <li class="breadcrumb-item text-muted">স্থানান্তর আবেদন</li>
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
        <form class="card-body form" action="{{ route('user.trade_license_applications.change_location.update', $application->id) }}" method="POST" enctype="multipart/form-data" id="form">
            @csrf
            @method('PATCH')
            <div class="row row-cols-md-2 row-cols-1">
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2 required">
                            নতুন ঠিকানা (বাংলা)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-location-dot fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="ঠিকানা" name="address_of_business_organization_bn" value="{{ old('address_of_business_organization_bn', $amendment?->data['address_of_business_organization_bn']) }}" required/> 
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
                            নতুন ঠিকানা (ইংরেজি)
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-location-dot fs-3"></i>
                            </div>
                            <input type="text" class="form-control text-gray-900" placeholder="Address" name="address_of_business_organization" value="{{ old('address_of_business_organization', $amendment?->data['address_of_business_organization']) }}" required/>
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
                            <input type="text" class="form-control text-gray-900" placeholder="অঞ্চল" name="zone_bn" value="{{ old("zone_bn", $amendment?->data['zone_bn']) }}" required/>
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
                                <select type="text" class="form-control text-gray-900 form-select font-ador fw-light" name="ward_no" required>
                                    <option value="">ওয়ার্ড নির্বাচন করুন</option>
                                    @for ($i = 1; $i <= 30; $i++)
                                        <option value="{{ $i }}" @selected($i == old('ward_no', $amendment?->data['ward_no']))>{{ Helpers::convertToBanglaDigits($i) }}</option>
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
                            <label class="pb-2 pb-md-0 min-h-lg-100px min-h-md-75px min-h-0 fs-6 text-gray-{{ LABEL_INTENSITY }} fw-semibold mb-2">
                                <span>
                                    <span class="required">ব্যবসা প্রতিষ্ঠান নিজ ঘরে হইলে হোল্ডিং ট্যাক্স এর ফটোকপি /ভাড়াটিয়া চুক্তিপত্র (কাউন্সিলর দ্বারা সত্যায়িত)</span>
                                </span>
                            </label>
                            <!--end::Label-->
    
                            
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline" data-kt-image-input="true">
                                <!--begin::Image preview wrapper-->
                                <div class="d-block image-input-wrapper w-200px h-250px position-relative" id="imageWrapper1" style="background: url({{ Helpers::getImageUrl($amendment, 'house-ownership-document', 'document-preview') }})">
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
                                    <input type="file" class="document_input" id="fileInput1" data-document-id="1" name="document" accept=".png, .jpg, .jpeg, .pdf" />
                                    <input type="hidden" name="avatar_remove" />
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
<script>
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

    const form = document.getElementById('form');
    var formValidator = FormValidation.formValidation(
        form,
        {
            fields: {
                'address_of_business_organization_bn': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
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
                                
                                var bengaliPattern = /^[\u0980-\u09FF\,\.\- ]+$/;

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
                'address_of_business_organization': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
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
                                
                                var englishPattern = /^[A-Za-z0-9\,\.\- ]+$/;

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
                'zone_bn': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
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
                                
                                var bengaliPattern = /^[\u0980-\u09FF\,\.\- ]+$/;

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
                'ward_no': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        }
                    }
                },
                'document': {
                    validators: {
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
                    eleValidClass: ''
                })
            }
        }
    );
    const formSubmitButton = document.getElementById('button');
    checkFormValidity(form, formValidator, formSubmitButton);
</script>
@endsection

