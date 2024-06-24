@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>{{ $application->owner_name_bn }} এর আবেদন পত্র</title>
@endsection
<!--end::Page Title-->

<!--begin::Page Custom Styles(used by this page)-->
@section('exclusive_styles')
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('/assets/plugins/global/select2.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/plugins/global/swal2.css') }}" rel="stylesheet" type="text/css">
    <!--end::Vendor Stylesheets-->
    <style>
        tbody.hide-child {
            display: none;
        }

        .image-input-placeholder {
            background-image: url('{{ asset('assets/admin/assets/media/svg/avatars/blank.svg') }}');
        }

        [data-bs-theme="dark"] .image-input-placeholder {
            background-image: url('{{ asset('assets/admin/assets/media/svg/avatars/blank-dark.svg') }}');
        }
        .timeline-icon{
            margin-left: 3px;
        }
        :root {
            --label-color-light: #6D28D9;
            --label-color-dark: #A78BFA;
            --label-color-light-en: #DB2777;
            --label-color-dark-en: #F0ABFC;
        }
        .text-label {
            color: var(--label-color-light);
        }
        [data-bs-theme="dark"] .text-label {
            color: var(--label-color-dark);
        }
        .text-label-en {
            color: var(--label-color-light-en);
        }
        [data-bs-theme="dark"] .text-label-en {
            color: var(--label-color-dark-en);
        }
    </style>
@endsection
<!--end::Page Custom Styles-->
@php
    const PENDING_STATE_THEME = 'danger';
    const TIMELINE_NEGATIVE_GAP = 'mb-n8';
    const TIMELINE_GAP = 'mb-4';
    const INFO_LABEL_CLASSES = 'fw-bold text-primary fs-6';
    const INFO_CLASSES = 'fs-4 text-dark fw-medium font-kohinoor';
    const INFO_LABEL_CLASSES_EN = 'fw-bold text-primary fs-6 font-roboto';
    const INFO_CLASSES_EN = 'fs-4 text-dark font-roboto';
    const MSG_INPUT_CLASSES = 'mt-4 fs-5 text-danger border-danger font-kohinoor form-control form-control-sm d-none';
@endphp
<!--begin::Main Content-->
@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl mt-7 font-bn">
        <div class="card card-flush pb-0 bgi-position-y-center bgi-no-repeat mb-10 mt-5">
            <!--begin::Card header-->
            <div class="card-header pt-10">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div class="d-flex align-items-center">
                        <!--begin::Icon-->
                        <div class="symbol symbol-circle me-5">
                            <div class="symbol-label bg-transparent text-success border border-success border-dashed">
                                <i class="fal fa-file-invoice fs-2x text-success">
                                </i>                
                            </div>
                        </div>
                        <!--end::Icon-->
        
                        <!--begin::Title-->
                        <div class="d-flex flex-column">
                            <h2 class="font-ador fw-normal">
                                {{ $application->business_organization_name_bn }} এর আবেদন পত্র
                            </h2>
                            {{-- <div class="text-gray-800 fs-5 fw-normal font-ador">
                                আবেদনের তারিখ: {{ Helpers::convertToBanglaDigits(Carbon\Carbon::parse($application->created_at)->locale('bn-BD')->translatedFormat('d F Y'))}}
                            </div> --}}
                            <ol class="breadcrumb text-muted fs-6 fw-semibold">
                                <li class="breadcrumb-item"><a href="{{ route('admin.trade_license_applications') }}" class="">আবেদন সমূহ</a></li>
                                <li class="breadcrumb-item text-muted">আবেদন</li>
                            </ol>                            
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
        <div class="d-flex flex-column flex-xl-row">
            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">

                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Card body-->
                    <div class="card-body pt-15">
                        <!--begin::Summary-->
                        <div class="d-flex flex-center flex-column mb-5">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-150px symbol-circle mb-7">
                                <img src="{{ Helpers::getImageUrl($application, 'owner_image') }}" alt="" class="object-fit-cover">
                            </div>
                            <!--end::Avatar-->

                            <!--begin::Name-->
                            <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">{{ $application->user?->name_bn }}</a>
                            <!--end::Name-->

                            <!--begin::Email-->
                            @if ($application->user?->phone)
                            <a href="#" class="fs-5 fw-semibold text-muted text-hover-primary mb-6">{{ $application->business_organization_name_bn }}</a>
                            @endif
                            <!--end::Email-->
                        </div>
                        <!--end::Summary-->

                        <!--begin::Details toggle-->
                        <div class="d-flex flex-stack fs-4 py-3">
                            <div class="fw-bold">
                                তথ্যাবলী
                            </div>

                            <!--begin::Badge-->
                            <div class="badge badge-light-info d-inline"></div>
                            <!--begin::Badge-->
                        </div>
                        <!--end::Details toggle-->

                        <div class="separator separator-dashed my-3"></div>
                        
                        <!--begin::Details content-->
                        <div class="pb-5 fs-6">
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">National ID</div>
                            <div class="text-gray-600">{{ $application->user?->national_id_no }}</div>
                            <!--begin::Details item-->
                            {{-- <!--begin::Details item-->
                            <div class="fw-bold mt-5">Position</div>
                            <div class="text-gray-600">{{ ucfirst($application->user?->designation ?? '') }}</div>
                            <!--begin::Details item--> --}}
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">ই-মেইল</div>
                            <div class="text-gray-600"><a href="#"
                                    class="text-gray-600 text-hover-primary">{{ $application->user?->email }}</a></div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">ফোন নম্বর</div>
                            <div class="text-gray-600">{{ $application->user?->phone ?? '' }}</div>
                            <!--begin::Details item-->
                        </div>
                        <!--end::Details content-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-0 ms-lg-15">
                {{-- <!--begin:::Tabs-->
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 active" id="settingsTabButton" data-bs-toggle="tab"
                            href="#customer_general">General Settings</a>
                    </li>
                    <!--end:::Tab item-->
                </ul>
                <!--end:::Tabs--> --}}

                <!--begin:::Tab content-->
                <div class="tab-content" id="tabContent">
                    <!--begin:::Tab pane-->
                    <form method="POST" action="{{ route('admin.trade_license_applications.amendment.approve_relocation', $application->id) }}" class="tab-pane fade show active" id="applicationCorrectionForm" role="tabpanel">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="isApproved">
                        <!--begin::Card-->
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>সংশোধন আবেদন</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <div class="card-body pt-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="fw-bold fs-6"></th>
                                            <th class="fw-bold fs-6">পূর্বের</th>
                                            <th class="fw-bold fs-6">সংশোধিত</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($amendment?->data)
                                        @foreach ($amendment->data as $key => $value)
                                        <tr>
                                            <td class="py-1">
                                                <span class="fw-semibold">{{ Helpers::formatTableField($key) }}</span>
                                            </td>
                                            <td class="py-1 text-danger">{{ $application->{$key} }}</td>
                                            <td class="py-1 text-success-emphasis">{{ $value }}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::Card-->

                        <!--begin::Card-->
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>নথি সমূহ</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <div class="card-body pt-0">
                                @if($amendment->type == 'relocation')
                                <div class="row row-cols-1 row-cols-md-2 g-5 g-xl-8">
                                    <div class="col">
                                        <div class="min-h-100px min-h-md-50px fs-6 fw-bold required mb-4 label-document-1">ব্যবসা প্রতিষ্ঠান নিজ ঘরে হইলে হোল্ডিং ট্যাক্স এর ফটোকপি /ভাড়াটিয়া চুক্তিপত্র (কাউন্সিলর দ্বারা সত্যায়িত)</div>
                                        <a href="{{ Helpers::getImageUrl($amendment, 'house-ownership-document') }}" target="_blank" class="shadow p-2 d-block image-input-wrapper rounded w-200px h-250px position-relative" style="background-image: url({{ Helpers::getImageUrl($amendment, 'house-ownership-document', 'thumb') }}); background-position: 50% 0%; background-size: cover;">
                                            <i class="fs-3x border border-danger bg-white p-2 rounded position-absolute fas fa-file-pdf text-danger" aria-hidden="true" style="left: 15px; bottom: 15px;"></i>
                                        </a>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="document-1_correction_message">
                                    </div>
                                </div>
                                @endif
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::Card-->
                        <!--begin::Card-->
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <div class="card-body">
                                <div class="row row-cols-1 mb-4">
                                    <div class="col">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-4">
                                            <!--begin::Label-->
                                            <label class="fs-6 text-gray-900 fw-bold mb-2">
                                                আপনার মন্তব্য
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea class="form-control font-kohinoor fs-4" name="message" rows="3" placeholder="সম্পূর্ন আবেদনের মন্তব্য লিখুন (যদি কোন পরিবর্তন থাকে তাহলে)" required></textarea>
                                            <!--end::Input-->
                                        </div>
                                        @error('type_of_business_bn')
                                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <!--end::Input group-->
                                    </div>
                                </div>
                                <div class="text-end d-flex justify-content-between">
                                    <button type="button" class="btn btn-danger" id="rejectButton" onclick="submitForm(event, 0, this)">
                                        <span class="indicator-label">
                                            প্রত্যাখ্যান করুন
                                        </span>
                                        <span class="indicator-progress">
                                            অপেক্ষা করুন...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>

                                    @if (auth()->user()->can('issue-renewed-trade-license') && $application->canBeRenewed())
                                    <button type="button" class="btn btn-success ms-3" onclick="submitForm(event, 1, this)">
                                        <span class="indicator-label">
                                            লাইসেন্স নবায়ন করুন
                                        </span>
                                        <span class="indicator-progress">
                                            অপেক্ষা করুন...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                    @elseif (auth()->user()->can('issue-trade-license'))
                                    <button type="button" class="btn btn-success ms-3" onclick="submitForm(event, 1, this)">
                                        <span class="indicator-label">
                                            লাইসেন্স প্রদান করুন
                                        </span>
                                        <span class="indicator-progress">
                                            অপেক্ষা করুন...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-success ms-3" onclick="submitForm(event, 1, this)">
                                        <span class="indicator-label">
                                            নিশ্চিত করুন
                                        </span>
                                        <span class="indicator-progress">
                                            অপেক্ষা করুন...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                    @endif
                                </div>
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::Card-->
                    </form>
                    <!--end:::Tab pane-->
                </div>
                <!--end:::Tab content-->
            </div>
            <!--end::Content-->
        </div>
    </div>

@endsection
<!--end::Main Content-->

@section('exclusive_scripts')

    <script>

        const form = document.getElementById('applicationCorrectionForm');

        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'message': {
                        validators: {
                            notEmpty: {
                                message: 'অবশ্যই প্রদান করতে হবে'
                            },
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

        const toggleMessage = (el) => {
            const message = document.getElementById(el.dataset.fieldName + '_correction_message');
            const label = document.querySelector(`.label-${el.dataset.fieldName}`);
            const checkbox = document.querySelector(`input[name="corrections[${el.dataset.fieldName}][isCorrected]"]`);

            message.classList.toggle('d-none');
            label.classList.toggle('text-danger');
            // Set value to empty string
            if (!el.checked) {
                el.value = '';
                message.value = '';
                checkbox.checked = false;
            }else {
                checkbox.checked = true;
            }

        }

        const setMessage = (el) => {
            const checkbox = document.querySelector(`input[name="corrections[${el.id.replace('_correction_message', '')}][message]"]`);
            checkbox.value = el.value;
        }

        $(document).ready(function() {
            $('[name="business_category_id"]').select2({
                placeholder: "ব্যবসার ধরন নির্বাচন করুন",
                allowClear: true
            });
            $('[name="signboard_id"]').select2();
        });

        const submitForm = (event, isApproved, button) => {
            event.preventDefault();
            const form = event.target.closest('form');
            
            if (isApproved) {
                form.querySelector('input[name="isApproved"]').value = 1;

                // Show loading indication
                button.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                button.disabled = true;

                Swal.fire({
                    title: `অনুমোদন করতে চান?`,
                    text: "আবেদনটিকে পরবর্তী ধাপে প্রেরণ করা হবে।",
                    icon: "info",
                    iconHtml: '<i class="fas fa-file-check fs-2x text-success"></i>',
                    showCancelButton: true,
                    cancelButtonText: 'না',
                    confirmButtonText: "হ্যাঁ, অনুমোদন করুন!",
                    customClass: {
                        icon: 'border-success',
                        confirmButton: "btn btn-success font-bn order-2",
                        cancelButton: 'btn btn-secondary font-bn order-1 right-gap',
                        title: "font-bn",
                        container: "font-bn",
                    }
                }).then(function(result) {
                    if (result.value) {
                        form.submit();
                    }else{
                        button.removeAttribute('data-kt-indicator');
                        button.disabled = false;
                    }
                });

            } else {
                form.querySelector('input[name="isApproved"]').value = 0;
                if (validator) {
                    validator.validate().then(function (status) {
                        if (status == 'Valid') {
                            // Show loading indication
                            button.setAttribute('data-kt-indicator', 'on');

                            // Disable button to avoid multiple click
                            button.disabled = true;

                            Swal.fire({
                                title: `প্রত্যাখ্যান করতে চান?`,
                                text: "আবেদনটিকে পুনরায় পর্যালোচনার জন্য প্রেরণ করা হবে।",
                                icon: "error",
                                iconHtml: '<i class="fas fa-file-xmark fs-2x text-danger"></i>',
                                showCancelButton: true,
                                cancelButtonText: 'না',
                                confirmButtonText: "হ্যাঁ, প্রত্যাখ্যান করুন!",
                                customClass: {
                                    confirmButton: "btn btn-danger font-bn order-2",
                                    cancelButton: 'btn btn-secondary font-bn order-1 right-gap',
                                    title: "font-bn",
                                    container: "font-bn",
                                }
                            }).then(function(result) {
                                if (result.value) {
                                    form.submit();
                                }else{
                                    button.removeAttribute('data-kt-indicator');
                                    button.disabled = false;
                                }
                            });
                        }
                    })
                }
            }
        }
    </script>
    
@endsection
