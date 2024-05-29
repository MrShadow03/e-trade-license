@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>Dashboard | Admin</title>
@endsection
<!--end::Page Title-->

<!--begin::toolbar-->
@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">

        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl container-fluid d-flex flex-stack">

            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fs-3 flex-column justify-content-center my-0 font-ador fw-semibold">
                    স্বাগতম, {{ Auth::user()->name }}!
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
<div id="kt_app_content_container" class="app-container container-fluid container-xxl font-bn">
    <div class="row g-5 g-xl-8">
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div class="card-body">
                    <i class="far fa-file-certificate text-primary fs-2x ms-n1"></i>        
            
                    <div class="text-primary fw-semibold fs-2 mb-2 mt-5 font-kohinoor">           
                        ১২০০ টি
                    </div>
            
                    <div class="fw-semibold text-gray-800">মোট ট্রেড লাইসেন্স</div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
        </div>
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div class="card-body">
                    <i class="far fa-file-certificate text-success fs-2x ms-n1"></i>        
            
                    <div class="text-success fw-semibold fs-2 mb-2 mt-5 font-kohinoor">           
                        ৮২১ টি
                    </div>
            
                    <div class="fw-semibold text-gray-800">কার্যকরী ট্রেড লাইসেন্স</div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
        </div>
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div class="card-body">
                    <i class="far fa-file-certificate text-danger fs-2x ms-n1"></i>        
                    
                    <div class="text-danger fw-semibold fs-2 mb-2 mt-5 font-kohinoor">           
                        ৩৭৯ টি
                    </div>
            
                    <div class="fw-semibold text-gray-800">নবায়নযোগ্য ট্রেড লাইসেন্স</div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
        </div>
        <div class="col-xl-3">
            <!--begin::Statistics Widget 5-->
            <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                <!--begin::Body-->
                <div class="card-body">                    
                    <i class="far fa-file-certificate text-success fs-2x ms-n1"></i>        
                    <div class="mb-2 mt-5">
                        <span class="text-success fs-2 font-kohinoor fw-semibold me-2">৬৮%</span>
                        <span class="fw-semibold text-muted fs-7">কার্যকরী</span>
                    </div>
                    {{-- bg-opacity-50 --}}
                    <div class="progress h-7px bg-danger mt-1">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 68%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
        </div>
    </div>
    <div class="row g-5 g-xl-8">
        <div class="col-xl-4">
            <!--begin::Tables Widget 1-->
            <div class="card card-xl-stretch mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-4 mb-1">কাজের অগ্রগতি</span>
                        <span class="text-muted fw-semibold fs-7 font-kohinoor">৩০ দিনের মধ্যে</span>
                    </h3>
                    <div class="card-toolbar">
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle gs-0 gy-5">
                            <!--begin::Table head-->
                            <thead>
                                <tr>
                                    <th class="p-0"></th>
                                    <th class="p-0 min-w-150px"></th>
                                    <th class="p-0 min-w-100px"></th>
                                </tr>
                            </thead>
                            <!--end::Table head-->

                            <!--begin::Table body-->
                            <tbody>
                                <tr>
                                    <th class="pe-0 py-2">
                                        <div class="symbol symbol-40px">
                                            <span class="symbol-label bg-light-primary">
                                                <i class="fas fa-user fs-2 text-primary"></i>
                                            </span>
                                        </div>
                                    </th>

                                    <td class="py-2">
                                        <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">মোঃ আব্দুল কাদের</a>
                                        <span class="text-muted fw-semibold d-block fs-7 font-kohinoor">২ নং ওয়ার্ড
                                    </td>

                                    <td class="py-2">
                                        <div class="d-flex flex-column me-2">
                                            <div class="d-flex flex-stack mb-2">
                                                <span class="text-muted me-2 fs-7 fw-bold">
                                                    ৩০%
                                                </span>
                                            </div>
                                            
                                            <div class="progress h-6px w-100 bg-danger">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>       
                                <tr>
                                    <th class="pe-0 py-2">
                                        <div class="symbol symbol-40px">
                                            <span class="symbol-label bg-light-primary">
                                                <i class="fas fa-user fs-2 text-primary"></i>
                                            </span>
                                        </div>
                                    </th>

                                    <td class="py-2">
                                        <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">মোঃ কামরুল হক</a>
                                        <span class="text-muted fw-semibold d-block fs-7 font-kohinoor">১ নং ওয়ার্ড
                                    </td>

                                    <td class="py-2">
                                        <div class="d-flex flex-column me-2">
                                            <div class="d-flex flex-stack mb-2">
                                                <span class="text-muted me-2 fs-7 fw-bold">
                                                    ৪৮%
                                                </span>
                                            </div>
                                            
                                            <div class="progress h-6px w-100 bg-danger">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 48%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="pe-0 py-2">
                                        <div class="symbol symbol-40px">
                                            <span class="symbol-label bg-light-primary">
                                                <i class="fas fa-user fs-2 text-primary"></i>
                                            </span>
                                        </div>
                                    </th>

                                    <td class="py-2">
                                        <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">মোঃ রফিকুল ইসলাম</a>
                                        <span class="text-muted fw-semibold d-block fs-7 font-kohinoor">৪ নং ওয়ার্ড</span>
                                    </td>

                                    <td class="py-2">
                                        <div class="d-flex flex-column me-2">
                                            <div class="d-flex flex-stack mb-2">
                                                <span class="text-muted me-2 fs-7 fw-bold">
                                                    ৬২%
                                                </span>
                                            </div>
                                            
                                            <div class="progress h-6px w-100 bg-danger">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 62%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="pe-0 py-2">
                                        <div class="symbol symbol-40px">
                                            <span class="symbol-label bg-light-primary">
                                                <i class="fas fa-user fs-2 text-primary"></i>
                                            </span>
                                        </div>
                                    </th>

                                    <td class="py-2">
                                        <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">মোঃ কামরুল হক</a>
                                        <span class="text-muted fw-semibold d-block fs-7 font-kohinoor">১ নং ওয়ার্ড
                                    </td>

                                    <td class="py-2">
                                        <div class="d-flex flex-column me-2">
                                            <div class="d-flex flex-stack mb-2">
                                                <span class="text-muted me-2 fs-7 fw-bold">
                                                    ৪৮%
                                                </span>
                                            </div>
                                            
                                            <div class="progress h-6px w-100 bg-danger">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 48%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="pe-0 py-2">
                                        <div class="symbol symbol-40px">
                                            <span class="symbol-label bg-light-primary">
                                                <i class="fas fa-user fs-2 text-primary"></i>
                                            </span>
                                        </div>
                                    </th>

                                    <td class="py-2">
                                        <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">মোঃ আব্দুল কাদের</a>
                                        <span class="text-muted fw-semibold d-block fs-7 font-kohinoor">২ নং ওয়ার্ড
                                    </td>

                                    <td class="py-2">
                                        <div class="d-flex flex-column me-2">
                                            <div class="d-flex flex-stack mb-2">
                                                <span class="text-muted me-2 fs-7 fw-bold">
                                                    ৩০%
                                                </span>
                                            </div>
                                            
                                            <div class="progress h-6px w-100 bg-danger">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
                <!--end::Body-->
            </div>
            <!--endW::Tables Widget 1-->
        </div>
        <div class="col-xl-4"></div>
        <div class="col-xl-4"></div>
    </div>
</div>
@endsection
<!--end::Main Content-->