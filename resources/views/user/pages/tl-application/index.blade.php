@extends('user.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>আবেদন সমূহ</title>
@endsection
<!--end::Page Title-->

@section('exclusive_styles')
<link href="{{ asset('/assets/plugins/global/swal2.css') }}" rel="stylesheet" type="text/css">
@endsection

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
                        <div class="symbol-label bg-transparent text-success border border-success border-dashed">
                            <i class="fal fa-file-invoice fs-2x text-success">
                            </i>                
                        </div>
                    </div>
                    <!--end::Icon-->
    
                    <!--begin::Title-->
                    <div class="d-flex flex-column">
                        <h2 class="font-ador fw-normal">
                            আমার আবেদন সমূহ
                        </h2>
                        <div class="text-gray-800 fs-5 fw-semibold font-kohinoor">
                            মোট আবেদন সংখ্যা: {{ Helpers::convertToBanglaDigits($applications->count()) }} টি
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
    <div class="card card-flush mb-10">
        <!--begin::Card header-->
        <div class="card-header pt-8 border-bottom">
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="fal fa-search fs-3 position-absolute ms-6"></i>
                    <input type="text" data-application-table-filter="search" class="form-control w-250px ps-15 font-bn" placeholder="আবেদন সার্চ করুন" />
                </div>
                <!--end::Search--> 
            </div>
    
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-filemanager-table-toolbar="base">
                    <!--begin::Category-->
                    <a class="btn btn-flex btn-success" href="{{ route('user.trade_license_applications.create') }}">
                        <i class="ki-outline ki-plus-circle fs-6 me-1"></i>
                        নতুন আবেদন
                    </a>
                    <!--end::Category--> 
                </div>
                <!--end::Toolbar-->       
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body">        
            <!--begin::Table-->
            <table id="kt_file_manager_list" data-kt-filemanager-table="files" class="table align-middle table-row-dashed fs-6 gy-5 font-bn">
                <thead class="border-bottom">
                    <tr class="text-start text-gray-700 fw-semibold fs-6 text-uppercase gs-0">
                        {{-- <th class="">স্বত্বাধিকারী</th> --}}
                        <th class="">প্রতিষ্ঠান</th>
                        <th class="">সর্বশেষ অবস্থা</th>
                        <th class="text-start">করনীয়</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600 font-kohinoor">
                    @foreach($applications as $application)
                    @php
                        $data = Helpers::convertTlStatusToBangla($application->status);
                    @endphp
                    <tr>
                        <td class="py-2 {{ $loop->first ? 'pt-4' : '' }}">
                            <div class="d-flex align-items-center">
                                <!--begin::Symbol-->
                                <a href="{{ route('admin.trade_license_applications.show', $application->id) }}" class="symbol symbol-50px me-5">
                                    <img src="{{ str_replace('localhost', 'localhost:'.env('LOCAL_PORT'), $application->getFirstMediaUrl('owner_image', 'thumb')) }}" alt="">
                                </a>
                                <!--end::Symbol-->

                                <!--begin::Text-->
                                <div class="d-flex flex-column">
                                    <a href="{{ route('admin.trade_license_applications.show', $application->id) }}" class="text-dark text-hover-primary fs-5 fw-bold d-block font-bn">{{ $application->business_organization_name_bn }}</a>
                                    <span class="text-gray-600 fs-7 mt-1">{{ Helpers::convertToBanglaDigits(Carbon\Carbon::parse($application->created_at)->locale('bn-BD')->diffForHumans())}}</span>
                                </div>
                                <!--end::Text-->
                            </div>
                        </td>
                        <td class="py-2">
                            <div class="d-flex align-items-center">
                                {{-- <span class="badge badge-square badge-{{ $data['theme'] }}">
                                    <i class="far {{ $data['icon'] }} fs-6 text-light"></i>
                                </span> --}}
                                
                                <div class="d-flex align-items-center">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-50px me-5">
                                        <span class="symbol-label bg-light-{{ $data['theme'] }} border border-{{ $data['theme'] }} border-dashed">
                                            <i class="fas {{ $data['icon'] }} fs-2x text-{{ $data['theme'] }}"></i>
                                        </span>
                                    </div>
                                    <!--end::Symbol-->
                                    
                                    <!--begin::Text-->
                                    <div class="d-flex flex-column">
                                        <span class="text-{{ $data['theme'] }} fs-5 font-bn">{!! $data['msg_bn'] !!}</span>
                                        <span class="text-gray-600 fs-7 mt-1">{{ Helpers::convertToBanglaDigits(Carbon\Carbon::parse($application->updated_at)->locale('bn-BD')->diffForHumans())}}</span>
                                    </div>
                                    <!--end::Text-->
                                </div>
                            </div>
                        </td>
                        <td class="text-start py-1" data-kt-filemanager-table="action_dropdown">
                            <div class="d-flex justify-content-start">

                                @if ($application->isValid())
                                <a href="{{ route('trade-license', $application->uuid) }}" class="btn btn-success btn-icon btn-sm me-1" data-bs-toggle="tooltip" title="ট্রেড লাইসেন্স দেখুন" target="_blank">
                                    <i class="fal fa-print fs-4"></i>
                                </a>
                                @endif

                                @if (Helpers::needsApplicationCorrection($application->status))
                                <a href="{{ route('user.trade_license_applications.review', $application->id) }}" class="btn btn-danger btn-icon btn-sm me-1" data-bs-toggle="tooltip" title="ভুল তথ্য সংশোধন করুন">
                                    <i class="fal fa-warning fs-4"></i>
                                </a>
                                @endif

                                @php
                                    $fees = [
                                        'licenseFee' => number_format(round($application->new_application_fee), 0, ','),
                                        'signboardFee' => number_format(round($application->signboard_fee), 0, ','),
                                        'incomeTax' => number_format(round($application->incomeTaxAmount), 0, ','),
                                        'vat' => number_format(round($application->vatAmount), 0, ','),
                                        'total' => number_format($application->new_application_fee + $application->signboard_fee + $application->incomeTaxAmount + $application->vatAmount, 0, ','),
                                        'totalInBangla' => Helpers::numToBanglaWords($application->new_application_fee + $application->signboard_fee + $application->incomeTaxAmount + $application->vatAmount),
                                        'id' => $application->id
                                    ]
                                @endphp

                                @if ($application->status === Helpers::PENDING_LICENSE_FEE_PAYMENT || $application->status === Helpers::DENIED_LICENSE_FEE_VERIFICATION)
                                <a href="#" class="btn btn-primary btn-icon btn-sm me-1" data-bs-toggle="modal" data-bs-target="#license_fee_payment_modal" data-bs-toggle="tooltip" title="লাইসেন্স ফি পরিশোধ করুন" onclick="displayLicenseForm({{ json_encode($fees) }})">
                                    <i class="far fa-bangladeshi-taka-sign fs-4"></i>
                                </a>
                                @endif

                                @if ($application->status === Helpers::PENDING_FORM_FEE_PAYMENT || $application->status === Helpers::DENIED_FORM_FEE_VERIFICATION)
                                <a href="#" class="btn btn-success btn-icon btn-sm me-1 pulse pulse-warning" data-bs-toggle="modal" data-bs-target="#form_fee_payment_modal" data-bs-toggle="tooltip" title="ফর্ম ফি পরিশোধ করুন" onclick="document.getElementById('applicationId').value = '{{ $application->id }}'">
                                    <i class="far fa-bangladeshi-taka-sign fs-4"></i>
                                    <span class="pulse-ring"></span>
                                </a>
                                @endif

                                @php
                                    $renewalFees = [
                                        'licenseFee' => number_format(round($application->new_application_fee), 0, ','),
                                        'signboardFee' => number_format(round($application->signboard_fee), 0, ','),
                                        'incomeTax' => number_format(round($application->incomeTaxAmount), 0, ','),
                                        'vat' => number_format(round($application->vatAmount), 0, ','),
                                        'surcharge' => number_format(round($application->surcharge_amount), 0, ','),
                                        'arrear' => number_format(round($application->arrear_amount), 0, ','),
                                        'total' => number_format($application->total_license_renewal_fee, 0, ','),
                                        'totalInBangla' => Helpers::numToBanglaWords($application->total_license_renewal_fee),
                                        'arrearStartYear' => Helpers::getFiscalYear($application->issued_at),
                                        'arrearEndYear' => Helpers::getFiscalYear(Carbon\Carbon::now()->subYear()->format('Y-m-d')),
                                        'id' => $application->id
                                    ]
                                @endphp
                                @if($application->status === Helpers::EXPIRED || $application->status === Helpers::PENDING_LICENSE_RENEWAL_FEE_PAYMENT || $application->status === Helpers::DENIED_LICENSE_RENEWAL_FEE_VERIFICATION)
                                <a href="#" class="btn btn-info btn-icon btn-sm me-1" data-bs-toggle="modal" data-bs-target="#license_renewal_fee_payment_modal" title="নবায়ন করুন" onclick="displayRenewalForm({{ json_encode($renewalFees) }})">
                                    <i class="fal fa-rotate-exclamation fs-4"></i>
                                </a>
                                @endif

                                
                                @if ($application->latest_activity?->message)
                                <button onclick="showMessage(`{{ ($application->latest_activity?->message) }}`)"  class="btn btn-warning btn-icon btn-sm me-1 pulse pulse-warning" data-bs-toggle="tooltip" title="{{ $application->latest_activity?->message }}">
                                    <i class="fas fa-bell-ring fs-4"></i>
                                    <span class="pulse-ring"></span>
                                </button>
                                @endif

                                <a href="{{ route('user.trade_license_applications.show', $application->id) }}" class="btn btn-light-info btn-icon btn-sm me-1" data-bs-toggle="tooltip" title="বিস্তারিত দেখুন">
                                    <i class="fal fa-eye fs-4"></i>
                                </a>

                                @if ($application->status === Helpers::PENDING_FORM_FEE_PAYMENT)
                                <a href="{{ route('user.trade_license_applications.edit', $application->id) }}" class="btn btn-light-info btn-icon btn-sm me-1" data-bs-toggle="tooltip" title="তথ্য পরিবর্তন করুন">
                                    <i class="fal fa-edit fs-4"></i>
                                </a>
                                <form action="{{ route('user.trade_license_applications.destroy', $application->id) }}" method="POST" onclick="submitForm(this, event, '{{ $application->business_organization_name_bn }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light-danger btn-icon btn-sm me-1" data-bs-toggle="tooltip" title="আবেদনটি বাতিল করুন">
                                        <i class="fal fa-trash-can fs-4"></i>
                                    </button>
                                </form>
                                @endif

                                <!--begin::Menu-->
                                <button type="button" class="btn btn-sm btn-icon btn-light-primary ms-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="fas fa-ellipsis-v fs-6"></i>
                                </button>
                                
                                <!--begin::Menu 2-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column pb-3 menu-rounded menu-gray-800 menu-state-bg-light-primary font-bn fw-semibold w-250px" data-kt-menu="true" style="">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">আরও করুন</div>
                                    </div>
                                    <!--end::Menu item-->
                                
                                    <!--begin::Menu separator-->
                                    <div class="separator mb-3 opacity-75"></div>
                                    <!--end::Menu separator-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">
                                            <span class="menu-icon">
                                                <i class="fal fa-history fs-2"></i>
                                            </span>
                                            <span class="menu-title">আবেদনটির ইতিহাস</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                
                                    @if($application->status === Helpers::ISSUED)
                                    @if(!$application->hasActiveAmendment())
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="{{ route('user.trade_license_applications.change_location', $application->id) }}" class="menu-link px-3">
                                            <span class="menu-icon">
                                                <i class="fal fa-location-dot fs-2"></i>
                                            </span>
                                            <span class="menu-title">স্থান পরিবর্তন আবেদন</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="{{ route('user.trade_license_applications.change_ownership', $application->id) }}" class="menu-link px-3">
                                            <span class="menu-icon">
                                                <i class="fal fa-user fs-2"></i>
                                            </span>
                                            <span class="menu-title">মালিকানা পরিবর্তন আবেদন</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    @endif

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">
                                            <span class="menu-icon">
                                                <i class="fal fa-globe fs-2"></i>
                                            </span>
                                            <span class="menu-title">ইংরেজি ট্রেড লাইসেন্স</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link bg-hover-light-danger px-3">
                                            <span class="menu-icon">
                                                <i class="fal fa-file-slash fs-2 text-danger"></i>
                                            </span>
                                            <span class="menu-title text-danger">লাইসেন্স বাতিল করুন</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    @endif
                                </div>
                                <!--end::Menu 2-->
                                <!--end::Menu-->
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
</div>
@endsection
<!--end::Main Content-->

@section('exclusive_modals')
<div class="modal fade" id="form_fee_payment_modal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered min-w-lg-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <!--begin::Modal header-->
            <div class="modal-header border-0 justify-content-between bg-light-dark">
                <!--begin::Heading-->
                <div class="text-center">
                   <!--begin::Title-->
                   <h3 class="text-gray-800 fw-semibold fs-2 font-bn fw-normal">
                        ফর্ম ফি পরিশোধ করুন
                   </h3>
                   <!--end::Title-->
               </div>
               <!--end::Heading-->
               <!--begin::Close-->
               <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                   <i class="fa fa-times fs-1" aria-hidden="true"></i>
               </div>
               <!--end::Close-->
           </div>
           <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y m-5 font-bn">
                <!--begin::Stepper-->
                <div class="stepper stepper-pills" id="form_fee_payment_stepper">
                    <!--begin::Nav-->
                    <div class="stepper-nav flex-center flex-wrap mb-10 d-none d-md-flex">
                        <!--begin::Step 1-->
                        <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number font-kohinoor">১</span>
                                </div>
                                <!--end::Icon-->
                    
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        পরিমান
                                    </h3>
                    
                                    <div class="stepper-desc font-kohinoor">
                                        {{ Helpers::convertToBanglaDigits(number_format($form_fee, 0, ',')) }} টাকা
                                    </div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                    
                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step 1-->
                    
                        <!--begin::Step 2-->
                        <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number font-kohinoor">২</span>
                                </div>
                                <!--begin::Icon-->
                    
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        মাধ্যম
                                    </h3>

                                    <div class="stepper-desc">
                                        নগদ/অনলাইন
                                    </div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                    
                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step 2-->
                    
                        <!--begin::Step 3-->
                        <div class="stepper-item mark-completed mx-8 my-4" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number font-kohinoor">৩</span>
                                </div>
                                <!--begin::Icon-->
                    
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        নগদ পরিশোধ
                                    </h3>
                    
                                    <div class="stepper-desc">
                                        ব্যাংক ড্রাফট
                                    </div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                    
                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step 3-->
                    </div>
                    <!--end::Nav-->
                    
                    <!--begin::Form-->
                    <form action="{{ route('user.trade_license_applications.payments.form_fee.store') }}" method="POST" enctype="multipart/form-data" class="form mx-auto font-kohinoor" novalidate="novalidate" id="form_fee_payment_stepper_form">
                        @csrf
                        @method('POST')

                        <input type="hidden" name="id" id="applicationId" required>
                        <!--begin::Group-->
                        <div class="mb-5">
                            <!--begin::Step 1-->
                            <div class="flex-column current" data-kt-stepper-element="content">
                                <div class="row mb-md-8 mb-2 font-hind-siliguri">
                                    <table class="table table-striped table-row-dashed table-row-gray-300 gy-7">
                                        <thead>
                                            <tr class="fw-semibold fs-6 text-gray-800">
                                                <th class="py-2 px-2">ক্ষেত্র</th>
                                                <th class="py-2 px-2 text-end">টাকার পরিমাণ</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fs-5">
                                            <tr>
                                                <td class="py-2 px-2">ফর্ম ফি</td>
                                                <td class="py-2 px-2 text-end">{{ Helpers::convertToBanglaDigits(number_format($form_fee, 0, ',')) }} টাকা</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 fs-3 fw-semibold">মোট</td>
                                                <td class="py-2 px-2 fs-3 text-end fw-semibold text-danger">{{ Helpers::convertToBanglaDigits(number_format($form_fee, 0, ',')) }} টাকা</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--begin::Step 1-->

                            <!--begin::Step 1-->
                            <div class="flex-column mb-15" data-kt-stepper-element="content">
                                <button type="button" class="btn btn-flex btn-info px-6 justify-between" id="manualPaymentButton">
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-hand-holding-circle-dollar fs-2x me-2"></i>
                                            <span class="d-flex flex-column align-items-start ms-2">
                                                <span class="fs-3 fw-semibold font-bn">
                                                    নগদ পরিশোধ
                                                </span>
                                                <span class="fs-7 fw-normal opacity-75">
                                                    নগদ পরিশোধের ব্যাংক ড্রাফট প্রদান করুন
                                                </span>
                                            </span>
                                        </div>
                                        <i class="fal fa-chevron-right fs-1"></i>
                                    </div>
                                </button>
                                <a href="javascript:void(0))" class="btn btn-flex btn-danger mt-4 px-6">
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        <div class="d-flex align-items-center">
                                            <i class="fab fa-cc-visa fs-2x me-2"></i>
                                            <span class="d-flex flex-column align-items-start ms-2">
                                                <span class="fs-3 fw-semibold font-bn">
                                                    অনলাইন পেমেন্ট
                                                </span>
                                                <span class="fs-7 fw-normal opacity-75">
                                                    শীঘ্রই আসছে...
                                                </span>
                                            </span>
                                        </div>
                                        <i class="fal fa-external-link fs-1"></i>
                                    </div>
                                </a>
                            </div>
                            <!--begin::Step 1-->

                            <!--begin::Step 1-->
                            <div class="flex-column mb-15" data-kt-stepper-element="content">
                                <div class="fv-row mb-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 text-gray-700 fw-semibold mb-2 required">
                                        ব্যাংকের নাম
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="fal fa-landmark fs-3"></i>
                                        </div>
                                        <input type="text" class="form-control text-gray-900" placeholder="" list="bankList" name="bank" value="{{ old('bank') }}" required/>
                                        <datalist id="bankList">
                                            <option value="সোনালী ব্যাংক লিমিটেড">
                                            <option value="অগ্রণী ব্যাংক লিমিটেড">
                                            <option value="ব্র্যাক ব্যাংক লিমিটেড">
                                    </div>
                                    <!--end::Input-->
                                    @error('bank')
                                    <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="fv-row mb-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 text-gray-700 fw-semibold mb-2 required">
                                        শাখা
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="fal fa-landmark fs-3"></i>
                                        </div>
                                        <input type="text" class="form-control text-gray-900" placeholder="" name="bank_branch" value="{{ old('bank_branch') }}" required/> 
                                    </div>
                                    <!--end::Input-->
                                    @error('bank_branch')
                                    <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="fv-row mb-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 text-gray-700 fw-semibold mb-2 required">
                                        চালান নম্বর
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="fal fa-file-invoice fs-3"></i>
                                        </div>
                                        <input type="text" class="form-control text-gray-900" placeholder="" name="bank_invoice_no" value="{{ old('bank_invoice_no') }}" required/> 
                                    </div>
                                    <!--end::Input-->
                                    @error('bank_invoice_no')
                                    <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!--begin::Image input wrapper-->
                                <div class="fv-row">
                                    <div class="mb-4">
                                        <p class="fs-6 fw-semibold font-kohinoor">আপনার ব্যাংক ড্রাফট এখানে আপলোড করুন</p>
                                    </div>
                                    <!--begin::Image input placeholder-->
                                    <!--begin::Image input-->
                                    <div class="image-input image-input-outline image-input-placeholder"
                                        data-kt-image-input="true">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-150px h-125px"
                                        style="background-image: url({{ asset('assets/img/blank-image.svg') }}); background-position: center;"
                                        ></div>
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
                                                accept=".png, .jpg, .jpeg, .pdf"
                                                required/>
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Edit-->
                                    </div>
                                    <div class="form-text fs-6 text-gray-700">
                                        <div class="d-flex flex-column">
                                            <li class="d-flex align-items-center">
                                                <span class="bullet bullet-dot bg-success"></span> &nbsp; সাইজ সর্বোচ্চ ২ মেগাবাইট
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <span class="bullet bullet-dot bg-danger"></span> &nbsp; ফরমেট: jpg, jpeg, png, pdf
                                            </li>
                                        </div>                       
                                    </div>
                                </div>
                                <!--end::Image input wrapper-->
                            </div>
                            <!--begin::Step 1-->
                        </div>
                        <!--end::Group-->

                        <!--begin::Actions-->
                        <div class="d-flex flex-stack">
                            <!--begin::Wrapper-->
                            <div class="me-2">
                                <button type="button" class="btn btn-light text-hover-danger btn-active-light-danger btn-flex" data-kt-stepper-action="previous">
                                    <i class="far fa-chevron-left" aria-hidden="true"></i>&nbsp;  পূর্বে যান
                                </button>
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Wrapper-->
                            <div>
                                <button type="submit" class="btn btn-success" id="formPaymentSubmit" data-kt-stepper-action="submit">
                                    <span class="indicator-label">
                                        দাখিল করুন &nbsp; <i class="far fa-check" aria-hidden="true"></i>
                                    </span>
                                    <span class="indicator-progress">
                                        দাখিল করা হচ্ছে... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                
                                <button type="button" class="btn btn-success" data-kt-stepper-action="next">
                                    এগিয়ে যান &nbsp; <i class="far fa-chevron-right" aria-hidden="true"></i>
                                </button>
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Stepper-->
            </div>
            <!--begin::Modal body-->
        </div>
    </div>
</div>
<div class="modal fade" id="license_fee_payment_modal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered min-w-lg-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <!--begin::Modal header-->
            <div class="modal-header border-0 justify-content-between bg-light-dark">
                <!--begin::Heading-->
                <div class="text-center">
                   <!--begin::Title-->
                   <h3 class="text-gray-800 fw-semibold fs-2 font-bn fw-normal">
                        লাইসেন্স ফি পরিশোধ করুন
                   </h3>
                   <!--end::Title-->
               </div>
               <!--end::Heading-->
               <!--begin::Close-->
               <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                   <i class="fa fa-times fs-1" aria-hidden="true"></i>
               </div>
               <!--end::Close-->
           </div>
           <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y m-5 font-bn">
                <!--begin::Stepper-->
                <div class="stepper stepper-pills" id="license_fee_payment_stepper">
                    <!--begin::Nav-->
                    <div class="stepper-nav flex-center flex-wrap mb-10 d-none d-md-flex">
                        <!--begin::Step 1-->
                        <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number font-kohinoor">১</span>
                                </div>
                                <!--end::Icon-->
                    
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        পরিমান
                                    </h3>
                    
                                    <div class="stepper-desc font-kohinoor" id="totalAmountModalSub">
                                        {{ Helpers::convertToBanglaDigits(number_format($form_fee, 0, ',')) }} টাকা
                                    </div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                    
                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step 1-->
                    
                        <!--begin::Step 2-->
                        <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number font-kohinoor">২</span>
                                </div>
                                <!--begin::Icon-->
                    
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        মাধ্যম
                                    </h3>

                                    <div class="stepper-desc">
                                        নগদ/অনলাইন
                                    </div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                    
                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step 2-->
                    
                        <!--begin::Step 3-->
                        <div class="stepper-item mark-completed mx-8 my-4" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number font-kohinoor">৩</span>
                                </div>
                                <!--begin::Icon-->
                    
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        নগদ পরিশোধ
                                    </h3>
                    
                                    <div class="stepper-desc">
                                        ব্যাংক ড্রাফট
                                    </div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                    
                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step 3-->
                    </div>
                    <!--end::Nav-->
                    
                    <!--begin::Form-->
                    <form action="{{ route('user.trade_license_applications.payments.license_fee.store') }}" method="POST" enctype="multipart/form-data" class="form mx-auto font-kohinoor" novalidate="novalidate" id="license_fee_payment_stepper_form">
                        @csrf
                        @method('POST')

                        <input type="hidden" name="id" id="applicationIdLicenseFee" required>
                        <!--begin::Group-->
                        <div class="mb-5">
                            <!--begin::Step 1-->
                            <div class="flex-column current" data-kt-stepper-element="content">
                                <div class="row mb-md-8 mb-2 font-hind-siliguri">
                                    <table class="table table-striped table-row-dashed table-row-gray-300 gy-7">
                                        <thead>
                                            <tr class="fw-semibold fs-6 text-gray-800">
                                                <th class="py-2 px-2">ক্ষেত্র</th>
                                                <th class="py-2 px-2 text-end">টাকার পরিমাণ (৳)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fs-5">
                                            <tr>
                                                <td class="py-2 px-2">নতুন লাইসেন্স ফি</td>
                                                <td class="py-2 px-2 text-end" id="displayLicenseFee"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2">সাইনবোর্ড ফি</td>
                                                <td class="py-2 px-2 text-end" id="displaySignboardFee"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2">আয়কর</td>
                                                <td class="py-2 px-2 text-end" id="displayIncomeTax"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2">ভ্যাট</td>
                                                <td class="py-2 px-2 text-end" id="displayVat"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 fs-4 fw-semibold">মোট</td>
                                                <td class="py-2 px-2 fs-4 text-end fw-semibold text-danger" id="displayTotalFee"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 fs-4 fw-semibold">মোট (কথায়)</td>
                                                <td class="py-2 px-2 fs-4 text-end fw-semibold text-danger" id="displayTotalFeeInBangla"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--begin::Step 1-->

                            <!--begin::Step 1-->
                            <div class="flex-column mb-15" data-kt-stepper-element="content">
                                <button type="button" class="btn btn-flex btn-info px-6 justify-between" id="licenseFeeManualPaymentButton">
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-hand-holding-circle-dollar fs-2x me-2"></i>
                                            <span class="d-flex flex-column align-items-start ms-2">
                                                <span class="fs-3 fw-semibold font-bn">
                                                    নগদ পরিশোধ
                                                </span>
                                                <span class="fs-7 fw-normal opacity-75">
                                                    নগদ পরিশোধের ব্যাংক ড্রাফট প্রদান করুন
                                                </span>
                                            </span>
                                        </div>
                                        <i class="fal fa-chevron-right fs-1"></i>
                                    </div>
                                </button>
                                <a href="javascript:void(0))" class="btn btn-flex btn-danger mt-4 px-6">
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        <div class="d-flex align-items-center">
                                            <i class="fab fa-cc-visa fs-2x me-2"></i>
                                            <span class="d-flex flex-column align-items-start ms-2">
                                                <span class="fs-3 fw-semibold font-bn">
                                                    অনলাইন পেমেন্ট
                                                </span>
                                                <span class="fs-7 fw-normal opacity-75">
                                                    শীঘ্রই আসছে...
                                                </span>
                                            </span>
                                        </div>
                                        <i class="fal fa-external-link fs-1"></i>
                                    </div>
                                </a>
                            </div>
                            <!--begin::Step 1-->

                            <!--begin::Step 1-->
                            <div class="flex-column mb-15" data-kt-stepper-element="content">
                                <div class="fv-row mb-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 text-gray-700 fw-semibold mb-2 required">
                                        ব্যাংকের নাম
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="fal fa-landmark fs-3"></i>
                                        </div>
                                        <input type="text" class="form-control text-gray-900" placeholder="" list="bankList" name="bank" value="{{ old('bank') }}" required/>
                                        <datalist id="bankList">
                                            <option value="সোনালী ব্যাংক লিমিটেড">
                                            <option value="অগ্রণী ব্যাংক লিমিটেড">
                                            <option value="ব্র্যাক ব্যাংক লিমিটেড">
                                    </div>
                                    <!--end::Input-->
                                    @error('bank')
                                    <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="fv-row mb-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 text-gray-700 fw-semibold mb-2 required">
                                        শাখা
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="fal fa-landmark fs-3"></i>
                                        </div>
                                        <input type="text" class="form-control text-gray-900" placeholder="" name="bank_branch" value="{{ old('bank_branch') }}" required/> 
                                    </div>
                                    <!--end::Input-->
                                    @error('bank_branch')
                                    <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="fv-row mb-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 text-gray-700 fw-semibold mb-2 required">
                                        চালান নম্বর
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="fal fa-file-invoice fs-3"></i>
                                        </div>
                                        <input type="text" class="form-control text-gray-900" placeholder="" name="bank_invoice_no" value="{{ old('bank_invoice_no') }}" required/> 
                                    </div>
                                    <!--end::Input-->
                                    @error('bank_invoice_no')
                                    <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!--begin::Image input wrapper-->
                                <div class="fv-row">
                                    <div class="mb-4">
                                        <p class="fs-6 fw-semibold font-kohinoor">আপনার ব্যাংক ড্রাফট এখানে আপলোড করুন</p>
                                    </div>
                                    <!--begin::Image input placeholder-->
                                    <!--begin::Image input-->
                                    <div class="image-input image-input-outline image-input-placeholder"
                                        data-kt-image-input="true">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-150px h-125px"
                                        style="background-image: url({{ asset('assets/img/blank-image.svg') }}); background-position: center;"
                                        ></div>
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
                                                accept=".png, .jpg, .jpeg, .pdf"
                                                required/>
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Edit-->
                                    </div>
                                    <div class="form-text fs-6 text-gray-700">
                                        <div class="d-flex flex-column">
                                            <li class="d-flex align-items-center">
                                                <span class="bullet bullet-dot bg-success"></span> &nbsp; সাইজ সর্বোচ্চ ২ মেগাবাইট
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <span class="bullet bullet-dot bg-danger"></span> &nbsp; ফরমেট: jpg, jpeg, png, pdf
                                            </li>
                                        </div>                       
                                    </div>
                                </div>
                                <!--end::Image input wrapper-->
                            </div>
                            <!--begin::Step 1-->
                        </div>
                        <!--end::Group-->

                        <!--begin::Actions-->
                        <div class="d-flex flex-stack">
                            <!--begin::Wrapper-->
                            <div class="me-2">
                                <button type="button" class="btn btn-light text-hover-danger btn-active-light-danger btn-flex" data-kt-stepper-action="previous">
                                    <i class="far fa-chevron-left" aria-hidden="true"></i>&nbsp;  পূর্বে যান
                                </button>
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Wrapper-->
                            <div>
                                <button type="submit" class="btn btn-success" id="licensePaymentSubmit" data-kt-stepper-action="submit">
                                    <span class="indicator-label">
                                        দাখিল করুন &nbsp; <i class="far fa-check" aria-hidden="true"></i>
                                    </span>
                                    <span class="indicator-progress">
                                        দাখিল করা হচ্ছে... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                
                                <button type="button" class="btn btn-success" data-kt-stepper-action="next">
                                    এগিয়ে যান &nbsp; <i class="far fa-chevron-right" aria-hidden="true"></i>
                                </button>
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Stepper-->
            </div>
            <!--begin::Modal body-->
        </div>
    </div>
</div>
<div class="modal fade" id="license_renewal_fee_payment_modal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered min-w-lg-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <!--begin::Modal header-->
            <div class="modal-header border-0 justify-content-between bg-light-dark">
                <!--begin::Heading-->
                <div class="text-center">
                   <!--begin::Title-->
                   <h3 class="text-gray-800 fw-semibold fs-2 font-bn fw-normal">
                        নবায়ন ফি পরিশোধ করুন
                   </h3>
                   <!--end::Title-->
               </div>
               <!--end::Heading-->
               <!--begin::Close-->
               <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                   <i class="fa fa-times fs-1" aria-hidden="true"></i>
               </div>
               <!--end::Close-->
           </div>
           <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y m-5 font-bn">
                <!--begin::Stepper-->
                <div class="stepper stepper-pills" id="license_renewal_fee_payment_stepper">
                    <!--begin::Nav-->
                    <div class="stepper-nav flex-center flex-wrap mb-10 d-none d-md-flex">
                        <!--begin::Step 1-->
                        <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number font-kohinoor">১</span>
                                </div>
                                <!--end::Icon-->
                    
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        পরিমান
                                    </h3>
                    
                                    <div class="stepper-desc font-kohinoor" id="totalAmountModalSubRenewal">
                                        
                                    </div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                    
                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step 1-->
                    
                        <!--begin::Step 2-->
                        <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number font-kohinoor">২</span>
                                </div>
                                <!--begin::Icon-->
                    
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        মাধ্যম
                                    </h3>

                                    <div class="stepper-desc">
                                        নগদ/অনলাইন
                                    </div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                    
                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step 2-->
                    
                        <!--begin::Step 3-->
                        <div class="stepper-item mark-completed mx-8 my-4" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number font-kohinoor">৩</span>
                                </div>
                                <!--begin::Icon-->
                    
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        নগদ পরিশোধ
                                    </h3>
                    
                                    <div class="stepper-desc">
                                        ব্যাংক ড্রাফট
                                    </div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                    
                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step 3-->
                    </div>
                    <!--end::Nav-->
                    
                    <!--begin::Form-->
                    <form action="{{ route('user.trade_license_applications.payments.license_renewal_fee.store') }}" method="POST" enctype="multipart/form-data" class="form mx-auto font-kohinoor" novalidate="novalidate" id="license_renewal_fee_payment_stepper_form">
                        @csrf
                        @method('POST')

                        <input type="hidden" name="id" id="applicationIdLicenseRenewalFee" required>
                        <!--begin::Group-->
                        <div class="mb-5">
                            <!--begin::Step 1-->
                            <div class="flex-column current" data-kt-stepper-element="content">
                                <div class="row mb-md-8 mb-2 font-hind-siliguri">
                                    <table class="table table-striped table-row-dashed table-row-gray-300 gy-7">
                                        <thead>
                                            <tr class="fw-semibold fs-6 text-gray-800">
                                                <th class="py-2 px-2">ক্ষেত্র</th>
                                                <th class="py-2 px-2 text-end">টাকার পরিমাণ (৳)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fs-5">
                                            <tr>
                                                <td class="py-2 px-2">নবায়ন ফি</td>
                                                <td class="py-2 px-2 text-end" id="displayLicenseRenewalFee"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2" id="licenseRenewalArrearField">বকেয়া</td>
                                                <td class="py-2 px-2 text-end" id="displayLicenseRenewalArrear"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2">সাইনবোর্ড ফি</td>
                                                <td class="py-2 px-2 text-end" id="displaySignboardFeeRenewal"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2">আয়কর</td>
                                                <td class="py-2 px-2 text-end" id="displayIncomeTaxRenewal"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2">ভ্যাট</td>
                                                <td class="py-2 px-2 text-end" id="displayVatRenewal"></td>
                                            <tr>
                                                <td class="py-2 px-2">সারচার্জ</td>
                                                <td class="py-2 px-2 text-end" id="displaySurchargeRenewal"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 fs-4 fw-semibold">মোট</td>
                                                <td class="py-2 px-2 fs-4 text-end fw-semibold text-danger" id="displayTotalFeeRenewal"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-2 fs-4 fw-semibold">মোট (কথায়)</td>
                                                <td class="py-2 px-2 fs-4 text-end fw-semibold text-danger" id="displayTotalFeeInBanglaRenewal"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--begin::Step 1-->

                            <!--begin::Step 1-->
                            <div class="flex-column mb-15" data-kt-stepper-element="content">
                                <button type="button" class="btn btn-flex btn-info px-6 justify-between" id="licenseRenewalFeeManualPaymentButton">
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-hand-holding-circle-dollar fs-2x me-2"></i>
                                            <span class="d-flex flex-column align-items-start ms-2">
                                                <span class="fs-3 fw-semibold font-bn">
                                                    নগদ পরিশোধ
                                                </span>
                                                <span class="fs-7 fw-normal opacity-75">
                                                    নগদ পরিশোধের ব্যাংক ড্রাফট প্রদান করুন
                                                </span>
                                            </span>
                                        </div>
                                        <i class="fal fa-chevron-right fs-1"></i>
                                    </div>
                                </button>
                                <a href="javascript:void(0))" class="btn btn-flex btn-danger mt-4 px-6">
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        <div class="d-flex align-items-center">
                                            <i class="fab fa-cc-visa fs-2x me-2"></i>
                                            <span class="d-flex flex-column align-items-start ms-2">
                                                <span class="fs-3 fw-semibold font-bn">
                                                    অনলাইন পেমেন্ট
                                                </span>
                                                <span class="fs-7 fw-normal opacity-75">
                                                    শীঘ্রই আসছে...
                                                </span>
                                            </span>
                                        </div>
                                        <i class="fal fa-external-link fs-1"></i>
                                    </div>
                                </a>
                            </div>
                            <!--begin::Step 1-->

                            <!--begin::Step 1-->
                            <div class="flex-column mb-15" data-kt-stepper-element="content">
                                <div class="fv-row mb-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 text-gray-700 fw-semibold mb-2 required">
                                        ব্যাংকের নাম
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="fal fa-landmark fs-3"></i>
                                        </div>
                                        <input type="text" class="form-control text-gray-900" placeholder="" list="bankList" name="bank" value="{{ old('bank') }}" required/>
                                    </div>
                                    <!--end::Input-->
                                    @error('bank')
                                    <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="fv-row mb-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 text-gray-700 fw-semibold mb-2 required">
                                        শাখা
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="fal fa-landmark fs-3"></i>
                                        </div>
                                        <input type="text" class="form-control text-gray-900" placeholder="" name="bank_branch" value="{{ old('bank_branch') }}" required/> 
                                    </div>
                                    <!--end::Input-->
                                    @error('bank_branch')
                                    <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="fv-row mb-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 text-gray-700 fw-semibold mb-2 required">
                                        চালান নম্বর
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="fal fa-file-invoice fs-3"></i>
                                        </div>
                                        <input type="text" class="form-control text-gray-900" placeholder="" name="bank_invoice_no" value="{{ old('bank_invoice_no') }}" required/> 
                                    </div>
                                    <!--end::Input-->
                                    @error('bank_invoice_no')
                                    <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!--begin::Image input wrapper-->
                                <div class="fv-row">
                                    <div class="mb-4">
                                        <p class="fs-6 fw-semibold font-kohinoor">আপনার ব্যাংক ড্রাফট এখানে আপলোড করুন</p>
                                    </div>
                                    <!--begin::Image input placeholder-->
                                    <!--begin::Image input-->
                                    <div class="image-input image-input-outline image-input-placeholder"
                                        data-kt-image-input="true">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-150px h-125px"
                                        style="background-image: url({{ asset('assets/img/blank-image.svg') }}); background-position: center;"
                                        ></div>
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
                                                accept=".png, .jpg, .jpeg, .pdf"
                                                required/>
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Edit-->
                                    </div>
                                    <div class="form-text fs-6 text-gray-700">
                                        <div class="d-flex flex-column">
                                            <li class="d-flex align-items-center">
                                                <span class="bullet bullet-dot bg-success"></span> &nbsp; সাইজ সর্বোচ্চ ২ মেগাবাইট
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <span class="bullet bullet-dot bg-danger"></span> &nbsp; ফরমেট: jpg, jpeg, png, pdf
                                            </li>
                                        </div>                       
                                    </div>
                                </div>
                                <!--end::Image input wrapper-->
                            </div>
                            <!--begin::Step 1-->
                        </div>
                        <!--end::Group-->

                        <!--begin::Actions-->
                        <div class="d-flex flex-stack">
                            <!--begin::Wrapper-->
                            <div class="me-2">
                                <button type="button" class="btn btn-light text-hover-danger btn-active-light-danger btn-flex" data-kt-stepper-action="previous">
                                    <i class="far fa-chevron-left" aria-hidden="true"></i>&nbsp;  পূর্বে যান
                                </button>
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Wrapper-->
                            <div>
                                <button type="submit" class="btn btn-success" id="renewalPaymentSubmit" data-kt-stepper-action="submit">
                                    <span class="indicator-label">
                                        দাখিল করুন &nbsp; <i class="far fa-check" aria-hidden="true"></i>
                                    </span>
                                    <span class="indicator-progress">
                                        দাখিল করা হচ্ছে... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                
                                <button type="button" class="btn btn-success" data-kt-stepper-action="next">
                                    এগিয়ে যান &nbsp; <i class="far fa-chevron-right" aria-hidden="true"></i>
                                </button>
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Stepper-->
            </div>
            <!--begin::Modal body-->
        </div>
    </div>
</div>
@endsection

@section('exclusive_scripts')
<script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>

    const displayLicenseForm  = (data) => {
        document.getElementById('displayLicenseFee').innerText = convertToBanglaDigits(data.licenseFee);
        document.getElementById('displaySignboardFee').innerText = convertToBanglaDigits(data.signboardFee);
        document.getElementById('displayIncomeTax').innerText = convertToBanglaDigits(data.incomeTax);
        document.getElementById('displayVat').innerText = convertToBanglaDigits(data.vat);
        document.getElementById('displayTotalFee').innerText = convertToBanglaDigits(data.total);
        document.getElementById('displayTotalFeeInBangla').innerText = convertToBanglaDigits(data.totalInBangla)+' টাকা মাত্র';
        document.getElementById('applicationIdLicenseFee').value = data.id;
        document.getElementById('totalAmountModalSub').innerText = convertToBanglaDigits(data.total)+' টাকা';
    }

    const displayRenewalForm = (data) => {
        document.getElementById('displayLicenseRenewalFee').innerText = convertToBanglaDigits(data.licenseFee);
        document.getElementById('displayLicenseRenewalArrear').innerText = convertToBanglaDigits(data.arrear);
        document.getElementById('displaySignboardFeeRenewal').innerText = convertToBanglaDigits(data.signboardFee);
        document.getElementById('displayIncomeTaxRenewal').innerText = convertToBanglaDigits(data.incomeTax);
        document.getElementById('displayVatRenewal').innerText = convertToBanglaDigits(data.vat);
        document.getElementById('displaySurchargeRenewal').innerText = convertToBanglaDigits(data.surcharge);
        document.getElementById('displayTotalFeeRenewal').innerText = convertToBanglaDigits(data.total);
        document.getElementById('displayTotalFeeInBanglaRenewal').innerText = convertToBanglaDigits(data.totalInBangla)+' টাকা মাত্র';
        document.getElementById('applicationIdLicenseRenewalFee').value = data.id;
        document.getElementById('totalAmountModalSubRenewal').innerText = convertToBanglaDigits(data.total)+' টাকা';
        document.getElementById('applicationIdLicenseRenewalFee').value = data.id;

        if(data.arrear[0] > 0) {
            document.getElementById('licenseRenewalArrearField').innerText = convertToBanglaDigits(data.arrearStartYear)+' থেকে '+convertToBanglaDigits(data.arrearEndYear)+' অর্থবছরের বকেয়া';
        }
    }

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

    const formFeeForm = document.getElementById('form_fee_payment_stepper_form');
    var formFeeValidator = FormValidation.formValidation(
        formFeeForm,
        {
            fields: {
                'bank': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        },
                        regexp: {
                            message: 'অক্ষর অনুমোদিত',
                            regexp: /^[a-zA-Z\u0980-\u09FF\. ]+$/,
                        },
                    }
                },
                'bank_branch': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        }
                    }
                },
                'bank_invoice_no': {
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
                'image': {
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
                    eleValidClass: ''
                })
            }
        }
    );
    const formFeeSubmitButton = document.getElementById('formPaymentSubmit');
    checkFormValidity(formFeeForm, formFeeValidator, formFeeSubmitButton);

    const licenseFeeForm = document.getElementById('license_fee_payment_stepper_form');
    var licenseFeeValidator = FormValidation.formValidation(
        licenseFeeForm, 
        {
            fields: {
                'bank': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        },
                        regexp: {
                            message: 'অক্ষর অনুমোদিত',
                            regexp: /^[a-zA-Z\u0980-\u09FF\. ]+$/,
                        },
                    }
                },
                'bank_branch': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        }
                    }
                },
                'bank_invoice_no': {
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
                'image': {
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
                    eleValidClass: ''
                })
            }
        }
    );
    const licensePaymentSubmitButton = document.getElementById('licensePaymentSubmit');
    checkFormValidity(licenseFeeForm, licenseFeeValidator, licensePaymentSubmitButton);

    const licenseRenewalFeeForm = document.getElementById('license_renewal_fee_payment_stepper_form');
    var licenseRenewalFeeValidator = FormValidation.formValidation(
        licenseRenewalFeeForm, 
        {
            fields: {
                'bank': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        },
                        regexp: {
                            message: 'অক্ষর অনুমোদিত',
                            regexp: /^[a-zA-Z\u0980-\u09FF\. ]+$/,
                        },
                    }
                },
                'bank_branch': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        }
                    }
                },
                'bank_invoice_no': {
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
                'image': {
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
                    eleValidClass: ''
                })
            }
        }
    );
    const renewalPaymentSubmitButton = document.getElementById('renewalPaymentSubmit');
    checkFormValidity(licenseRenewalFeeForm, licenseRenewalFeeValidator, renewalPaymentSubmitButton);

    // Display officer comments
    const showMessage = (msg) => {
        Swal.fire({
            title: 'কর্মকর্তার মন্তব্য',
            text: msg,
            icon: 'info',
            iconHtml: '<i class="fab fa-facebook-messenger fs-3x text-info"></i>',
            confirmButtonText: 'ঠিক আছে',
            customClass: {
                icon: 'border-0',
                confirmButton: "btn btn-primary",
                title: "font-bn",
                container: "font-bn",
            }
        });
    }

    // Deletion Confimation
    const submitForm = (form, event, title) => {
        event.preventDefault();
        Swal.fire({
            title: `আপনি কি \'${title}\' আবেদনটি ডিলিট করতে চান?`,
            text: "একবার ডিলিট করার পর পুনরুদ্ধার করা সম্ভব নয়।",
            icon: "error",
            iconHtml: '<i class="fas fa-trash-can fs-2x text-danger"></i>',
            showCancelButton: true,
            cancelButtonText: 'বাতিল করুন',
            confirmButtonText: "হ্যাঁ, ডিলিট করুন!",
            customClass: {
                confirmButton: "btn btn-danger font-bn order-2",
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

    //! Stepper element form fee
    var element = document.querySelector("#form_fee_payment_stepper");
    var manualPaymentButton = document.querySelector("#manualPaymentButton");
    var stepper = new KTStepper(element);


    stepper.on("kt.stepper.next", function (stepper) {
        stepper.goNext(); // go next step
    });
    stepper.on("kt.stepper.previous", function (stepper) {
        stepper.goPrevious(); // go previous step
    });
    manualPaymentButton.addEventListener('click', function(e){
        stepper.goNext();
    });

    // Stepper element license fee
    var licenseFeeStepperElement = document.querySelector("#license_fee_payment_stepper");
    var licenseFeeManualPaymentButton = document.querySelector("#licenseFeeManualPaymentButton");
    var licenseFeeStepper = new KTStepper(licenseFeeStepperElement);

    licenseFeeStepper.on("kt.stepper.next", function (licenseFeeStepper) {
        licenseFeeStepper.goNext(); // go next step
    });
    licenseFeeStepper.on("kt.stepper.previous", function (licenseFeeStepper) {
        licenseFeeStepper.goPrevious(); // go previous step
    });
    licenseFeeManualPaymentButton.addEventListener('click', function(e){
        licenseFeeStepper.goNext();
    });

    // Stepper element license renewal fee
    var licenseRenewalFeeStepperElement = document.querySelector("#license_renewal_fee_payment_stepper");
    var licenseRenewalFeeManualPaymentButton = document.querySelector("#licenseRenewalFeeManualPaymentButton");
    var licenseRenewalFeeStepper = new KTStepper(licenseRenewalFeeStepperElement);

    licenseRenewalFeeStepper.on("kt.stepper.next", function (licenseRenewalFeeStepper) {
        licenseRenewalFeeStepper.goNext(); // go next step
    });
    licenseRenewalFeeStepper.on("kt.stepper.previous", function (licenseRenewalFeeStepper) {
        licenseRenewalFeeStepper.goPrevious(); // go previous step
    });
    licenseRenewalFeeManualPaymentButton.addEventListener('click', function(e){
        licenseRenewalFeeStepper.goNext();
    });


    const convertToBanglaDigits = (text) => {
        text = String(text);
        var banglaDigits = {
            0: '০',
            1: '১',
            2: '২',
            3: '৩',
            4: '৪',
            5: '৫',
            6: '৬',
            7: '৭',
            8: '৮',
            9: '৯'
        }

        return text.replace(/[0-9]/g, function (w) {
            return banglaDigits[w]
        });
    }

    var KTFileManagerList = function () {
        // Define shared variables
        var datatable;
        var table

        // Define template element variables
        var uploadTemplate;
        var renameTemplate;
        var actionTemplate;
        var checkboxTemplate;

        
        const initDatatable = () => {
            // Set date data order
            const tableRows = table.querySelectorAll('tbody tr');

            const filesListOptions = {
                "info": false,
                'order': [],
                'pageLength': 15,
                "lengthChange": false,
                'ordering': true,
                'columns': [
                    { data: 'organization_name' },
                    { data: 'status' },
                    { data: 'actions' },
                ],
                conditionalPaging: true
            };

            // Define datatable options to load
            var loadOptions;
            loadOptions = filesListOptions;

            // Init datatable --- more info on datatables: https://datatables.net/manual/
            datatable = $(table).DataTable(loadOptions);

            $('[data-bs-toggle="tooltip"]').tooltip();
        }

        // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
        const handleSearchDatatable = () => {
            const filterSearch = document.querySelector('[data-application-table-filter="search"]');
            filterSearch.addEventListener('keyup', function (e) {
                datatable.search(e.target.value).draw();
            });
        }
        // Public methods
        return {
            init: function () {
                table = document.querySelector('#kt_file_manager_list');

                if (!table) {
                    return;
                }
                initDatatable();
                handleSearchDatatable();
                KTMenu.createInstances();
            }
        }
    }();

    // On document ready
    KTUtil.onDOMContentLoaded(function () {
        KTFileManagerList.init();
    });

</script>
@endsection
