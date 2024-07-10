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
                            মোট আবেদন সংখ্যা: {{ Helpers::convertToBanglaDigits($applicationsCount) }} টি
                        </div> 
                    </div>
                    <!--end::Title-->
                </div>
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="fal fa-search fs-3 position-absolute ms-6"></i>
                    <input type="text" data-application-table-filter="search" class="form-control w-250px ps-15 font-bn" placeholder="আবেদন সার্চ করুন" />
                </div>
                <!--end::Search--> 
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pb-0">
        </div>
        <!--end::Card body-->
    </div>
    <div class="card card-flush mb-10">

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
                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
</div>
@endsection
<!--end::Main Content-->
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button,
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_info {
        font-family: 'Kohinoor', sans-serif;
    }
    .dataTables_wrapper .row {
        padding-top: 18px;
        border-top: 1px solid #e0e0e057;
    }
    .dataTables_info {
        padding-left: 15px;
    }
</style>
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
                "processing": false,
                "serverSide": true,
                "ajax": "{{ route('admin.datatable.trade_license_applications') }}",
                "info": true,
                'order': [],
                'pageLength': 15,
                'lengthMenu': [5, 10, 15, 20, 25, 30, 50, 100, 200, 500, 1000],
                'autoWidth': false,
                'scrollX': false,
                "lengthChange": true,
                "searching": true,
                'ordering': true,
                'columns': [
                    { 
                        data: 'owner', 
                        name: 'owner', 
                        orderable: true, 
                        createdCell: function (td, cellData, rowData, row, col) {
                            let padding = 'py-2';
                            if(row === 0){
                                padding = 'pt-4';
                            }
                            $(td).addClass(padding+'');
                        }
                    },
                    {
                        data: 'organization',
                        name: 'organization',
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).addClass('py-2');
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).addClass('py-2');
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).addClass('text-end py-2');
                        }
                    },
                ],
                conditionalPaging: true,
                language: {
                    paginate: {
                        previous: 'পূর্ববর্তী',
                        next: 'পরবর্তী',
                    },
                    info: "_START_ থেকে _END_ পর্যন্ত | মোট _TOTAL_ টি ফলাফল",
                    // lengthMenu: "_MENU_ ফলাফল দেখান",
                    zeroRecords: "কোনো ফলাফল পাওয়া যায়নি",
                    infoEmpty: "কোনো ফলাফল পাওয়া যায়নি",
                    infoFiltered: "(মোট _MAX_ ফলাফল থেকে ফিল্টার করা হয়েছে)",
                },
                drawCallback: function(settings) {
                    // Function to convert numbers to Bangla digits
                    function convertToBanglaDigits(number) {
                        const banglaDigits = {
                            '0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪',
                            '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯'
                        };
                        return number.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
                    }

                    // Update pagination numbers
                    $('a.page-link').each(function() {
                        const originalText = $(this).text();
                        const banglaText = convertToBanglaDigits(originalText);
                        $(this).text(banglaText);
                    });

                    // Update page length
                    $('select[name="kt_file_manager_list_length"] option').each(function() {
                        const originalText = $(this).text();
                        const banglaText = convertToBanglaDigits(originalText);
                        $(this).text(banglaText);
                    });

                    // Update info text
                    const infoText = $('.dataTables_info').text();
                    const banglaInfoText = convertToBanglaDigits(infoText);
                    $('.dataTables_info').text(banglaInfoText);

                    // // update loading text
                    // const loadingText = $('.dataTables_processing').text();
                    // const banglaLoadingText = 'অপেক্ষা করুন...';
                    // $('.dataTables_processing').text(banglaLoadingText);
                }
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
            let tableBody = table.querySelector('tbody');
            let blockUI = new KTBlockUI(tableBody);
            const filterSearch = document.querySelector('[data-application-table-filter="search"]');
            filterSearch.addEventListener('keyup', function (e) {
                datatable.search(e.target.value).draw();
            });
            datatable.on('processing.dt', function (e, settings, processing) {
                if (processing) {
                    if (!blockUI.isBlocked()) {
                        blockUI.block();
                    }
                }else{
                    blockUI.release();
                }
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
