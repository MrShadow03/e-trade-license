@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>Notices | Admin</title>
@endsection
<!--end::Page Title-->

<!--begin::Page Custom Styles(used by this page)-->
@section('exclusive_styles')
    <!--begin::Vendor Stylesheets(used for this page only)-->
    {{-- <link href="{{ asset('assets/admin/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css"> --}}
    {{-- <link href="{{ asset('assets/admin/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"> --}}
    <!--end::Vendor Stylesheets-->
    <style>
        tbody.hide-child {
            display: none;
        }

        .show-child {
            display: table-row-group !important;
        }
        .image-input-placeholder {
            background-image: url('{{ asset("assets/admin/assets/media/svg/avatars/blank.svg") }}');
        }

        [data-bs-theme="dark"] .image-input-placeholder {
            background-image: url('{{ asset("assets/admin/assets/media/svg/avatars/blank-dark.svg") }}');
        }

    </style>
@endsection
<!--end::Page Custom Styles-->
<!--begin::Main Content-->
@section('content')
<form action="{{ route('admin.notice.update') }}" id="aritcleForm" method="POST" id="kt_app_content_container" class="app-container container-xxl font-bn">
    @csrf
    @method('PATCH')
    <input type="hidden" name="id" id="noticeID" value="{{ $notice->id }}">
    <div class="card card-flush pb-0 bgi-position-y-center bgi-no-repeat mb-10 mt-5" style="background-size: auto calc(100% + 10rem); background-position-x: 100%; background-image: url('{{ asset('assets/admin/assets/media/illustrations/sketchy-1/4.png') }}')">
        <!--begin::Card header-->
        <div class="card-header pt-10">
            <div class="d-flex align-items-center">
                <!--begin::Icon-->
                <div class="symbol symbol-circle me-5">
                    <div class="symbol-label bg-transparent text-primary border border-secondary border-dashed">
                        <i class="ki-duotone ki-tablet-text-up fs-2x text-primary">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>                
                    </div>
                </div>
                <!--end::Icon-->

                <!--begin::Title-->
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center">
                        <h2 class="font-bn text-gray-900 min-w-50px" contenteditable id="changeTitle">{{ $notice->title }}</h2>
                        <span class="ms-3">
                            <span class="ki-duotone ki-feather text-gray-800 fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </span>
                        </span>
                    </div>
                    <div class="text-muted fw-bold">
                        30 KB <span class="mx-3">|</span> 12 Files
                    </div> 
                </div>
                <!--end::Title-->
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
        <div class="card-header pt-8 border-bottom">
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>    
                    <input type="text" data-kt-filemanager-table-filter="search" class="form-control w-250px ps-15 font-bn" placeholder="নোটিশ সার্চ করুন" />
                </div>
                <!--end::Search--> 
            </div>
    
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-filemanager-table-toolbar="base">
                    <!--begin::Add customer-->
                    <button type="button" class="btn btn-flex btn-primary font-bn" id="submitButton">
                        <i class="ki-duotone ki-tablet-text-up fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        সেভ করুন
                    </button>
                    <!--end::Add customer--> 
                </div>
                <!--end::Toolbar-->       
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
    
        <!--begin::Card body-->
        <div class="card-body">
            <div id="toolbar-container"></div>
            <div id="editor">
                {!! $notice->article !!}
            </div>
        </div>
        <!--end::Card body-->
        <input type="hidden" name="title" id="articleTitleInput" value="">
        <input type="hidden" name="article" id="articleInput" value="">
    </div>
</form>
@endsection
<!--end::Main Content-->

<!--begin::Page Vendors Javascript and custom JS-->
@section('exclusive_scripts')
<script src="{{ asset('assets/admin/assets/plugins/custom/ckeditor/ckeditor-document.bundle.js') }}"></script>
<script src="{{ asset('assets/admin/assets/plugins/custom/axios/axios.min.js') }}"></script>
<script>

let editor;
DecoupledEditor
    .create( document.querySelector( '#editor' ), {
        language: 'bn', // Set language to Bengali
        fontFamily: {
            options: [
                'Noto Serif Bengali',
                'HindSiliguri',
                'Inter',
                'Arial',
                'Georgia',
                'Impact',
                'Tahoma',
            ]
        },
    })
    .then( ckeditor => {
        const toolbarContainer = document.querySelector( '#toolbar-container' );
        toolbarContainer.appendChild(ckeditor.ui.view.toolbar.element );
        editor = ckeditor;
    } )
    .catch( error => {
        console.error( error );
    } );

    document.getElementById('submitButton').addEventListener('click', function() {
    if (editor) {
        // Get updated content from CKEditor
        const content = editor.getData();
        document.getElementById('articleInput').value = content;
        document.getElementById('articleTitleInput').value = document.getElementById('changeTitle').innerText;

        // Send the updated content to the server
        Swal.fire({
                title: "আপনি কি নিশ্চিত?",
                text: "আপনি কি নিশ্চিত যে আপনি এই নোটিশ সেভ করতে চান?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "হ্যাঁ, নিশ্চিত!",
                cancelButtonText: 'বাতিল করুন',
                customClass: {
                    confirmButton: "btn btn-success font-bn",
                    cancelButton: 'btn btn-danger font-bn',
                    title: "font-bn",
                    container: "font-bn",
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    document.getElementById('aritcleForm').submit();
                }
            });
    } else {
        console.error('CKEditor is not initialized.');
    }
});


</script>
@endsection
<!--end::Page Vendors Javascript and custom JS-->

{{-- <div class="d-flex flex-wrap mb-5">
    <div class="d-flex flex-column flex-grow-1 pe-8">
        <div class="d-flex flex-wrap mb-2">
            <div class="d-flex flex-column flex-grow-1 me-6">
                <div class="fw-bold font-bn">প্রকাশের তারিখ:</div>
                <div class="text-muted
                font-bn">{{ $notice->created_at->format('d M, Y') }}</div>
            </div>
            <div class="d-flex flex-column flex-grow-1">
                <div class="fw-bold font-bn">প্রকাশের সময়:</div>
                <div class="text-muted
                font-bn">{{ $notice->created_at->format('h:i A') }}</div>
            </div>
        </div>
    </div>
</div> --}}