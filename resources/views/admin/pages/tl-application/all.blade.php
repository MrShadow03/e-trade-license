@extends('admin.layouts.app')
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
                            আবেদন সমূহ
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
                                    <a href="{{ route('admin.trade_license_applications.show', $application->id) }}" class="text-dark text-hover-primary fs-5 fw-bold d-block font-bn">{{ $application->user?->name_bn }}</a>
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
                                        <span class="text-{{ $data['theme'] }} fs-5 font-bn">{{ $data['msg_bn'] }}</span>
                                        <span class="text-gray-600 fs-7 mt-1">{{ Helpers::convertToBanglaDigits(Carbon\Carbon::parse($application->updated_at)->locale('bn-BD')->diffForHumans())}}</span>
                                    </div>
                                    <!--end::Text-->
                                </div>
                            </div>
                        </td>
                        @php
                            if($application->status === Helpers::PENDING_FORM_FEE_VERIFICATION){
                                $paymentSlipCollectionName = 'form-fee-payment-slip';
                            }elseif($application->status === Helpers::PENDING_LICENSE_FEE_VERIFICATION){
                                $paymentSlipCollectionName = 'license-fee-payment-slip';
                            }elseif($application->status === Helpers::PENDING_LICENSE_RENEWAL_FEE_VERIFICATION){
                                $paymentSlipCollectionName = 'license-renewal-'.Helpers::getFiscalYear(date('Y-m-d')).'-fee-payment-slip';
                            }
                        @endphp
                        <td class="text-end py-2" data-kt-filemanager-table="action_dropdown">
                            <div class="d-flex justify-content-end">

                                @if ($application->isValid())
                                <a href="#" class="btn btn-success btn-icon btn-sm me-1" data-bs-toggle="tooltip" title="ট্রেড লাইসেন্স দেখুন">
                                    <i class="fal fa-memo-circle-check fs-4"></i>
                                </a>
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

@section('exclusive_scripts')
<script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>    
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
