@extends('user.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>{{ auth()->user()->name }}'s Profile | Admin</title>
@endsection
<!--end::Page Title-->

<!--begin::Page Custom Styles(used by this page)-->
@section('exclusive_styles')
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/admin/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assets/admin/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css">
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
    const INFO_LABEL_CLASSES = 'fw-bold text-label fs-6';
    const INFO_CLASSES = 'fs-4 text-dark fw-medium font-kohinoor';
    const INFO_LABEL_CLASSES_EN = 'fw-semibold text-label-en fs-6 font-roboto';
    const INFO_CLASSES_EN = 'fs-4 text-dark font-roboto';
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
                                <li class="breadcrumb-item"><a href="{{ route('user.trade_license_applications') }}" class="">আবেদন সমূহ</a></li>
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
                                <img src="{{ str_replace('localhost', 'localhost:'.env('LOCAL_PORT'), $application->getFirstMediaUrl('owner_image')) }}" alt="" class="object-fit-cover">
                            </div>
                            <!--end::Avatar-->

                            <!--begin::Name-->
                            <a href="#" class="fs-3 text-dark text-hover-primary fw-bold mb-1">{{ $application->owner_name_bn }}</a>
                            <!--end::Name-->

                            <!--begin::Email-->
                            <a href="#" class="fs-6 fw-semibold text-gray-600 text-hover-primary mb-6">+880 {{ $application->phone_no }}</a>
                            <!--end::Email-->
                        </div>
                        <!--end::Summary-->

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
                    <div class="tab-pane fade show active" id="customer_general" role="tabpanel">
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
                                <div class="row g-5 g-xl-8 mb-7">
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES }}">স্বত্বাধিকারীর নাম</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $application->owner_name_bn }}</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES_EN }}">Owner's Name</div>
                                        <div class="{{ INFO_CLASSES_EN }}">{{ $application->owner_name }}</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES }}">পিতার নাম</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $application->father_name_bn }}</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES_EN }}">Father's Name</div>
                                        <div class="{{ INFO_CLASSES_EN }}">{{ $application->father_name }}</div>
                                    </div>
                                </div> 
                                <div class="row g-5 g-xl-8 mb-7">
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES }}">মাতার নাম</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $application->mother_name_bn }}</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES_EN }}">Mother's Name</div>
                                        <div class="{{ INFO_CLASSES_EN }}">{{ $application->mother_name }}</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES }}">স্বামী/স্ত্রীর নাম</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $application->spouse_name_bn }}</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES_EN }}">Spouse's Name</div>
                                        <div class="{{ INFO_CLASSES_EN }}">{{ $application->spouse_name }}</div>
                                    </div>
                                </div> 
                                <div class="row g-5 g-xl-8">
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES }}">জাতীয় পরিচয়পত্র নং</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $application->national_id_no ?? '---' }}</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES }}">জন্ম নিবন্ধন নং</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $application->birth_certificate_no ?? '---' }}</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="{{ INFO_LABEL_CLASSES }}">পাসপোর্ট নং</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $application->passport_no ?? '---' }}</div>
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
                                        <div class="{{ INFO_LABEL_CLASSES }}">ব্যবসা প্রতিষ্ঠান</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $application->business_organization_name_bn }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="{{ INFO_LABEL_CLASSES_EN }}">Business Organization</div>
                                        <div class="{{ INFO_CLASSES_EN }}">{{ $application->business_organization_name }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="{{ INFO_LABEL_CLASSES }}">ব্যবসার প্রকৃতি</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $application->nature_of_business_bn }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="{{ INFO_LABEL_CLASSES_EN }}">Nature of Business</div>
                                        <div class="{{ INFO_CLASSES_EN }}">{{ $application->nature_of_business }}</div>
                                    </div>
                                </div> 
                                <div class="row g-5 g-xl-8 mb-7 row-cols-2 row-cols-md-4">
                                    <div class="col">
                                        <div class="{{ INFO_LABEL_CLASSES }}">লাইসেন্স ফি</div>
                                        <div class="{{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits(number_format((int)$application->businessCategory?->fee, 0, ',')) }} &#2547</div>
                                    </div>
                                    <div class="col">
                                        <div class="{{ INFO_LABEL_CLASSES }}">ব্যবসার ধরন</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $application->businessCategory?->name_bn }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="{{ INFO_LABEL_CLASSES }}">ঠিকানা</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $application->address_of_business_organization_bn }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="{{ INFO_LABEL_CLASSES_EN }}">Address</div>
                                        <div class="{{ INFO_CLASSES_EN }}">{{ $application->address_of_business_organization }}</div>
                                    </div>
                                </div>
                                <div class="row g-5 g-xl-8 mb-7 row-cols-2 row-cols-md-4">
                                    <div class="col">
                                        <div class="{{ INFO_LABEL_CLASSES }}">ওয়ার্ড নং</div>
                                        <div class="{{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits($application->ward_no) }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="{{ INFO_LABEL_CLASSES }}">অঞ্চল</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $application->zone_bn ?? '---' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="{{ INFO_LABEL_CLASSES }}">টি আই এন নং</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $application->tin_no ?? '---' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="{{ INFO_LABEL_CLASSES }}">বি আই এন নং</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $application->bin_no ?? '---' }}</div>
                                    </div>
                                </div>
                                <div class="row g-5 g-xl-8 mb-7 row-cols-2 row-cols-md-4">
                                    <div class="col">
                                        <div class="{{ INFO_LABEL_CLASSES }}">ফোন নম্বর </div>
                                        <div class="{{ INFO_CLASSES }}"><a class="text-dark text-hover-primary" href="tel:{{ $application->phone_no }}">{{ $application->phone_no }}</a></div>
                                    </div>
                                    <div class="col">
                                        <div class="{{ INFO_LABEL_CLASSES }}">ই-মেইল</div>
                                        <div class="{{ INFO_CLASSES }}">{{ $application->email ?? '---' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="{{ INFO_LABEL_CLASSES }}">সাইনবোর্ড</div>
                                        <div class="{{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits($application->signboard?->dimension.' - '.number_format((int)$application->signboard?->charge, 0, ',')) }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="{{ INFO_LABEL_CLASSES }}">ব্যবসা শুরুর তারিখ</div>
                                        <div class="{{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits(Carbon\Carbon::parse($application->business_starting_date)->locale('bn-BD')->translatedFormat('d F, Y')) }}</div>
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
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits($application->ca_holding_no ?? '---') }}</td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits($application->pa_holding_no ?? '---') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES }}">রোড নং</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits($application->ca_road_no ?? '---') }}</td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits($application->pa_road_no ?? '---') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES }}">পোস্ট কোড</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits($application->ca_post_code ?? '---') }}</td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ Helpers::convertToBanglaDigits($application->pa_post_code ?? '---') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES }}">এলাকা/গ্রাম</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $application->ca_village_bn ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $application->pa_village_bn ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES_EN }}">Village</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $application->ca_village ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $application->pa_village ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES }}">ডাকঘর</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $application->ca_post_office_bn ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $application->pa_post_office_bn ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES_EN }}">Post Office</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $application->ca_post_office ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $application->pa_post_office ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES }}">বিভাগ</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $application->ca_division_bn ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $application->pa_division_bn ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES_EN }}">Division</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $application->ca_division ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $application->pa_division ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES }}">জেলা</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $application->ca_district_bn ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $application->pa_district_bn ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES_EN }}">District</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $application->ca_district ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $application->pa_district ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES }}">উপজেলা/থানা</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $application->ca_upazilla_bn ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES }}">{{ $application->pa_upazilla_bn ?? '---' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1">
                                                <span class="{{ INFO_LABEL_CLASSES_EN }}">Upazilla/Police Station</span>
                                            </td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $application->ca_upazilla ?? '---' }}</td>
                                            <td class="py-1 {{ INFO_CLASSES_EN }}">{{ $application->pa_upazilla ?? '---' }}</td>
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
                            <div class="card-body">
                                @foreach ($application->documents?->chunk(2) as $chunk)
                                <div class="row row-cols-1 row-cols-md-2 g-5 g-xl-8">
                                    @foreach ($chunk as $document)
                                    <div class="col">
                                        <div class="min-h-100px min-h-md-50px fs-6 font-kohinoor fw-bold mb-4">{{ $document->document_name }}</div>
                                        <a href="{{ str_replace('localhost', 'localhost:'.env('LOCAL_PORT'), $document->getFirstMediaUrl('document')) }}" target="_blank" class="shadow p-2 d-block image-input-wrapper rounded w-200px h-250px position-relative" id="imageWrapper{{ $document->trade_license_required_document_id }}" style="background-image: url({{ str_replace('localhost', 'localhost:'.env('LOCAL_PORT'), $document->getFirstMediaUrl('document', 'document-preview')) }}); background-position: 50% 0%;">
                                            @if($document->media?->first()?->mime_type == 'application/pdf')
                                            <i class="fs-3x border border-danger bg-white p-2 rounded position-absolute fas fa-file-pdf text-danger" aria-hidden="true" style="left: 15px; bottom: 15px;"></i>
                                            @else
                                            <i class="fs-3x border border-success bg-white p-2 rounded position-absolute fas fa-file-image text-success" aria-hidden="true" style="left: 15px; bottom: 15px;"></i>
                                            @endif

                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end:::Tab pane-->
                </div>
                <!--end:::Tab content-->
            </div>
            <!--end::Content-->
        </div>
    </div>

@endsection
<!--end::Main Content-->
