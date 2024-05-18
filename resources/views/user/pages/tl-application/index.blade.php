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
                        <th class="">স্বত্বাধিকারী</th>
                        <th class="">প্রতিষ্ঠান</th>
                        <th class="">সর্বশেষ অবস্থা</th>
                        <th class="text-end">করনীয়</th>
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
                                    <a href="{{ route('admin.trade_license_applications.show', $application->id) }}" class="text-dark text-hover-primary fs-5 fw-bold d-block font-bn">{{ $application->owner_name_bn }}</a>
                                    <span class="text-gray-600 fs-7 mt-1">{{ Helpers::convertToBanglaDigits(Carbon\Carbon::parse($application->created_at)->locale('bn-BD')->diffForHumans())}}</span>
                                </div>
                                <!--end::Text-->
                            </div>
                        </td>
                        <td class="py-2">
                            <div class="d-flex align-items-center">
                                <!--begin::Symbol-->
                                @php
                                    $b_theme = 'primary';

                                    if ($application->nature_of_business === 'Individual'){
                                        $b_theme = 'primary';
                                    } elseif ($application->nature_of_business === 'Joint') {
                                        $b_theme = 'success';
                                    } else {
                                        $b_theme = 'info';
                                    }
                                @endphp
                                <div class="symbol symbol-50px me-5">
                                    <span class="symbol-label bg-light-{{ $b_theme }} border border-{{ $b_theme }} border-dashed">
                                        <i class="fas fa-shop fs-2x text-{{ $b_theme }}"></i>
                                    </span>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Text-->
                                <div class="">
                                    <span class="text-dark fs-5 fw-bold font-bn">{{ $application->business_organization_name_bn }} 
                                        {{-- <i class="far {{ $data['icon'] }} fs-6 text-{{ $data['theme'] }}"></i> --}}
                                    </span>

                                    @if ($application->nature_of_business === 'Individual')
                                    <span class="badge d-inline-block font-bn badge-light-primary fs-7">{{ $application->nature_of_business_bn }}</span>
                                    @elseif ($application->nature_of_business === 'Joint')
                                    <span class="badge d-inline-block font-bn badge-light-success fs-7">{{ $application->nature_of_business_bn }}</span>
                                    @else
                                    <span class="badge d-inline-block font-bn badge-light-info fs-7">{{ $application->nature_of_business_bn }}</span>
                                    @endif
                                    <br>
                                    <a href="tel:{{ $application->phone_no }}" class="text-gray-600 fs-6 ls-1 mt-1 text-hover-primary">{{ $application->phone_no }}</a>
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
                        <td class="text-end py-1" data-kt-filemanager-table="action_dropdown">
                            <div class="d-flex justify-content-end">

                                @if ($application->isValid())
                                <a href="#" class="btn btn-success btn-icon btn-sm me-1" data-bs-toggle="tooltip" title="ট্রেড লাইসেন্স দেখুন">
                                    <i class="fal fa-memo-circle-check fs-4"></i>
                                </a>
                                @endif

                                @if (Helpers::needsApplicationCorrection($application->status))
                                <a href="{{ route('user.trade_license_applications.review', $application->id) }}" class="btn btn-danger btn-icon btn-sm me-1" data-bs-toggle="tooltip" title="ভুল তথ্য সংশোধন করুন">
                                    <i class="fal fa-warning fs-4"></i>
                                </a>
                                @endif

                                @if ($application->status === Helpers::PENDING_LICENSE_FEE_PAYMENT)
                                <a href="#" class="btn btn-primary btn-icon btn-sm me-1" data-bs-toggle="tooltip" title="লাইসেন্স ফি পরিশোধ করুন">
                                    <i class="far fa-bangladeshi-taka-sign fs-4"></i>
                                </a>
                                @endif

                                @if ($application->status === Helpers::PENDING_FORM_FEE_PAYMENT || $application->status === Helpers::DENIED_FORM_FEE_VERIFICATION)
                                <a href="#" class="btn btn-success btn-icon btn-sm me-1 pulse pulse-warning" data-bs-toggle="modal" data-bs-target="#kt_modal_offer_a_deal" data-bs-toggle="tooltip" title="ফর্ম ফি পরিশোধ করুন" onclick="document.getElementById('applicationId').value = '{{ $application->id }}'">
                                    <i class="far fa-bangladeshi-taka-sign fs-4"></i>
                                    <span class="pulse-ring"></span>
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
<div class="modal fade" id="kt_modal_offer_a_deal" tabindex="-1" aria-hidden="true">
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
           <!--begin::Modal header-->
            <!--begin::Modal header-->

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
                                <button type="submit" class="btn btn-success" data-kt-stepper-action="submit">
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

    const form = document.getElementById('form_fee_payment_stepper_form');

    var validator = FormValidation.formValidation(
        form,
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

    const submitButton = document.querySelector('[data-kt-stepper-action="submit"]')
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

    

    // Stepper lement
    var element = document.querySelector("#form_fee_payment_stepper");
    var manualPaymentButton = document.querySelector("#manualPaymentButton");

    // Initialize Stepper
    var stepper = new KTStepper(element);

    // Handle next step
    stepper.on("kt.stepper.next", function (stepper) {
        stepper.goNext(); // go next step
    });

    // Handle previous step
    stepper.on("kt.stepper.previous", function (stepper) {
        stepper.goPrevious(); // go previous step
    });

    manualPaymentButton.addEventListener('click', function(e){
        stepper.goNext();
    });



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
                    { data: 'owners_name' },
                    { data: 'status' },
                    { data: 'actions', responsivePriority: -1 },
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
