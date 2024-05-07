@extends('user.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>আবেদন সমূহ</title>
@endsection
<!--end::Page Title-->

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
                        <div class="text-gray-800 fw-normal font-ador">
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
                    <input type="text" data-kt-filemanager-table-filter="search" class="form-control w-250px ps-15 font-bn" placeholder="আবেদন সার্চ করুন" />
                </div>
                <!--end::Search--> 
            </div>
    
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-filemanager-table-toolbar="base">
                    <!--begin::Category-->
                    <button class="btn btn-flex btn-light-success" id="kt_drawer_chat_toggle">
                        <i class="ki-duotone ki-burger-menu-5 fs-6 me-1">
                        </i>
                        ক্যাটেগরি সমূহ
                    </button>
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
                    <tr class="text-start text-gray-700 fw-bold fs-6 text-uppercase gs-0">
                        <th class="">প্রতিষ্ঠান</th>
                        <th class="">স্বত্বাধিকারী</th>
                        <th class="">সাইজ</th>
                        <th class="">সর্বশেষ আপডেট</th>
                        <th class=""></th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @foreach($applications as $application)
                    <tr>
                        <td class="py-1 {{ $loop->first ? 'pt-4' : '' }}">
                            <div class="d-flex align-items-center">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-50px me-5">
                                    <span class="symbol-label bg-light-primary border border-primary border-dashed">
                                        <i class="fal fa-landmark fs-2x text-primary"></i>
                                    </span>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Text-->
                                <div class="d-flex flex-column">
                                    <span class="text-dark fs-5 fw-semibold d-block font-bn">{{ $application->business_organization_name_bn }}</span>
                                    <span class="text-gray-800 fs-6 font-roboto">{{ $application->business_organization_name }}</span>
                                </div>
                                <!--end::Text-->
                            </div>
                        </td>
                        <td class="py-1">
                            <div class="d-flex align-items-center">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-50px me-5">
                                    <img src="{{ $ }}" alt="">
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Text-->
                                <div class="d-flex flex-column">
                                    <span class="text-dark fs-5 fw-semibold d-block font-bn">{{ $application->business_organization_name_bn }}</span>
                                    <span class="text-gray-800 fs-6 font-roboto">{{ $application->business_organization_name }}</span>
                                </div>
                                <!--end::Text-->
                            </div>
                        </td>
                        <td class="py-1 font-bn" data-order=""></td>
                        <td class="py-1 font-bn">
                        </td>
                        <td class="text-end py-1" data-kt-filemanager-table="action_dropdown">
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
                        { data: 'name'},
                        { data: 'category'},
                        { data: 'size'},
                        { data: 'date', orderable: false },
                        { data: 'action' },
                    ],
                    conditionalPaging: true
                };

                // Define datatable options to load
                var loadOptions;
                loadOptions = filesListOptions;

                // Init datatable --- more info on datatables: https://datatables.net/manual/
                datatable = $(table).DataTable(loadOptions);
            }

            // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
            const handleSearchDatatable = () => {
                const filterSearch = document.querySelector('[data-kt-filemanager-table-filter="search"]');
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
