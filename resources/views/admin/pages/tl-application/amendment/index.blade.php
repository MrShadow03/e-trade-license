@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>সংশোধন আবেদন সমূহ</title>
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
                            সংশোধন আবেদন সমূহ
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
                        $data = Helpers::convertAmendmentStatusToBangla($application->getActiveAmendment()?->status);
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
                                        <span class="text-{{ $data['theme'] }} fs-5 font-bn">{{ $data['msg_bn_admin'] }}</span>
                                        <span class="text-gray-600 fs-7 mt-1">{{ Helpers::convertToBanglaDigits(Carbon\Carbon::parse($application->getActiveAmendment()?->updated_at)->locale('bn-BD')->diffForHumans())}}</span>
                                    </div>
                                    <!--end::Text-->
                                </div>
                            </div>
                        </td>
                        
                        <td class="text-end py-2" data-kt-filemanager-table="action_dropdown">
                            <div class="d-flex justify-content-end">
                                @if (auth()->user()->can('verify-amendment-fee-payment') && $application->getActiveAmendment()?->status === Helpers::PENDING_AMENDMENT_FEE_VERIFICATION)
                                <a href="#" class="btn btn-success btn-icon btn-sm me-1" data-bs-toggle="modal" data-bs-target="#view_payment_details" title="ফর্ম ফি নিশ্চিত করুন" 
                                onclick="enterPaymentData({{ json_encode($application->getAmendmentFeePayment()) }}, '{{ Helpers::getImageUrl($application->getAmendmentFeePayment(), 'amendment-fee-payment-slip') }}')">
                                    <i class="far fa-bangladeshi-taka-sign fs-4"></i>
                                </a>
                                @endif

                                @if (auth()->user()->can('approve-pending-amendment-approval-applications') && $application->getActiveAmendment()?->status === Helpers::PENDING_AMENDMENT_APPROVAL)
                                <a href="{{ route('admin.trade_license_applications.inspect.amendment', $application->id) }}" class="btn btn-success btn-icon btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="left" title="সংশোধন যাচাই করুন">
                                    <i class="fal fa-file-search fs-4"></i>
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

@section('exclusive_modals')
<div class="modal fade" id="view_payment_details" tabindex="-1" aria-hidden="true">
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
                        পেমেন্ট নিশ্চিত করুন
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
            <div class="modal-body scroll-y m-5">
                <table class="table table-striped align-middle table-row-dashed fs-6 gy-5 dt-table font-kohinoor">
                    <tbody class="fw-bold text-gray-600">
                        <tr>
                            <td class="text-gray-800 ps-1 py-2">ব্যাংক</td>
                            <td class="text-gray-800 py-2 fw-normal" id="bank"></td>
                        </tr>
                        <tr>
                            <td class="text-gray-800 ps-1 py-2">ব্রাঞ্চ</td>
                            <td class="text-gray-800 py-2 fw-normal" id="bankBranch"></td>
                        </tr>
                        <tr>
                            <td class="text-gray-800 ps-1 py-2">চালান নম্বর</td>
                            <td class="text-gray-800 py-2 fs-5 ls-2 fw-normal" id="bankInvoiveNo"></td>
                        </tr>
                        <tr>
                            <td class="text-gray-800 ps-1 py-2">টাকার পরিমান</td>
                            <td class="text-success py-2 fs-3 fw-bold" id="amount"></td>
                        </tr>
                        <tr>
                            <td class="text-gray-800 ps-1 py-2">ড্রাফটের ছবি</td>
                            <td class="py-2">
                                <a href="#" id="draftImageUrl" target="_blank" rel="noopener noreferrer">
                                    <img class="shadow w-200px object-fit-contain" src="{{ asset('assets/img/blank-image.svg') }}" alt="bank draft image" id="draftImage">
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!--begin::Actions-->
                <form action="{{ route('admin.trade_license_applications.verify_amendment_fee_payment') }}" method="POST" class="text-center font-bn mt-8">
                    @csrf
                    @method('POST')
                    <div class="fv-row mb-10">
                        <label class="text-start d-block fw-bold fs-5 text-gray-800 mb-3">আপনার মন্তব্য</label>
                        <textarea name="message" class="font-kohinoor text-dark fw-normal form-control fs-4" rows="3" placeholder="আপনার মন্তব্য লিখুন (যদি থাকে)"></textarea>
                    </div>
                    <input type="hidden" name="application_id" id="applicationId">
                    <input type="hidden" name="isVerified">
                    <button type="button" class="btn btn-danger" onclick="submitForm(event, 0)">
                        <span class="indicator-label">
                            প্রত্যাখ্যান করুন
                        </span>
                        <span class="indicator-progress">
                            অপেক্ষা করুন...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <button type="button" class="btn btn-success ms-3" onclick="submitForm(event, 1)">
                        <span class="indicator-label">
                            নিশ্চিত করুন
                        </span>
                        <span class="indicator-progress">
                            অপেক্ষা করুন...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </form>
                <!--end::Actions-->
            </div>
            <!--begin::Modal body-->
        </div>
    </div>
</div>
@endsection

@section('exclusive_scripts')
<script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>    
    const enterPaymentData = (paymentData, imageUrl) => {
        document.getElementById('bank').innerText = paymentData.bank;
        document.getElementById('bankBranch').innerText = paymentData.bank_branch;
        document.getElementById('bankInvoiveNo').innerText = paymentData.bank_invoice_no;
        document.getElementById('amount').innerText = convertToBanglaDigits(paymentData.amount);
        document.getElementById('draftImageUrl').href = imageUrl
        document.getElementById('draftImage').src = imageUrl
        document.getElementById('applicationId').value = paymentData.trade_license_application_id;
    }

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

    const submitForm = (event, isVerified) => {
        event.preventDefault();
        const form = event.target.closest('form');
        
        if (isVerified) {
            form.querySelector('input[name="isVerified"]').value = 1;

            Swal.fire({
                title: `পেমেন্ট নিশ্চিত করতে চান?`,
                text: "আবেদনকারীর পেমেন্ট নিশ্চিত করা হবে।",
                icon: "info",
                iconHtml: '<i class="fas fa-file-check fs-2x text-success"></i>',
                showCancelButton: true,
                cancelButtonText: 'না',
                confirmButtonText: "হ্যাঁ, নিশ্চিত করুন!",
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
                }
            });

        } else {
            form.querySelector('input[name="isVerified"]').value = 0;

            Swal.fire({
                title: `পেমেন্ট প্রত্যাখ্যান করতে চান?`,
                text: "আবেদনকারীকে পুনরায় পেমেন্ট সাবমিট করতে বলা হবে।",
                icon: "error",
                iconHtml: '<i class="fas fa-file-xmark fs-2x text-danger"></i>',
                showCancelButton: true,
                cancelButtonText: 'না',
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
