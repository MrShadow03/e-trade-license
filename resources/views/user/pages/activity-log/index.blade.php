@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>Activity Log</title>
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

        .show-child {
            display: table-row-group !important;
        }

        .image-input-placeholder {
            background-image: url('{{ asset('assets/admin/assets/media/svg/avatars/blank.svg') }}');
        }

        [data-bs-theme="dark"] .image-input-placeholder {
            background-image: url('{{ asset('assets/admin/assets/media/svg/avatars/blank-dark.svg') }}');
        }
        #products_table_filter{
            display: none;
        }
        .dt-buttons{
            text-align: end !important;
        }
    </style>
@endsection
<!--end::Page Custom Styles-->

<!--begin::Main Content-->
@section('content')
<div id="kt_app_content_container" class="app-container container-fluid">
    <div class="card card-flush pb-0 bgi-position-y-center bgi-no-repeat mb-10 mt-5">
        <!--begin::Card header-->
        <div class="card-header pt-10">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="symbol symbol-circle me-5">
                        <div class="symbol-label bg-transparent text-primary border border-secondary border-dashed">
                            <i class="ki-duotone ki-information fs-2x text-primary">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>                
                        </div>
                    </div>
                    <!--end::Icon-->
    
                    <!--begin::Title-->
                    <div class="d-flex flex-column">
                        <h2 class="font-bn">
                            সফটওয়্যার ব্যবহার লগ
                        </h2>
                        <div class="text-muted fw-bold font-noto">
                            সর্বমোট লগ: {{ App\Helpers\Helpers::convertToBanglaDigits($logs->count()) }} টি |
                            সর্বশেষ লগ: {{ App\Helpers\Helpers::convertToBanglaDigits(Carbon\Carbon::parse($logs?->first()?->created_at)->locale('bn-BD')->diffForHumans()) }}
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
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header align-items-center py-5 gap-2 gap-md-5 print-display-none">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-transaction-filter="search" class="form-control w-250px ps-12 print-display-none font-bn" placeholder="সার্চ করুন">
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
    
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5 print-display-none">
                <!--begin::Flatpickr-->
                <div class="input-group w-250px print-display-none">
                    <input class="form-control rounded rounded-end-0 font-bn" placeholder="তারিখ নির্বাচন করুন" id="transactions_flatpickr_input" />
                    <button class="btn btn-icon btn-light" id="transactions_flatpickr_clear">
                        <i class="ki-duotone ki-cross fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>
                </div>
                <!--end::Flatpickr-->
                <!--begin::filter transaction-->
                <div class="w-100 mw-150px print-display-none">
                    <!--begin::Select2-->
                    <select class="form-select font-bn" data-control="select2" data-placeholder="ধরন নির্বাচন করুন" data-transaction-filter="type">
                        <option></option>
                        <option value="all">সকল</option>
                        @foreach ($logs->unique('subject_type') as $log)
                        @php
                            $type = App\Helpers\Helpers::translateSubject($log->subject_type);
                        @endphp
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                </div>
                <!--end::filter transaction-->
                <!--begin::filter customer-->
                <div class="w-100 mw-200px print-display-none">
                    <!--begin::Select2-->
                    <select class="form-select font-bn" data-control="select2" data-placeholder="কার্যক্রম নির্বাচন করুন" data-transaction-filter="activity">
                        <option></option>
                        <option value="all">সকল</option>
                        @foreach ($logs->unique('description') as $log)
                            <option value="{{ $log->description }}">{{ App\Helpers\Helpers::translateActivity($log->description) }}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                </div>
                <!--end::filter customer-->
                {{-- <!--begin::Export-->
                <button type="button" class="btn btn-light-primary print-display-none" onclick="toggleDtButtons()">
                    <i class="ki-duotone ki-exit-up fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Export Report
                </button>
                <button type="button" class="btn btn-light-primary print-display-none" onclick="window.print()">
                    <i class="ki-duotone ki-document fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Print
                </button> --}}
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <span class="text-dark fs-1 print-display-show p-10">Due Report - {{ date('d M, Y h:i A') }}</span>
            <table class="table table-striped align-middle table-row-dashed fs-6 gy-5 dt-table font-noto" id="products_table">
                <thead>
                    <tr class="text-start text-gray-600 fw-bold fs-6 text-uppercase gs-0">
                        <th class=" px-2">#</th>
                        <th class="">ধরন</th>
                        <th class="w-md-200px">শিরোনাম / নাম</th>
                        <th class="">কার্যক্রম</th>
                        <th class="">কর্তা</th>
                        <th class="">তারিখ</th>
                        <th class="">সময়</th>
                        <th class="text-end px-2"></th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @php
                        $index = 1;
                    @endphp
                    @foreach ($logs as $log)
                    <tr>
                        <td class="text-gray-500 px-2 py-1" data-order="{{ $index }}">
                            {{ App\Helpers\Helpers::convertToBanglaDigits($index) }}
                        </td>
                        @php
                            $subject = App\Helpers\Helpers::translateSubject($log->subject_type);
                        @endphp
                        <td class="text-gray-700 py-1" data-filter="{{ $subject }}">
                            <span class="fw-semibold">{{ $subject }}</span>
                        </td>
                        <td class="text-gray-700 py-1">
                            <span class="fw-semibold d-inline-block text-truncate" style="max-width: 200px">
                                @if(isset($log->changes['attributes']['title']))
                                    {{ $log->changes['attributes']['title'] }}
                                @elseif(isset($log->changes['attributes']['name']))
                                    {{ $log->changes['attributes']['name'] }}
                                @elseif(isset($log->changes['old']['title']))
                                    {{ $log->changes['old']['title'] }}
                                @elseif(isset($log->changes['old']['name']))
                                    {{ $log->changes['old']['name'] }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </td>
                        <td class="py-1" data-filter="{{ $log->description }}">
                            @if ($log->description == 'created')
                                <span class="badge badge-primary cursor-pointer" title="{{ ucfirst($log->description) }}">{{ App\Helpers\Helpers::translateActivity($log->description) }}</span>
                            @elseif($log->description == 'updated')
                                <span class="badge badge-info cursor-pointer" title="{{ ucfirst($log->description) }}">{{ App\Helpers\Helpers::translateActivity($log->description) }}</span>
                            @elseif($log->description == 'deleted')
                                <span class="badge badge-danger cursor-pointer" title="{{ ucfirst($log->description) }}">{{ App\Helpers\Helpers::translateActivity($log->description) }}</span>
                            @elseif($log->description == 'logged in')
                                <span class="badge badge-success cursor-pointer" title="{{ ucfirst($log->description) }}">{{ App\Helpers\Helpers::translateActivity($log->description) }}</span>
                            @elseif($log->description == 'logged out')
                                <span class="badge badge-warning cursor-pointer" title="{{ ucfirst($log->description) }}">{{ App\Helpers\Helpers::translateActivity($log->description) }}</span>
                            @endif
                        </td>
                        <td class="text-gray-700 py-1" data-filter="{{ $log->causer->id.' '.$log->causer->name}}">
                            <span class="fw-semibold">{{ $log->causer->name }}</span>
                        </td>
                        <td class="text-gray-700 py-1" data-filter="<span>{{ Carbon\Carbon::parse($log->created_at)->format('d/m/Y') }}</span>" data-order="{{ Carbon\Carbon::parse($log->created_at)->format('Y-m-d') }}">
                            {{ App\Helpers\Helpers::convertToBanglaDigits((Carbon\Carbon::parse($log->created_at)->locale('bn-BD')->translatedFormat('d M, Y'))) }}
                        </td>
                        <td class="text-gray-700 py-1">
                            {{ App\Helpers\Helpers::convertToBanglaDigits((Carbon\Carbon::parse($log->created_at)->locale('bn-BD')->translatedFormat('A h:i'))) }}
                        </td>
                        <td class="text-end py-1 px-2">
                            <a href="javascript:;" class="btn btn-light-primary btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#activityLogModal" 
                            onclick="placeActivityLog({{ json_encode([
                                'subject_type' => $subject,
                                'description' => $log->description,
                                'causer' => $log->causer,
                                'created_at' => App\Helpers\Helpers::convertToBanglaDigits((Carbon\Carbon::parse($log->created_at)->locale('bn-BD')->translatedFormat('d M, Y A h:i'))),
                                'attributes' => $log->changes['attributes'] ?? null,
                                'old' => $log->changes['old'] ?? null,
                                'properties' => $log->properties,
                                 ]) }})">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>

                    @php
                        $index++;
                    @endphp
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

<!--begin::Modal-->
@section('exclusive_modals')
<div class="modal fade font-bn" id="activityLogModal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered" style="max-width: min-content !important; min-width: 500px;">
        <!--begin::Modal content-->
        <div class="modal-content rounded">
            <!--begin::Modal header-->
            <div class="modal-header pb-3 mb-8 border-0 justify-content-between bg-light-dark">
                <!--begin::Heading-->
                <div class="text-center">
                   <!--begin::Title-->
                   <h3 class="text-gray-800 fw-semibold fs-4 modal_title"></h3>
                   <!--end::Title-->
               </div>
               <!--end::Heading-->
               <!--begin::Close-->
               <div class="btn btn-sm btn-icon bg-hover-danger text-hover-white" data-bs-dismiss="modal">
                   <i class="ki-solid ki-cross fs-1">
                </i>
               </div>
               <!--end::Close-->
           </div>
           <!--begin::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15" id="canvas">

            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
@endsection


<!--begin::Page Vendors Javascript and custom JS-->
@section('exclusive_scripts')
    <script src="{{ asset('/assets/admin/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        const table = document.querySelector('#products_table');;
        const datatable = $(table).DataTable({
            "info": true,
            'pageLength': 50,
            'lengthChange': true,
            'lengthMenu': [5, 10, 20, 50, 100],
            'dom': 'Bfrtlp',
            'buttons': [
                'copyHtml5',
                'excelHtml5',
            ],
        });

        // Class definition
        var KTAppEcommerceProducts = function () {
            var flatpickr;
            var minDate, maxDate;

            // Init flatpickr --- more info :https://flatpickr.js.org/getting-started/
            var initFlatpickr = () => {
                const element = document.querySelector('#transactions_flatpickr_input');
                flatpickr = $(element).flatpickr({
                    altInput: true,
                    altFormat: "d/m/Y",
                    dateFormat: "Y-m-d",
                    mode: "range",
                    onChange: function (selectedDates, dateStr, instance) {
                        handleFlatpickr(selectedDates, dateStr, instance);
                    },
                });
            }

            var handleSearchDatatable = () => {
                const filterSearch = document.querySelector('[data-transaction-filter="search"]');
                filterSearch.addEventListener('input', function (e) {
                    datatable.search(e.target.value).draw();
                });
            }

            // Handle type filter dropdown
            var handleTypeFilter = () => {
                const filterStatus = document.querySelector('[data-transaction-filter="type"]');
                $(filterStatus).on('change', e => {
                    let value = e.target.value;
                    if(value === 'all'){
                        value = '';
                    }
                    datatable.column(1).search(value ? '^' + value + '$' : '', true, false).draw();
                });
            }

            // Handle activity filter dropdown
            var handleActivityFilter = () => {
                const filterStatus = document.querySelector('[data-transaction-filter="activity"]');
                $(filterStatus).on('change', e => {
                    let value = e.target.value;
                    if(value === 'all'){
                        value = '';
                    }
                    datatable.column(3).search(value ? '^' + value + '$' : '', true, false).draw();
                });
            }
            
            // Handle flatpickr --- more info: https://flatpickr.js.org/events/
            var handleFlatpickr = (selectedDates, dateStr, instance) => {
                minDate = selectedDates[0] ? new Date(selectedDates[0]) : null;
                maxDate = selectedDates[1] ? new Date(selectedDates[1]) : null;

                // Custom filtering function which will search data in column four between two values
                $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var min = minDate;
                        var max = maxDate;
                        var dateAdded = new Date(moment($(data[5]).text(), 'DD/MM/YYYY'));
                        
                        if ((min === null && max === null) || (min <= dateAdded && max === null) || (min === null && max >= dateAdded) || (min <= dateAdded && max >= dateAdded)) {
                            return true;
                        }
                        return false;
                    }
                );
                datatable.draw();
            }

            // Handle clear flatpickr
            var handleClearFlatpickr = () => {
                const clearButton = document.querySelector('#transactions_flatpickr_clear');
                clearButton.addEventListener('click', e => {
                    flatpickr.clear();
                });
            }

            // Public methods
            return {
                init: function () {
                    if (!table) {
                        return;
                    }

                    initFlatpickr();
                    handleClearFlatpickr();
                    handleSearchDatatable();
                    handleTypeFilter();
                    handleActivityFilter();
                }
            };
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTAppEcommerceProducts.init();
        });


        const dtButtons = document.querySelector('.dt-buttons');
        dtButtons.classList.add('d-none');

        function toggleDtButtons(){
            if(dtButtons.classList.contains('d-none')){
                dtButtons.classList.remove('d-none');
            }else{
                dtButtons.classList.add('d-none');
            }
        }

        function placeActivityLog(log){
            const modal = document.querySelector('#activityLogModal');
            const modalBody = modal.querySelector('#canvas');
            const modalTitle = modal.querySelector('.modal_title');
            modalTitle.innerHTML = 'কার্যক্রম লগ';
            modalBody.innerHTML = `
                <table class="table table-striped align-middle table-row-dashed fs-6 gy-5 dt-table font-bn">
                    <tbody class="fw-bold text-gray-600">
                        <tr>
                            <td class="text-gray-800 py-2">ধরন</td>
                            <td class="text-gray-800 py-2 fw-normal">${log.subject_type}</td>
                        </tr>
                        <tr>
                            <td class="text-gray-800 py-2">কার্যক্রম</td>
                            <td class="text-gray-800 py-2 fw-normal">${log.description}</td>
                        </tr>
                        <tr>
                            <td class="text-gray-800 py-2">কর্তা</td>
                            <td class="text-gray-800 py-2 fw-normal">${log.causer.name}</td>
                        </tr>
                        <tr>
                            <td class="text-gray-800 py-2">তারিখ</td>
                            <td class="text-gray-800 py-2 fw-normal">${log.created_at}</td>
                        </tr>
                        ${log.attributes['ip'] ? `<tr>
                            <td class="text-gray-800 py-2">আইপি ঠিকানা</td>
                            <td class="text-gray-800 py-2 fw-normal">${log.attributes['ip']}</td>
                        </tr>` : ''}
                    </tbody>
                </table>
                <div class="separator separator-content my-10">
                    <span class="fs-7 fw-semibold text-gray-600">পরিবর্তন</span>
                </div>
                <table class="table table-striped align-middle table-row-dashed fs-6 gy-5 dt-table font-bn">
                    <thead>
                        <tr class="text-start text-gray-800 fw-bold fs-6 text-uppercase gs-0">
                            <th class="px-2"></th>
                            <th class="px-2">পুরানো</th>
                            <th class="px-2">নতুন</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        ${log.attributes ? Object.keys(log.attributes).map(key => {

                            // if the log does not have old key then then log.old[key] will be null
                            if(log.old == null){
                                log.old = {};
                            }

                            $bothAreNull = log.attributes[key] == null && log.old[key] == null;
                            $bothAreSame = log.attributes[key] == log.old[key];

                            if($bothAreNull || $bothAreSame){
                                return '';
                            }else{
                                return `<tr class="px-2">
                                            <td class="text-gray-800 fw-bold ps-2 py-2">${key}</td>
                                            <td class="text-gray-800 fw-normal py-2">${log.old[key] ?? '---'}</td>
                                            <td class="text-gray-800 fw-normal py-2">${log.attributes[key] ?? ''}</td>
                                        </tr>`;
                            }

                        }).join('') : ''}
                    </tbody>
                </table>

            `;
        }

    </script>
@endsection
<!--end::Page Vendors Javascript and custom JS-->
