@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>Menu Mangaer | Admin</title>
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
                            মেনু ম্যানেজার
                        </h2>
                        <div class="text-muted fw-bold font-noto">{{ App\Helpers\Helpers::convertToBanglaDigits($menu_links->count()) }} টি মেনু</div> 
                    </div>
                    <!--end::Title-->
                </div>

                @can('create-menu-link')
                <button type="button" class="btn btn-flex btn-primary font-bn" data-bs-toggle="modal" data-bs-target="#modal_add_link">
                    <i class="ki-duotone ki-element-11 fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                    </i>
                    নতুন মেনু
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
            @foreach($menu_links as $menu_link)
            <div class="d-flex justify-content-between align-items-center {{ $loop->first ? '' : 'border-top pt-2' }}">
                <div class="d-flex align-items-center mb-2">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-40px me-5">
                        <span class="symbol-label" style="background-color: {{ $menu_link->visibility ? $menu_link->color : '#acacac' }}">
                            <i class="ki-duotone ki-element-11 fs-2x text-gray-100">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                    </div>
                    <!--end::Symbol-->
    
                    <!--begin::Text-->
                    <div class="d-flex flex-column">
                        <a href="{{ route('admin.menu-link.show', $menu_link->id) }}" class="fs-4 fw-semibold" style="color: {{ $menu_link->visibility ? $menu_link->color : '#acacac' }}">{{ $menu_link->title }}</a>
                        <a href="{{ route('admin.menu-link.show', $menu_link->id) }}" class="text-muted text-hover-primary text-hover-underline font-noto">{{ App\Helpers\Helpers::convertToBanglaDigits($menu_link->links()->count()) }} টি লিংক</a>
                    </div>
                    <!--end::Text-->
                </div>
                <div class="d-flex justify-content-end gap-2">
                    @can('edit-menu-link')
                    <form class="form-check form-switch mt-2" action="{{ route('admin.menu-link.visibility', $menu_link->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input class="form-check-input cursor-pointer" onchange="this.form.submit()" type="checkbox" role="switch" {{ $menu_link->visibility ? 'checked' : '' }}>
                    </form>
                    <a href="#" class="btn btn-sm btn-icon btn-info font-bn" data-bs-toggle="modal" data-bs-target="#modal_update_link" onclick="placeFormData({{ json_encode($menu_link) }})">
                        <i class="ki-solid ki-feather fs-3">
                        </i>
                    </a>
                    @endcan

                    @can('delete-menu-link')
                    @if($menu_link->links()->count() == 0)
                    <form action="{{ route('admin.menu-link.destroy', $menu_link->id) }}" onclick="submitForm(this, event, '{{ $menu_link->title }}')" method="POST" class="btn btn-sm btn-icon btn-danger font-bn">
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
    @can('create-menu-link')
    <!--begin::Page edit modal-->
    <div class="modal fade font-bn" id="modal_add_link" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header pb-3 mb-8 border-0 justify-content-between bg-light-dark">
                    <!--begin::Heading-->
                    <div class="text-center">
                    <!--begin::Title-->
                    <h3 class="text-gray-800 fw-semibold fs-4">নতুন মেনু</h3>
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
                        action="{{ route('admin.menu-link.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-12">
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span>নাম</span>
                                    </label>
                                    <!--end::Label-->
        
                                    <input type="text" class="form-control" name="title">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <!--end::Input group-->
                            </div>

                            {{-- <div class="col-md-2">
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span>রঙ</span>
                                    </label>
                                    <!--end::Label-->
        
                                    <input type="color" class="form-control" style="padding: 0; border: 0; border-radius: 0px; outline: 0;" name="color" value="#8768de">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <!--end::Input group-->
                            </div> --}}
                        </div>

                        <!--begin::Row-->
                        <div class="row mw-500px mb-5" data-kt-buttons="true" data-kt-buttons-target=".form-check-image, .form-check-input">
                            <label class="form-check-image active d-flex gap-2 align-items-center">
                                <div class="w-30px h-30px rounded mb-2" style="background-color: #ff6600"></div>

                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" value="#ff6600" name="color" checked/>
                                    <div class="form-check-label text-gray-800 fw-normal">
                                        Orange
                                    </div>
                                </div>
                            </label>
                            <label class="form-check-image active d-flex gap-2 align-items-center">
                                <div class="w-30px h-30px rounded mb-2" style="background-color: #c40a2a"></div>

                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" value="#c40a2a" name="color"/>
                                    <div class="form-check-label text-gray-800 fw-normal">
                                        Red
                                    </div>
                                </div>
                            </label>
                            <label class="form-check-image active d-flex gap-2 align-items-center">
                                <div class="w-30px h-30px rounded mb-2" style="background-color: #84154d"></div>

                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" value="#84154d" name="color"/>
                                    <div class="form-check-label text-gray-800 fw-normal">
                                        Magenta
                                    </div>
                                </div>
                            </label>
                            <label class="form-check-image active d-flex gap-2 align-items-center">
                                <div class="w-30px h-30px rounded mb-2" style="background-color: #098346"></div>

                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" value="#098346" name="color"/>
                                    <div class="form-check-label text-gray-800 fw-normal">
                                        Green
                                    </div>
                                </div>
                            </label>
                            <label class="form-check-image active d-flex gap-2 align-items-center">
                                <div class="w-30px h-30px rounded mb-2" style="background-color: #067bf9"></div>

                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" value="#067bf9" name="color"/>
                                    <div class="form-check-label text-gray-800 fw-normal">
                                        Blue
                                    </div>
                                </div>
                            </label>
                            <label class="form-check-image active d-flex gap-2 align-items-center">
                                <div class="w-30px h-30px rounded mb-2" style="background-color: #8768de"></div>

                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" value="#8768de" name="color"/>
                                    <div class="form-check-label text-gray-800 fw-normal">
                                        Purple
                                    </div>
                                </div>
                            </label>
                        </div>
                        <!--end::Row-->

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

    @can('update-menu-link')
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
                       <h3 class="text-gray-800 fw-semibold fs-4">আপডেট মেনু</h3>
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
                        action="{{ route('admin.menu-link.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="id" id="menuLinkUpdateID">
                        <div class="row">
                            <div class="col-md-12">
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span>নাম</span>
                                    </label>
                                    <!--end::Label-->
        
                                    <input type="text" class="form-control" name="title" id="menuLinkUpdateTitle">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <!--end::Input group-->
                            </div>

                            {{-- <div class="col-md-2">
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span>রঙ</span>
                                    </label>
                                    <!--end::Label-->
        
                                    <input type="color" class="form-control" style="padding: 0; border: 0; border-radius: 0px; outline: 0;" name="color" value="#8768de">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <!--end::Input group-->
                            </div> --}}
                        </div>

                        <!--begin::Row-->
                        <div class="row mw-500px mb-5" data-kt-buttons="true" data-kt-buttons-target=".form-check-image, .form-check-input">
                            <label class="form-check-image active d-flex gap-2 align-items-center">
                                <div class="w-30px h-30px rounded mb-2" style="background-color: #ff6600"></div>

                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" id="#ff6600" value="#ff6600" name="color"/>
                                    <div class="form-check-label text-gray-800 fw-normal">
                                        Orange
                                    </div>
                                </div>
                            </label>
                            <label class="form-check-image active d-flex gap-2 align-items-center">
                                <div class="w-30px h-30px rounded mb-2" style="background-color: #c40a2a"></div>

                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" id="#c40a2a" value="#c40a2a" name="color"/>
                                    <div class="form-check-label text-gray-800 fw-normal">
                                        Red
                                    </div>
                                </div>
                            </label>
                            <label class="form-check-image active d-flex gap-2 align-items-center">
                                <div class="w-30px h-30px rounded mb-2" style="background-color: #84154d"></div>

                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" id="#84154d" value="#84154d" name="color"/>
                                    <div class="form-check-label text-gray-800 fw-normal">
                                        Magenta
                                    </div>
                                </div>
                            </label>
                            <label class="form-check-image active d-flex gap-2 align-items-center">
                                <div class="w-30px h-30px rounded mb-2" style="background-color: #098346"></div>

                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" id="#098346" value="#098346" name="color"/>
                                    <div class="form-check-label text-gray-800 fw-normal">
                                        Green
                                    </div>
                                </div>
                            </label>
                            <label class="form-check-image active d-flex gap-2 align-items-center">
                                <div class="w-30px h-30px rounded mb-2" style="background-color: #067bf9"></div>

                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" id="#067bf9" value="#067bf9" name="color"/>
                                    <div class="form-check-label text-gray-800 fw-normal">
                                        Blue
                                    </div>
                                </div>
                            </label>
                            <label class="form-check-image active d-flex gap-2 align-items-center">
                                <div class="w-30px h-30px rounded mb-2" style="background-color: #8768de"></div>

                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" id="#8768de" value="#8768de" name="color"/>
                                    <div class="form-check-label text-gray-800 fw-normal">
                                        Purple
                                    </div>
                                </div>
                            </label>
                        </div>
                        <!--end::Row-->

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

@canany(['edit-menu-link', 'delete-menu-link'])
@section('exclusive_scripts')
    <script>
        function placeFormData(data){
            document.getElementById('menuLinkUpdateID').value = data.id;
            document.getElementById('menuLinkUpdateTitle').value = data.title;
            document.getElementById(data.color).checked = true;
        }

        function submitForm(form, event, title){
            event.preventDefault();
            Swal.fire({
                title: `আপনি কি \'${title}\' মেনু লিংক ডিলিট করতে চান?`,
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
@endcanany
