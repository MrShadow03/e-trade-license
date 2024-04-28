@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>Card Mangaer | Admin</title>
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
                            <i class="ki-duotone ki-element-11 fs-2x text-primary">
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
                            কার্ড ম্যানেজার
                        </h2>
                        <div class="text-muted fw-bold font-noto">{{ App\Helpers\Helpers::convertToBanglaDigits($cards->count()) }} টি কার্ড</div> 
                    </div>
                    <!--end::Title-->
                </div>

                @can('create-card')
                <button type="button" class="btn btn-flex btn-primary font-bn" data-bs-toggle="modal" data-bs-target="#modal_add_card">
                    <i class="ki-duotone ki-element-11 fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                    </i>
                    নতুন কার্ড
                </button>
                @endcan
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
            @foreach($cards as $card)
            <div class="d-flex justify-content-between align-items-center {{ $loop->first ? '' : 'border-top pt-2' }}">
                <div class="d-flex align-items-center mb-2">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-40px me-5">
                        <img class="object-fit-cover" src="{{ asset('storage/'.$card->image) }}" alt="{{ $card->title }}" />
                    </div>
                    <!--end::Symbol-->
    
                    <!--begin::Text-->
                    <div class="d-flex flex-column">
                        <a href="{{ route('admin.card.show', $card->id) }}" class="fs-4 fw-semibold text-gray-900">{{ $card->title }}</a>
                        <a href="{{ route('admin.card.show', $card->id) }}" class="text-muted text-hover-primary text-hover-underline font-noto">{{ App\Helpers\Helpers::convertToBanglaDigits($card->links()->count()) }} টি লিংক</a>
                    </div>
                    <!--end::Text-->
                </div>
                <div class="d-flex justify-content-end gap-2">
                    @can('edit-card')
                    <form class="form-check form-switch mt-2" action="{{ route('admin.card.visibility', $card->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input class="form-check-input cursor-pointer" onchange="this.form.submit()" type="checkbox" role="switch" {{ $card->visibility ? 'checked' : '' }}>
                    </form>
                    <a href="#" class="btn btn-sm btn-icon btn-info font-bn" data-bs-toggle="modal" data-bs-target="#modal_update_link" onclick="placeFormData({{ json_encode($card) }}, '{{ asset('storage') }}')">
                        <i class="ki-solid ki-feather fs-3">
                        </i>
                    </a>
                    @endcan
                    @can('create-card')
                    <a href="{{ route('admin.card.show', $card->id) }}" class="btn btn-sm btn-icon btn-primary font-bn">
                        <i class="ki-solid ki-plus fs-3">
                        </i>
                    </a>
                    @endcan
                    @can('delete-card')
                    @if($card->links()->count() == 0)
                    <form action="{{ route('admin.card.destroy', $card->id) }}" onclick="submitForm(this, event, '{{ $card->title }}')" method="POST" class="btn btn-sm btn-icon btn-danger font-bn">
                        @csrf
                        @method('DELETE')
                        <i class="ki-solid ki-trash fs-3">
                        </i>
                    </form>
                    @endif
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
    @can('create-card')
    <!--begin::Page edit modal-->
    <div class="modal fade font-bn" id="modal_add_card" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header pb-3 mb-8 border-0 justify-content-between bg-light-dark">
                    <!--begin::Heading-->
                    <div class="text-center">
                       <!--begin::Title-->
                       <h3 class="text-gray-800 fw-semibold fs-4">নতুন কার্ড</h3>
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
                        action="{{ route('admin.card.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>শিরোনাম</span>
                            </label>
                            <!--end::Label-->

                            <input type="text" class="form-control" name="title">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Image input-->
                        <div class="mb-10 fv-row">
                            <label class="fs-6 fw-semibold mb-4 d-block">
                                <span>ছবি যোগ করুন</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="দেখার সুবিধার্থে ভালো কোয়ালিটির ছবি আপলোড করুন">
                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                            </label>
                            <div class="image-input image-input-outline" data-kt-image-input="true">
                                <!--begin::Image preview wrapper-->
                                <div class="image-input-wrapper"></div>
                                <!--end::Image preview wrapper-->

                                <!--begin::Edit button-->
                                <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change"
                                data-bs-toggle="tooltip"
                                data-bs-dismiss="click"
                                title="ছবি পরিবর্তন করুন">
                                    <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

                                    <!--begin::Inputs-->
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg, .webp" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->

                                <!--begin::Cancel button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel"
                                data-bs-toggle="tooltip"
                                data-bs-dismiss="click"
                                title="ছবি বাতিল করুন">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Cancel button-->
                            </div>
                            <div class="form-text">ফাইল টাইপ: png, jpg | সর্বোচ্চ সাইজ: 3MB</div>
                        </div>
                        <!--end::Image input-->

                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">
                                বাতিল করুন
                            </button>

                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">
                                    যোগ করুন
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

    @can('edit-card')
    <!--begin::Page edit modal-->
    <div class="modal fade font-bn" id="modal_update_link" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header pb-3 mb-8 border-0 justify-content-between bg-light-dark">
                    <!--begin::Heading-->
                    <div class="text-center">
                       <!--begin::Title-->
                       <h3 class="text-gray-800 fw-semibold fs-4">আপডেট কার্ড</h3>
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
                        action="{{ route('admin.card.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="id" id="menuCardUpdateID">
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>শিরোনাম</span>
                            </label>
                            <!--end::Label-->

                            <input type="text" class="form-control" name="title" id="menuCardUpdateTitle">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Image input-->
                        <div class="mb-10 fv-row" id="linkUpdateImageSection">
                            <label class="fs-6 fw-semibold mb-4 d-block">
                                <span>ছবি যোগ করুন</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="দেখার সুবিধার্থে ভালো কোয়ালিটির ছবি আপলোড করুন">
                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                            </label>
                            <div class="image-input image-input-outline" data-kt-image-input="true">
                                <!--begin::Image preview wrapper-->
                                <div class="image-input-wrapper" id="menuCardUpdateImage"></div>
                                <!--end::Image preview wrapper-->

                                <!--begin::Edit button-->
                                <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change"
                                data-bs-toggle="tooltip"
                                data-bs-dismiss="click"
                                title="ছবি পরিবর্তন করুন">
                                    <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

                                    <!--begin::Inputs-->
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg, .webp" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->

                                <!--begin::Cancel button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel"
                                data-bs-toggle="tooltip"
                                data-bs-dismiss="click"
                                title="ছবি বাতিল করুন">
                                    <i class="ki-outline ki-cross fs-3"></i>
                                </span>
                                <!--end::Cancel button-->
                            </div>
                            <div class="form-text">ফাইল টাইপ: png, jpg | সর্বোচ্চ সাইজ: 3MB</div>
                        </div>
                        <!--end::Image input-->

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


@section('exclusive_scripts')
    <script>
        function placeFormData(data, assetPath){
            document.getElementById('menuCardUpdateID').value = data.id;
            document.getElementById('menuCardUpdateTitle').value = data.title;
            document.getElementById('menuCardUpdateImage').style.backgroundImage = `url('${assetPath}/${data.image}')`;
        }

        function submitForm(form, event, title){
            event.preventDefault();
            Swal.fire({
                title: `আপনি কি \'${title}\' কার্ড লিংক ডিলিট করতে চান?`,
                text: "একবার ডিলিট করার পর এটি ফেরত আনা যাবে না!",
                icon: "error",
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
    </script>
@endsection
