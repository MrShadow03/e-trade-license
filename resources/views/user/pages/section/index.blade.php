@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>সেকশন সমূহ | Admin</title>
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
<div id="kt_app_content_container" class="app-container container-xxl font-bn">
    <div class="card card-flush pb-0 bgi-position-y-center bgi-no-repeat mb-10 mt-5">
        <!--begin::Card header-->
        <div class="card-header pt-10">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="symbol symbol-circle me-5">
                        <div class="symbol-label bg-transparent text-primary border border-secondary border-dashed">
                            <i class="ki-duotone ki-element-8 fs-2x text-primary">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>                
                        </div>
                    </div>
                    <!--end::Icon-->
    
                    <!--begin::Title-->
                    <div class="d-flex flex-column">
                        <h2 class="font-bn">
                            সেকশন সমূহ
                        </h2>
                        <div class="text-muted fw-bold font-noto">{{ App\Helpers\Helpers::convertToBanglaDigits($sections->count()) }} টি সেকশন</div> 
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
    
        <!--begin::Card body-->
        <div class="card-body">
            @foreach($sections as $section)
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center mb-7">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-40px me-5 bg-primary-light">
                        <span class="symbol-label">
                            <i class="ki-duotone ki-element-8 fs-2x {{ $section->visibility ? 'text-primary' : 'text-gray-500' }}">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                    </div>
                    <!--end::Symbol-->
    
                    <!--begin::Text-->
                    <div class="d-flex flex-column">
                        <span class="fs-4 fw-semibold {{ $section->visibility ? 'text-gray-900' : 'text-gray-500' }}">{{ $section->title }}</span><br>
                        <span class="text-muted">{{ ucwords($section->name) }}</span>
                    </div>
                    <!--end::Text-->
                </div>
                <div class="d-flex justify-content-end gap-2">
                    @can('edit-section')
                    <form class="form-check form-switch mt-2" action="{{ route('admin.sections.visibility', $section->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input class="form-check-input cursor-pointer" onchange="this.form.submit()" type="checkbox" role="switch" {{ $section->visibility ? 'checked' : '' }}>
                    </form>
                    <a href="#" class="btn btn-sm btn-icon btn-info font-bn" data-bs-toggle="modal" data-bs-target="#modal_update_section" onclick="placeFormData({{ json_encode($section) }})">
                        <i class="ki-solid ki-feather fs-3">
                        </i>
                    </a>
                    @endcan
                </div>
            </div>
            @endforeach
        </div>
        <!--end::Card body-->
    </div>
</div>
@endsection
<!--end::Main Content-->

@section('exclusive_modals')
@can('edit-section')
<!--begin::Page edit modal-->
<div class="modal fade font-bn" id="modal_update_section" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content rounded">
            <!--begin::Modal header-->
            <div class="modal-header pb-3 mb-8 border-0 justify-content-between bg-light-dark">
                <!--begin::Heading-->
                <div class="text-center">
                    <!--begin::Title-->
                    <h3 class="text-gray-800 fw-semibold fs-4">আপডেট সেকশন</h3>
                    <!--end::Title-->
                </div>
                <!--end::Heading-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                <!--begin:Form-->
                <form id="modal_new_targ_banner" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                    action="{{ route('admin.sections.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id" id="sectionUpdateID">
                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span>শিরোনাম</span>
                        </label>
                        <!--end::Label-->

                        <input type="text" class="form-control" name="title" id="sectionUpdateTitle">
                        <div class="fv-plugins-message-container invalid-feedback"></div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span>বিবরণ</span>
                        </label>
                        <!--end::Label-->

                        <textarea class="form-control" name="description" id="sectionUpdateDescription" rows="5"></textarea>
                        <div class="fv-plugins-message-container invalid-feedback"></div>
                    </div>

                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">
                            বাতিল করুন
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                আপডেট করুন
                            </span>
                            <span class="indicator-progress">
                                অপেক্ষা করুন...<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end:Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Page edit modal-->
@endcan
@endsection
<!--end::Page Vendors Javascript and custom JS-->

@can('edit-section')
@section('exclusive_scripts')
    <script>
        function placeFormData(data){
            document.getElementById('sectionUpdateID').value = data.id;
            document.getElementById('sectionUpdateTitle').value = data.title;
            document.getElementById('sectionUpdateDescription').innerText = data.description;
        }
    </script>
@endsection
@endcan
