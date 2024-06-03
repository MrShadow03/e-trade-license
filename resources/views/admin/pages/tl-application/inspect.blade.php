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
                    <div class="card-body">
                        <!--begin::Details toggle-->
                        <div class="d-flex flex-stack fs-4 py-3">
                            <div class="fw-bold">
                                আবেদনের অগ্রগতি
                            </div>

                            <!--begin::Badge-->
                            <i class="fa fa-hourglass" aria-hidden="true"></i>
                            <!--begin::Badge-->
                        </div>
                        <!--end::Details toggle-->

                        <div class="separator separator-dashed my-3"></div>
                        
                        <div class="timeline">
                            <!--begin::Timeline item-->
                            <div class="timeline-item align-items-center {{ TIMELINE_GAP }}">
                                <!--begin::Timeline line-->
                                <div class="timeline-line border-success w-40px mt-6 {{ TIMELINE_NEGATIVE_GAP }}"></div>
                                <!--end::Timeline line-->

                                @php
                                    $c = Helpers::hasCompletedFormFeePayment($application->status)
                                @endphp
                                <!--begin::Timeline icon-->
                                <div class="timeline-icon badge badge-lg {{ $c ? 'badge-success' : 'border border-'.PENDING_STATE_THEME.' border-dashed badge-light-'.PENDING_STATE_THEME  }} badge-circle p-5">
                                    <i class="far fa-bangladeshi-taka-sign fs-4 text-{{ $c ? 'white' : PENDING_STATE_THEME  }}"></i>                                   
                                </div>
                                <!--end::Timeline icon-->  
                                
                                <!--begin::Timeline content-->
                                <div class="timeline-content overflow-hidden m-0">
                                    <!--begin::Title-->
                                    <span class="fs-6 text-gray-600 fw-normal d-block font-kohinoor">{{ Helpers::convertToBanglaDigits($application->created_at->locale('bn-BD')->translatedFormat('d F, Y')) }}</span>
                                    <!--end::Title-->   
                                    <!--begin::Title-->
                                    <span class="fs-5 text-gray-800 fw-semibold">আবেদন ফি পরিশোধ করেছেন</span>
                                    <!--end::Title-->    
                                </div>
                                <!--end::Timeline content-->
                            </div>
                            <!--end::Timeline item-->  

                            <!--begin::Timeline item-->
                            <div class="timeline-item align-items-center {{ TIMELINE_GAP }}">
                                <!--begin::Timeline line-->
                                <div class="timeline-line w-40px {{ TIMELINE_NEGATIVE_GAP }}"></div>
                                <!--end::Timeline line-->

                                @php
                                    $c = Helpers::hasAssistantApproval($application->status)
                                @endphp
                                <!--begin::Timeline icon-->
                                <div class="timeline-icon badge badge-lg {{ $c ? 'badge-success' : 'border border-'.PENDING_STATE_THEME.' border-dashed badge-light-'.PENDING_STATE_THEME  }} badge-circle p-5">
                                    <i class="far fa-user fs-4 text-{{ $c ? 'white' : PENDING_STATE_THEME  }}"></i>                                   
                                </div>
                                <!--end::Timeline icon-->

                                <!--begin::Timeline content-->
                                <div class="timeline-content overflow-hidden m-0">
                                    <!--begin::Title-->
                                    <span class="fs-6 text-gray-600 fw-normal d-block font-kohinoor">চলমান</span>
                                    <!--end::Title-->   
                                    <!--begin::Title-->
                                    <span class="fs-5 text-gray-800 fw-semibold">সহকারী কর্মকর্তার অনুমোদন</span>
                                    <!--end::Title-->     
                                </div>
                                <!--end::Timeline content-->                                  
                            </div>                                        
                            <!--end::Timeline item--> 

                            <!--begin::Timeline item-->
                            <div class="timeline-item align-items-center {{ TIMELINE_GAP }}">
                                <!--begin::Timeline line-->
                                <div class="timeline-line  w-40px {{ TIMELINE_NEGATIVE_GAP }}"></div>
                                <!--end::Timeline line-->

                                @php
                                    $c = Helpers::hasInspectorApproval($application->status)
                                @endphp
                                <!--begin::Timeline icon-->
                                <div class="timeline-icon badge badge-lg {{ $c ? 'badge-success' : 'border border-'.PENDING_STATE_THEME.' border-dashed badge-light-'.PENDING_STATE_THEME  }} badge-circle p-5">
                                    <i class="far fa-user fs-4 text-{{ $c ? 'white' : PENDING_STATE_THEME  }}"></i>   
                                </div>
                                <!--end::Timeline icon-->

                                <!--begin::Timeline content-->
                                <div class="timeline-content overflow-hidden m-0">
                                    <!--begin::Title-->
                                    <span class="fs-6 text-gray-600 fw-normal d-block font-kohinoor">অপেক্ষমাণ</span>
                                    <!--end::Title-->   
                                    <!--begin::Title-->
                                    <span class="fs-5 text-gray-800 fw-semibold">পরিদর্শকের অনুমোদন</span>
                                    <!--end::Title-->     
                                </div>
                                <!--end::Timeline content-->                                  
                            </div>                                        
                            <!--end::Timeline item--> 

                            <!--begin::Timeline item-->
                            <div class="timeline-item align-items-center {{ TIMELINE_GAP }}">
                                <!--begin::Timeline line-->
                                <div class="timeline-line  w-40px {{ TIMELINE_NEGATIVE_GAP }}"></div>
                                <!--end::Timeline line-->

                                @php
                                    $c = Helpers::hasCompletedLicenseFeePayment($application->status)
                                @endphp
                                <!--begin::Timeline icon-->
                                <div class="timeline-icon badge badge-lg {{ $c ? 'badge-success' : 'border border-'.PENDING_STATE_THEME.' border-dashed badge-light-'.PENDING_STATE_THEME  }} badge-circle p-5">
                                    <i class="far fa-bangladeshi-taka-sign fs-4 text-{{ $c ? 'white' : PENDING_STATE_THEME  }}"></i>                                   
                                </div>
                                <!--end::Timeline icon-->

                                <!--begin::Timeline content-->
                                <div class="timeline-content overflow-hidden m-0">
                                    <!--begin::Title-->
                                    <span class="fs-6 text-gray-600 fw-normal d-block font-kohinoor">অপেক্ষমাণ</span>
                                    <!--end::Title-->   
                                    <!--begin::Title-->
                                    <span class="fs-5 text-gray-800 fw-semibold">লাইসেন্স ফি পরিশোধ</span>
                                    <!--end::Title-->     
                                </div>
                                <!--end::Timeline content-->                                  
                            </div>                                        
                            <!--end::Timeline item--> 

                            <!--begin::Timeline item-->
                            <div class="timeline-item align-items-center {{ TIMELINE_GAP }}">
                                <!--begin::Timeline line-->
                                <div class="timeline-line  w-40px {{ TIMELINE_NEGATIVE_GAP }}"></div>
                                <!--end::Timeline line-->

                                @php
                                    $c = Helpers::hasSuptApproval($application->status)
                                @endphp
                                <!--begin::Timeline icon-->
                                <div class="timeline-icon badge badge-lg {{ $c ? 'badge-success' : 'border border-'.PENDING_STATE_THEME.' border-dashed badge-light-'.PENDING_STATE_THEME  }} badge-circle p-5">
                                    <i class="far fa-user fs-4 text-{{ $c ? 'white' : PENDING_STATE_THEME  }}"></i>                                   
                                </div>
                                <!--end::Timeline icon-->

                                <!--begin::Timeline content-->
                                <div class="timeline-content overflow-hidden m-0">
                                    <!--begin::Title-->
                                    <span class="fs-6 text-gray-600 fw-normal d-block font-kohinoor">অপেক্ষমাণ</span>
                                    <!--end::Title-->   
                                    <!--begin::Title-->
                                    <span class="fs-5 text-gray-800 fw-semibold">সুপারিনটেনডেন্টের অনুমোদন</span>
                                    <!--end::Title-->     
                                </div>
                                <!--end::Timeline content-->                                  
                            </div>                                        
                            <!--end::Timeline item--> 

                            <!--begin::Timeline item-->
                            <div class="timeline-item align-items-center {{ TIMELINE_GAP }}">
                                <!--begin::Timeline line-->
                                <div class="timeline-line  w-40px {{ TIMELINE_NEGATIVE_GAP }}"></div>
                                <!--end::Timeline line-->

                                @php
                                    $c = Helpers::hasROApproval($application->status)
                                @endphp
                                <!--begin::Timeline icon-->
                                <div class="timeline-icon badge badge-lg {{ $c ? 'badge-success' : 'border border-'.PENDING_STATE_THEME.' border-dashed badge-light-'.PENDING_STATE_THEME  }} badge-circle p-5">
                                    <i class="far fa-user fs-4 text-{{ $c ? 'white' : PENDING_STATE_THEME  }}"></i>                                   
                                </div>
                                <!--end::Timeline icon-->

                                <!--begin::Timeline content-->
                                <div class="timeline-content overflow-hidden m-0">
                                    <!--begin::Title-->
                                    <span class="fs-6 text-gray-600 fw-normal d-block font-kohinoor">অপেক্ষমাণ</span>
                                    <!--end::Title-->   
                                    <!--begin::Title-->
                                    <span class="fs-5 text-gray-800 fw-semibold">রাজস্ব কর্মকর্তার অনুমোদন</span>
                                    <!--end::Title-->     
                                </div>
                                <!--end::Timeline content-->                                  
                            </div>                                        
                            <!--end::Timeline item--> 
                            
                            <!--begin::Timeline item-->
                            <div class="timeline-item align-items-center {{ TIMELINE_GAP }}">
                                <!--begin::Timeline line-->
                                <div class="timeline-line  w-40px {{ TIMELINE_NEGATIVE_GAP }}"></div>
                                <!--end::Timeline line-->

                                @php
                                    $c = Helpers::hasCROApproval($application->status)
                                @endphp
                                <!--begin::Timeline icon-->
                                <div class="timeline-icon badge badge-lg {{ $c ? 'badge-success' : 'border border-'.PENDING_STATE_THEME.' border-dashed badge-light-'.PENDING_STATE_THEME  }} badge-circle p-5">
                                    <i class="far fa-user fs-4 text-{{ $c ? 'white' : PENDING_STATE_THEME  }}"></i>                                   
                                </div>
                                <!--end::Timeline icon-->

                                <!--begin::Timeline content-->
                                <div class="timeline-content overflow-hidden m-0">
                                    <!--begin::Title-->
                                    <span class="fs-6 text-gray-600 fw-normal d-block font-kohinoor">অপেক্ষমাণ</span>
                                    <!--end::Title-->   
                                    <!--begin::Title-->
                                    <span class="fs-5 text-gray-800 fw-semibold">প্রধান রাজস্ব কর্মকর্তার অনুমোদন</span>
                                    <!--end::Title-->     
                                </div>
                                <!--end::Timeline content-->                                  
                            </div>                                        
                            <!--end::Timeline item--> 
                            
                            <!--begin::Timeline item-->
                            <div class="timeline-item align-items-center {{ TIMELINE_GAP }}">
                                <!--begin::Timeline line-->
                                <div class="timeline-line  w-40px {{ TIMELINE_NEGATIVE_GAP }}"></div>
                                <!--end::Timeline line-->

                                @php
                                    $c = Helpers::hasCEOApproval($application->status)
                                @endphp
                                <!--begin::Timeline icon-->
                                <div class="timeline-icon badge badge-lg {{ $c ? 'badge-success' : 'border border-'.PENDING_STATE_THEME.' border-dashed badge-light-'.PENDING_STATE_THEME  }} badge-circle p-5">
                                    <i class="far fa-user fs-4 text-{{ $c ? 'white' : PENDING_STATE_THEME  }}"></i>                                   
                                </div>
                                <!--end::Timeline icon-->

                                <!--begin::Timeline content-->
                                <div class="timeline-content overflow-hidden m-0">
                                    <!--begin::Title-->
                                    <span class="fs-6 text-gray-600 fw-normal d-block font-kohinoor">অপেক্ষমাণ</span>
                                    <!--end::Title-->   
                                    <!--begin::Title-->
                                    <span class="fs-5 text-gray-800 fw-semibold">প্রধান নির্বাহী কর্মকর্তার অনুমোদন</span>
                                    <!--end::Title-->     
                                </div>
                                <!--end::Timeline content-->                                  
                            </div>                                        
                            <!--end::Timeline item--> 

                            <!--begin::Timeline item-->
                            <div class="timeline-item align-items-center">
                                <!--begin::Timeline line-->
                                <div class="timeline-line  w-40px"></div>
                                <!--end::Timeline line-->

                                @php
                                    $c = Helpers::hasCEOApproval($application->status)
                                @endphp
                                <!--begin::Timeline icon-->
                                <div class="timeline-icon badge badge-lg {{ $c ? 'badge-success' : 'border border-'.PENDING_STATE_THEME.' border-dashed badge-light-'.PENDING_STATE_THEME  }} badge-circle p-5">
                                    <i class="far fa-location-dot fs-4 text-{{ $c ? 'white' : PENDING_STATE_THEME  }}"></i>                                   
                                </div>
                                <!--end::Timeline icon-->

                                <!--begin::Timeline content-->
                                <div class="timeline-content overflow-hidden m-0">
                                    <!--begin::Title-->
                                    <span class="fs-6 text-gray-600 fw-normal d-block font-kohinoor">অপেক্ষমাণ</span>
                                    <!--end::Title-->   
                                    <!--begin::Title-->
                                    <span class="fs-5 text-gray-800 fw-semibold">লাইসেন্স প্রদান</span>
                                    <!--end::Title-->    
                                </div>
                                <!--end::Timeline content-->                                  
                            </div>                                        
                            <!--end::Timeline item--> 
                        </div>
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
                    <form method="POST" action="{{ route('admin.trade_license_applications.approve', $application->id) }}" class="tab-pane fade show active" id="applicationCorrectionForm" role="tabpanel">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="isApproved">
                        <!--begin::Card-->
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>স্বত্বাধিকারীর তথ্য</h2>
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
                                            <img src="{{ str_replace('localhost', 'localhost:'.env('LOCAL_PORT'), $application->getFirstMediaUrl('owner_image')) }}" alt="" class="object-fit-cover">
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="image_correction_message">
                                    </div>
                                </div>
                                <!--end::Avatar-->
                                <div class="row g-5 g-xl-8 mb-7">
                                    <div class="col-6 col-md-3">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="owner_name_bn" name="corrections[owner_name_bn][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[owner_name_bn][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-owner_name_bn">স্বত্বাধিকারীর নাম</div>
                                                <div class="{{ INFO_CLASSES }}">{{ $application->owner_name_bn }}</div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="owner_name_bn_correction_message">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="owner_name" name="corrections[owner_name][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[owner_name][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES_EN }} label-owner_name">Owner's Name</div>
                                                <div class="{{ INFO_CLASSES_EN }}">{{ $application->owner_name }}</div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="owner_name_correction_message">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="father_name_bn" name="corrections[father_name_bn][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[father_name_bn][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-father_name_bn">পিতার নাম</div>
                                                <div class="{{ INFO_CLASSES }}">{{ $application->father_name_bn }}</div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="father_name_bn_correction_message">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="father_name" name="corrections[father_name][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[father_name][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES_EN }} label-father_name">Father's Name</div>
                                                <div class="{{ INFO_CLASSES_EN }}">{{ $application->father_name }}</div>
                                            </div>
                                        </div>
                                         <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="father_name_correction_message">
                                    </div>
                                </div> 
                                <div class="row g-5 g-xl-8 mb-7">
                                    <div class="col-6 col-md-3">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="mother_name_bn" name="corrections[mother_name_bn][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[mother_name_bn][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-mother_name_bn">মাতার নাম</div>
                                                <div class="{{ INFO_CLASSES }}">{{ $application->mother_name_bn }}</div>
                                            </div>
                                        </div>
                                         <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="mother_name_bn_correction_message">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="mother_name" name="corrections[mother_name][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[mother_name][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES_EN }} label-mother_name">Mother's Name</div>
                                                <div class="{{ INFO_CLASSES_EN }}">{{ $application->mother_name }}</div>
                                            </div>
                                        </div>
                                         <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="mother_name_correction_message">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="spouse_name_bn" name="corrections[spouse_name_bn][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[spouse_name_bn][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-spouse_name_bn">স্বামী/স্ত্রীর নাম</div>
                                                <div class="{{ INFO_CLASSES }}">{{ $application->spouse_name_bn }}</div>
                                            </div>
                                        </div>
                                         <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="spouse_name_bn_correction_message">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="spouse_name" name="corrections[spouse_name][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[spouse_name][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES_EN }} label-spouse_name">Spouse's Name</div>
                                                <div class="{{ INFO_CLASSES_EN }}">{{ $application->spouse_name }}</div>
                                            </div>
                                        </div>
                                         <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="spouse_name_correction_message">
                                    </div>
                                </div> 
                                <div class="row g-5 g-xl-8">
                                    <div class="col-6 col-md-3">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="national_id_no" name="corrections[national_id_no][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[national_id_no][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-national_id_no">জাতীয় পরিচয়পত্র নং</div>
                                                <div class="{{ INFO_CLASSES }}">{{ $application->national_id_no ?? '---' }}</div>
                                            </div>
                                        </div>
                                         <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="national_id_no_correction_message">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="birth_registration_no" name="corrections[birth_registration_no][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[birth_registration_no][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-birth_registration_no">জন্ম নিবন্ধন নং</div>
                                                <div class="{{ INFO_CLASSES }}">{{ $application->birth_registration_no ?? '---' }}</div>
                                            </div>
                                        </div>
                                         <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="birth_registration_no_correction_message">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="passport_no" name="corrections[passport_no][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[passport_no][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-passport_no">পাসপোর্ট নং</div>
                                                <div class="{{ INFO_CLASSES }}">{{ $application->passport_no ?? '---' }}</div>
                                            </div>
                                        </div>
                                         <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="passport_no_correction_message">
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
                                    <h2>ব্যবসা প্রতিষ্ঠানের তথ্য</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <div class="card-body">
                                <div class="row g-5 g-xl-8 mb-7 row-cols-2 row-cols-md-4">
                                    <div class="col">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="business_organization_name_bn" name="corrections[business_organization_name_bn][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[business_organization_name_bn][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-business_organization_name_bn">ব্যবসা প্রতিষ্ঠান</div>
                                                <div class="{{ INFO_CLASSES }}">{{ $application->business_organization_name_bn }}</div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="business_organization_name_bn_correction_message">
                                    </div>
                                    <div class="col">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="business_organization_name" name="corrections[business_organization_name][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[business_organization_name][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES_EN }} label-business_organization_name">Business Organization</div>
                                                <div class="{{ INFO_CLASSES_EN }}">{{ $application->business_organization_name }}</div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="business_organization_name_correction_message">
                                    </div>
                                    <div class="col">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="nature_of_business_bn" name="corrections[nature_of_business_bn][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[nature_of_business_bn][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-nature_of_business_bn">ব্যবসার প্রকৃতি</div>
                                                <div class="{{ INFO_CLASSES }}">{{ $application->nature_of_business_bn }}</div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="nature_of_business_bn_correction_message">
                                    </div>
                                    <div class="col">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="nature_of_business" name="corrections[nature_of_business][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[nature_of_business][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES_EN }} label-nature_of_business">Nature of Business</div>
                                                <div class="{{ INFO_CLASSES_EN }}">{{ $application->nature_of_business }}</div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="nature_of_business_correction_message">
                                    </div>
                                </div> 
                                <div class="row g-5 g-xl-8 mb-7 row-cols-2 row-cols-md-4">
                                    <div class="col">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="phone_no" name="corrections[phone_no][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[phone_no][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-phone_no">ফোন নম্বর </div>
                                                <div class="{{ INFO_CLASSES }}"><a class="text-dark text-hover-primary" href="tel:{{ $application->phone_no }}">{{ $application->phone_no }}</a></div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="phone_no_correction_message">
                                    </div>
                                    <div class="col">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="email" name="corrections[email][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[email][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-email">ই-মেইল</div>
                                                <div class="{{ INFO_CLASSES }}">{{ $application->email ?? '---' }}</div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="email_correction_message">
                                    </div>
                                    <div class="col">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="tin_no" name="corrections[tin_no][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[tin_no][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-tin_no">টি আই এন নং</div>
                                                <div class="{{ INFO_CLASSES }}">{{ $application->tin_no ?? '---' }}</div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="tin_no_correction_message">
                                    </div>
                                    <div class="col">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="bin_no" name="corrections[bin_no][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[bin_no][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-bin_no">বি আই এন নং</div>
                                                <div class="{{ INFO_CLASSES }}">{{ $application->bin_no ?? '---' }}</div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="bin_no_correction_message">
                                    </div>
                                </div>
                                <div class="row g-5 g-xl-8 mb-7 row-cols-2 row-cols-md-4">
                                    <div class="col">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="ward_no" name="corrections[ward_no][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[ward_no][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-ward_no)">ওয়ার্ড নং</div>
                                                <div class="{{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits($application->ward_no) }}</div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="ward_no_correction_message">
                                    </div>
                                    <div class="col">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="zone_bn" name="corrections[zone_bn][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[zone_bn][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-zone_bn">অঞ্চল</div>
                                                <div class="{{ INFO_CLASSES }}">{{ $application->zone_bn ?? '---' }}</div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="zone_bn_correction_message">
                                    </div>
                                    <div class="col">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="business_starting_date" name="corrections[business_starting_date][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[business_starting_date][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-business_starting_date">ব্যবসা শুরুর তারিখ</div>
                                                <div class="{{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits(Carbon\Carbon::parse($application->business_starting_date)->locale('bn-BD')->translatedFormat('d F, Y')) }}</div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="business_starting_date_correction_message">
                                    </div>
                                </div>
                                <div class="row g-5 g-xl-8 mb-7 row-cols-2 row-cols-md-2">
                                    <div class="col">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="address_of_business_organization_bn" name="corrections[address_of_business_organization_bn][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[address_of_business_organization_bn][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES }} label-address_of_business_organization_bn">ঠিকানা</div>
                                                <div class="{{ INFO_CLASSES }}">{{ $application->address_of_business_organization_bn }}</div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="address_of_business_organization_bn_correction_message">
                                    </div>
                                    <div class="col">
                                        <div class="d-flex align-items-start">
                                            <div class="form-check form-check-custom form-check-danger">
                                                <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="address_of_business_organization" name="corrections[address_of_business_organization][message]" type="checkbox" value="" />
                                                <input type="checkbox" name="corrections[address_of_business_organization][isCorrected]" value="0" hidden>
                                            </div>
                                            <div class="ms-3 info_wrapper">
                                                <div class="{{ INFO_LABEL_CLASSES_EN }} label-address_of_business_organization">Address</div>
                                                <div class="{{ INFO_CLASSES_EN }}">{{ $application->address_of_business_organization }}</div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="address_of_business_organization_correction_message">
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
                                            <td class="ps-2 py-2">
                                                <span class="{{ INFO_LABEL_CLASSES }} label-ca_holding_no label-pa_holding_no">হোল্ডিং নং</span>
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="ca_holding_no" name="corrections[ca_holding_no][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[ca_holding_no][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ Helpers::convertToBanglaDigits($application->ca_holding_no ?? '---') }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="ca_holding_no_correction_message">
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="pa_holding_no" name="corrections[pa_holding_no][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[pa_holding_no][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ Helpers::convertToBanglaDigits($application->pa_holding_no ?? '---') }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="pa_holding_no_correction_message">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-2 py-2">
                                                <span class="{{ INFO_LABEL_CLASSES }} label-ca_road_no label-pa_road_no">রোড নং</span>
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="ca_road_no" name="corrections[ca_road_no][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[ca_road_no][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ Helpers::convertToBanglaDigits($application->ca_road_no ?? '---') }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="ca_road_no_correction_message">
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="pa_road_no" name="corrections[pa_road_no][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[pa_road_no][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ Helpers::convertToBanglaDigits($application->pa_road_no ?? '---') }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="pa_road_no_correction_message">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-2 py-2">
                                                <span class="{{ INFO_LABEL_CLASSES }} label-ca_post_code label-pa_post_code">পোস্ট কোড</span>
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="ca_post_code" name="corrections[ca_post_code][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[ca_post_code][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ Helpers::convertToBanglaDigits($application->ca_post_code ?? '---') }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="ca_post_code_correction_message">
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="pa_post_code" name="corrections[pa_post_code][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[pa_post_code][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ Helpers::convertToBanglaDigits($application->pa_post_code ?? '---') }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="pa_post_code_correction_message">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-2 py-2">
                                                <span class="{{ INFO_LABEL_CLASSES }} label-ca_village_bn label-pa_village_bn">এলাকা/গ্রাম</span>
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="ca_village_bn" name="corrections[ca_village_bn][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[ca_village_bn][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ $application->ca_village_bn ?? '---' }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="ca_village_bn_correction_message">
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="pa_village_bn" name="corrections[pa_village_bn][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[pa_village_bn][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ $application->pa_village_bn ?? '---' }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="pa_village_bn_correction_message">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-2 py-2">
                                                <span class="{{ INFO_LABEL_CLASSES_EN }} label-ca_village label-pa_village">Village</span>
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES_EN }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="ca_village" name="corrections[ca_village][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[ca_village][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ $application->ca_village ?? '---' }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="ca_village_correction_message">
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES_EN }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="pa_village" name="corrections[pa_village][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[pa_village][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ $application->pa_village ?? '---' }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="pa_village_correction_message">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-2 py-2">
                                                <span class="{{ INFO_LABEL_CLASSES }} label-ca_post_office_bn label-pa_post_office_bn">ডাকঘর</span>
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="ca_post_office_bn" name="corrections[ca_post_office_bn][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[ca_post_office_bn][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ $application->ca_post_office_bn ?? '---' }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="ca_post_office_bn_correction_message">
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="pa_post_office_bn" name="corrections[pa_post_office_bn][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[pa_post_office_bn][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ $application->pa_post_office_bn ?? '---' }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="pa_post_office_bn_correction_message">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-2 py-2">
                                                <span class="{{ INFO_LABEL_CLASSES_EN }} label-ca_post_office label-pa_post_office">Post Office</span>
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES_EN }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="ca_post_office" name="corrections[ca_post_office][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[ca_post_office][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ $application->ca_post_office ?? '---' }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="ca_post_office_correction_message">
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES_EN }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="pa_post_office" name="corrections[pa_post_office][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[pa_post_office][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ $application->pa_post_office ?? '---' }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="pa_post_office_correction_message">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-2 py-2">
                                                <span class="{{ INFO_LABEL_CLASSES }} label-ca_division_bn label-pa_division_bn">বিভাগ</span>
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="ca_division_bn" name="corrections[ca_division_bn][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[ca_division_bn][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ $application->ca_division_bn ?? '---' }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="ca_division_bn_correction_message">
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="pa_division_bn" name="corrections[pa_division_bn][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[pa_division_bn][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ $application->pa_division_bn ?? '---' }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="pa_division_bn_correction_message">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-2 py-2">
                                                <span class="{{ INFO_LABEL_CLASSES }} label-ca_district_bn label-pa_district_bn">জেলা</span>
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="ca_district_bn" name="corrections[ca_district_bn][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[ca_district_bn][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ $application->ca_district_bn ?? '---' }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="ca_district_bn_correction_message">
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="pa_district_bn" name="corrections[pa_district_bn][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[pa_district_bn][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ $application->pa_district_bn ?? '---' }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="pa_district_bn_correction_message">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-2 py-2">
                                                <span class="{{ INFO_LABEL_CLASSES }} label-ca_upazilla_bn label-pa_upazilla_bn">উপজেলা/থানা</span>
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="ca_upazilla_bn" name="corrections[ca_upazilla_bn][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[ca_upazilla_bn][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ $application->ca_upazilla_bn ?? '---' }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="ca_upazilla_bn_correction_message">
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="pa_upazilla_bn" name="corrections[pa_upazilla_bn][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[pa_upazilla_bn][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ $application->pa_upazilla_bn ?? '---' }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="pa_upazilla_bn_correction_message">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-2 py-2">
                                                <span class="{{ INFO_LABEL_CLASSES_EN }} label-ca_upazilla label-pa_upazilla">Upazilla/Police Station</span>
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES_EN }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="ca_upazilla" name="corrections[ca_upazilla][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[ca_upazilla][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ $application->ca_upazilla ?? '---' }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="ca_upazilla_correction_message">
                                            </td>
                                            <td class="py-2 {{ INFO_CLASSES_EN }}">
                                                <div class="form-check form-check-custom form-check-danger d-inline-block">
                                                    <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="pa_upazilla" name="corrections[pa_upazilla][message]" type="checkbox" value="" />
                                                    <input type="checkbox" name="corrections[pa_upazilla][isCorrected]" value="0" hidden>
                                                </div>
                                                <span>{{ $application->pa_upazilla ?? '---' }}</span>
                                                <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="pa_upazilla_correction_message">
                                            </td>
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
                                @foreach ($application->documents?->chunk(2) as $chunk)
                                <div class="row row-cols-1 row-cols-md-2 g-5 g-xl-8">
                                    @foreach ($chunk as $document)
                                    <div class="col">
                                        <div class="form-check form-check-custom form-check-danger d-inline-block">
                                            <input class="form-check-input cursor-pointer" onchange="toggleMessage(this)" data-field-name="document-{{ $document->required_document_id }}" name="corrections[document-{{ $document->required_document_id }}][message]" type="checkbox" value="" />

                                            <input type="checkbox" name="corrections[document-{{ $document->required_document_id }}][isCorrected]" value="0" hidden>
                                        </div>
                                        <div class="min-h-100px min-h-md-50px fs-6 fw-bold required mb-4 label-document-{{ $document->required_document_id }}">{{ $document->document_name }}</div>
                                        <a href="{{ str_replace('localhost', 'localhost:'.env('LOCAL_PORT'), $document->getFirstMediaUrl('document')) }}" target="_blank" class="shadow p-2 d-block image-input-wrapper rounded w-200px h-250px position-relative" id="imageWrapper{{ $document->trade_license_required_document_id }}" style="background-image: url({{ str_replace('localhost', 'localhost:'.env('LOCAL_PORT'), $document->getFirstMediaUrl('document', 'document-preview')) }}); background-position: 50% 0%;">
                                            @if($document->media?->first()?->mime_type == 'application/pdf')
                                            <i class="fs-3x border border-danger bg-white p-2 rounded position-absolute fas fa-file-pdf text-danger" aria-hidden="true" style="left: 15px; bottom: 15px;"></i>
                                            @else
                                            <i class="fs-3x border border-success bg-white p-2 rounded position-absolute fas fa-file-image text-success" aria-hidden="true" style="left: 15px; bottom: 15px;"></i>
                                            @endif

                                        </a>
                                        <input type="text" placeholder="মন্তব্য" oninput="setMessage(this)" class="{{ MSG_INPUT_CLASSES }}" id="document-{{ $document->required_document_id }}_correction_message">
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::Card-->

                        @canany(['update-business-category', 'update-sign-board-fee'])
                        <!--begin::Card-->
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>পরিবর্তনযোগ্য তথ্য</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <div class="card-body">
                                <div class="row row-cols-1">
                                    @can('update-business-category')
                                    <div class="col mb-3">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-4">
                                            <!--begin::Label-->
                                            <label class="fs-6 text-gray-900 fw-bold mb-2 required">
                                                ব্যবসার ধরন/লাইসেন্স ফি
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="input-group flex-nowrap">
                                                <div class="input-group-text">
                                                    <i class="fal fa-shop fs-3"></i>
                                                </div>
                                                <div class="w-100">
                                                    <select type="text" class="form-control font-kohinoor text-gray-900 form-select" name="business_category_id" required>
                                                        <option value="">ব্যবসার ধরন নির্বাচন করুন</option>
                                                        @foreach ($businessCategories as $cat)
                                                            <option value="{{ $cat->id }}" @selected($application->business_category_id == $cat->id) >{{ $cat->name_bn }} - {{ Helpers::convertToBanglaDigits(number_format(round($cat->fee), 0, ',')) }} টাকা</option>
                                                        @endforeach
                                                    </select> 
                                                </div>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        @error('business_category_id')
                                        <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <!--end::Input group-->
                                    </div>
                                    @endcan

                                    @can('update-sign-board-fee')
                                    <div class="col">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-4">
                                            <!--begin::Label-->
                                            <label class="fs-6 text-gray-900 fw-bold mb-2 required">
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
                                                            <option value="{{ $item->id }}" @selected($application->signboard_id == $item->id)>
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
                                    @endcan
                                </div>
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::Card-->
                        @endcanany
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
