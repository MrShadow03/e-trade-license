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
                        <th class="">প্রতিষ্ঠান</th>
                        <th class="">স্বত্বাধিকারী</th>
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
                        <td class="py-1 {{ $loop->first ? 'pt-4' : '' }}">
                            <div class="d-flex align-items-center">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-50px me-5">
                                    <span class="symbol-label bg-light-{{ $data['theme'] }} border border-{{ $data['theme'] }} border-dashed">
                                        <i class="fal fa-landmark fs-2x text-{{ $data['theme'] }}"></i>
                                    </span>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Text-->
                                <div class="d-flex flex-column">
                                    <span class="text-dark fs-5 fw-semibold font-bn">{{ $application->business_organization_name_bn }} 
                                        {{-- <i class="far {{ $data['icon'] }} fs-6 text-{{ $data['theme'] }}"></i> --}}
                                    </span>
                                    <span class="text-gray-800 fs-6 font-roboto">{{ $application->business_organization_name }}</span>
                                </div>
                                <!--end::Text-->
                            </div>
                        </td>
                        <td class="py-1">
                            <div class="d-flex align-items-center">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-50px me-5">
                                    <img src="{{ str_replace('localhost', 'localhost:'.env('LOCAL_PORT'), $application->getFirstMediaUrl('owner_image', 'thumb')) }}" alt="">
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Text-->
                                <div class="d-flex flex-column">
                                    <span class="text-dark fs-5 fw-semibold d-block font-bn">{{ $application->owner_name_bn }}</span>
                                    <span class="text-gray-800 fs-6 font-roboto">{{ $application->owner_name }}</span>
                                </div>
                                <!--end::Text-->
                            </div>
                        </td>
                        <td class="py-1">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-square badge-{{ $data['theme'] }}">
                                    <i class="far {{ $data['icon'] }} fs-6 text-light"></i>
                                </span>
                                <span class="text-{{ $data['theme'] }} fs-5 font-bn ms-2">{{ $data['msg_bn'] }}</span>
                            </div>
                        </td>
                        <td class="text-end py-1" data-kt-filemanager-table="action_dropdown">
                            <div class="d-flex justify-content-end">
                                <a href="#" class="btn btn-success btn-icon btn-sm me-1" data-bs-toggle="tooltip" title="ট্রেড লাইসেন্স দেখুন">
                                    <i class="fal fa-memo-circle-check fs-4"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-icon btn-sm me-1" data-bs-toggle="tooltip" title="ভুল তথ্য সংশোধন করুন">
                                    <i class="fal fa-warning fs-4"></i>
                                </a>
                                <a href="#" class="btn btn-primary btn-icon btn-sm me-1" data-bs-toggle="tooltip" title="লাইসেন্স ফি পরিশোধ করুন">
                                    <i class="far fa-bangladeshi-taka-sign fs-4"></i>
                                </a>
                                <a href="#" class="btn btn-warning btn-icon btn-sm me-1" data-bs-toggle="tooltip" title="ফর্ম ফি পরিশোধ করুন">
                                    <i class="far fa-bangladeshi-taka-sign fs-4"></i>
                                </a>
                                <a href="{{ route('user.trade_license_applications.show', $application->id) }}" class="btn btn-light-info btn-icon btn-sm me-1" data-bs-toggle="tooltip" title="বিস্তারিত দেখুন">
                                    <i class="fal fa-eye fs-4"></i>
                                </a>
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
    function submitForm(form, event, title){
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
