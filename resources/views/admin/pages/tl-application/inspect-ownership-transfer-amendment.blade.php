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
                    <form method="POST" action="{{ route('admin.trade_license_applications.amendment.approve_ownership_transfer', $application->id) }}" class="tab-pane fade show active" id="applicationCorrectionForm" role="tabpanel">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="isApproved">
                        <!--begin::Card-->
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>নতুন স্বত্বাধিকারীর তথ্য</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <div class="card-body">
                                <!--begin::Avatar-->
                                <div class="row mb-7">
                                    <div class="col-6">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="image" name="corrections[image][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[image][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="{{ INFO_LABEL_CLASSES }} label-image ms-3">স্বত্বাধিকারীর ছবি</div>
                                        </div>
                                        <div class="symbol symbol-150px border border-gray-500">
                                            <img src="{{ str_replace('localhost', 'localhost:'.env('LOCAL_PORT'), $amendment->getFirstMediaUrl('owner-image')) }}" alt="" class="object-fit-cover">
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="image_correction_message">
                                    </div>
                                </div>
                                <!--end::Avatar-->
                                <div class="row g-5 g-xl-8 mb-7">
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES }}">স্বত্বাধিকারীর নাম</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $amendment->data['name_bn'] ?? '' }}</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES_EN }}">Owner's Name</div>
                                        <div class="{{ INFO_CLASSES_EN }}">{{ $amendment->data['name'] ?? '' }}</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES }}">পিতার নাম</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $amendment->data['father_name_bn'] ?? '' }}</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES_EN }}">Father's Name</div>
                                        <div class="{{ INFO_CLASSES_EN }}">{{ $amendment->data['father_name'] ?? '' }}</div>
                                    </div>
                                </div> 
                                <div class="row g-5 g-xl-8 mb-7">
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES }}">মাতার নাম</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $amendment->data['mother_name_bn'] ?? '' }}</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES_EN }}">Mother's Name</div>
                                        <div class="{{ INFO_CLASSES_EN }}">{{ $amendment->data['mother_name'] ?? '' }}</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES }}">স্বামী/স্ত্রীর নাম</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $amendment->data['spouse_name_bn'] ?? '' }}</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES_EN }}">Spouse's Name</div>
                                        <div class="{{ INFO_CLASSES_EN }}">{{ $amendment->data['spouse_name'] ?? '' }}</div>
                                    </div>
                                </div> 
                                <div class="row g-5 g-xl-8">
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES }}">জাতীয় পরিচয়পত্র নং</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $amendment->data['national_id_no'] ?? '---' }}</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES }}">জন্ম নিবন্ধন নং</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $amendment->data['birth_certificate_no'] ?? '---' }}</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES }}">পাসপোর্ট নং</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $amendment->data['passport_no'] ?? '---' }}</div>
                                    </div>
                                </div> 
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
                                    <h2>স্বত্বাধিকারীর ঠিকানা</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="fw-bold fs-6">ক্ষেত্র</th>
                                            <th class="fw-bold fs-6">বর্তমান ঠিকানা</th>
                                            <th class="fw-bold fs-6">স্থায়ী ঠিকানা</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES }}">হোল্ডিং নং</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits($amendment->data['ca_holding_no'] ?? '---') }}</td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits($amendment->data['pa_holding_no'] ?? '---') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES }}">রোড নং</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits($amendment->data['ca_road_no'] ?? '---') }}</td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits($amendment->data['pa_road_no'] ?? '---') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES }}">পোস্ট কোড</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits($amendment->data['ca_post_code'] ?? '---') }}</td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits($amendment->data['pa_post_code'] ?? '---') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES }}">এলাকা/গ্রাম</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $amendment->data['ca_village_bn'] ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $amendment->data['pa_village_bn'] ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES_EN }}">Village</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $amendment->data['ca_village'] ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $amendment->data['pa_village'] ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES }}">ডাকঘর</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $amendment->data['ca_post_office_bn'] ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $amendment->data['pa_post_office_bn'] ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES_EN }}">Post Office</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $amendment->data['ca_post_office'] ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $amendment->data['pa_post_office'] ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES }}">বিভাগ</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $amendment->data['ca_division_bn'] ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $amendment->data['pa_division_bn'] ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES_EN }}">Division</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $amendment->data['ca_division'] ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $amendment->data['pa_division'] ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES }}">জেলা</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $amendment->data['ca_district_bn'] ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $amendment->data['pa_district_bn'] ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES_EN }}">District</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $amendment->data['ca_district'] ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $amendment->data['pa_district'] ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES }}">উপজেলা/থানা</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $amendment->data['ca_upazilla_bn'] ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $amendment->data['pa_upazilla_bn'] ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES_EN }}">Upazilla/Police Station</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $amendment->data['ca_upazilla'] ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $amendment->data['pa_upazilla'] ?? '---' }}</td>
                                        </tr>
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
                                <div class="row row-cols-1 row-cols-md-2 g-5 g-xl-8">
                                    <div class="col">
                                        <div class="min-h-100px min-h-md-50px fs-6 fw-bold required mb-4 label-document-1">নতুন স্বত্বাধিকারীর জাতীয় পরিচয় পত্র</div>
                                        <a href="{{ Helpers::getImageUrl($amendment, 'owner-national-id') }}" target="_blank" class="shadow p-2 d-block image-input-wrapper rounded w-200px h-250px position-relative" style="background-image: url({{ Helpers::getImageUrl($amendment, 'owner-national-id', 'document-preview') }}); background-position: 50% 0%; background-size: cover;">
                                            <i class="fs-3x border border-danger bg-white p-2 rounded position-absolute fas fa-file-pdf text-danger" aria-hidden="true" style="left: 15px; bottom: 15px;"></i>
                                        </a>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="document-1_correction_message">
                                    </div>
                                    <div class="col">
                                        <div class="min-h-100px min-h-md-50px fs-6 fw-bold required mb-4 label-document-1">স্বত্বাধিকার হস্থানন্তর দলিল</div>
                                        <a href="{{ Helpers::getImageUrl($amendment, 'ownership-transfer-deed') }}" target="_blank" class="shadow p-2 d-block image-input-wrapper rounded w-200px h-250px position-relative" style="background-image: url({{ Helpers::getImageUrl($amendment, 'ownership-transfer-deed', 'document-preview') }}); background-position: 50% 0%; background-size: cover;">
                                            <i class="fs-3x border border-danger bg-white p-2 rounded position-absolute fas fa-file-pdf text-danger" aria-hidden="true" style="left: 15px; bottom: 15px;"></i>
                                        </a>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="document-2_correction_message">
                                    </div>
                                </div>
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
