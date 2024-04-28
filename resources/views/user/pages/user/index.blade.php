@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>Users | Admin</title>
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
                        <div class="symbol-label bg-light-success text-success border border-success border-dashed">
                            <i class="ki-duotone ki-security-user fs-2x text-success">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>                
                        </div>
                    </div>
                    <!--end::Icon-->
    
                    <!--begin::Title-->
                    <div class="d-flex flex-column">
                        <h2 class="font-bn">
                            ব্যবহারকারীগণ
                        </h2>
                        {{-- <div class="text-muted fw-bold font-noto">{{ App\Helpers\Helpers::convertToBanglaDigits($menu_links->count()) }} টি মেনু</div>  --}}
                    </div>
                    <!--end::Title-->
                </div>

                @can('create-user')
                <button type="button" class="btn btn-flex btn-success font-bn" data-bs-toggle="modal" data-bs-target="#modal_add_user">
                    <i class="ki-duotone ki-security-user fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    নতুন ব্যবহারকারী
                </button>
                @endcan
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pb-0">
        </div>
    </div>

    <div class="card card-flush mb-10">
        <!--begin::Card header-->
        <div class="card-header pt-8 border-bottom">
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>    
                    <input type="text" data-kt-filemanager-table-filter="search" class="form-control w-250px ps-15 font-bn" placeholder="সার্চ করুন" />
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
                    <tr class="text-start text-gray-700 fw-bold fs-6 text-uppercase gs-0">
                        <th class="">নাম</th>
                        <th class="">ফোন নম্বর</th>
                        <th class="">ভূমিকাসমূহ</th>
                        <th class="">সর্বশেষ আইপি</th>
                        <th class=""></th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600 font-bn">
                    {{-- @for ($i = 0; $i < 50; $i++) --}}
                    @foreach ($users as $user)
                    <tr>
                        <td class="py-1" data-order="{{ $user->name }}">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-45px me-5">
                                    <img src="{{ asset('storage').'/'.$user->image }}" alt="" />
                                </div>
                                <div>
                                    <a href="#" class="text-dark fw-semibold text-hover-primary mb-1 fs-4">{{ $user->name }}</a>
                                    <br>
                                    <span class="text-muted text-muted fs-6">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-1">
                            <span class="text-gray-800 fs-5">{{ $user->phone_number }}</span>
                        </td>
                        <td class="py-1 font-bn">
                            @foreach ($user->roles as $role)
                                <span class="badge badge-light-primary">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td class="py-1 font-bn">
                            <span class="text-gray-800 fs-5">{{ $user->last_login_ip }}</span>
                        </td>
                        <td class="text-end py-1" data-kt-filemanager-table="action_dropdown">
                            <div class="d-flex justify-content-end">
                                <!--begin::Share link-->
                                <div class="ms-2">
                                    @can('edit-user')
                                    <a  href="javascript:void(0);" onclick="inputPageData({{ json_encode($user) }}, '{{ asset('storage') }}')" data-bs-toggle="modal" data-bs-target="#modal_update_user" class="btn btn-sm btn-icon btn-light-info" title="পরিবর্তন করুন">
                                        <i class="ki-solid ki-feather fs-3 m-0"></i>
                                    </a>
                                    @endcan

                                    @can('delete-user')
                                    <form 
                                    action="{{ route('admin.link.destroy', $user->id) }}"  
                                    class="btn btn-sm btn-icon btn-light-danger" 
                                    method="POST"
                                    onclick="submitForm(this, event, '{{ $user->name }}')"
                                    title="ডিলিট করুন"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <i class="ki-solid ki-trash fs-3 m-0">
                                        </i>
                                    </form>
                                    @endcan
                                </div>
                                <!--end::Share link-->
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    {{-- @endfor --}}
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
@can('create-user')
<div class="modal fade font-bn" id="modal_add_user" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content rounded">
           <!--begin::Modal header-->
           <div class="modal-header pb-3 mb-8 border-0 justify-content-between bg-light-dark">
            <!--begin::Heading-->
            <div class="text-center">
               <!--begin::Title-->
               <h3 class="text-gray-800 fw-semibold fs-4">
                    নতুন ব্যবহারকারী
               </h3>
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
                    action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-md-8 mb-2 fv-row fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">
                                নাম
                            </span>
                        </label>
                        <!--end::Label-->

                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="ki-solid ki-user fs-2"></i>
                            </div>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->

                    <div class="d-flex flex-column mb-md-8 mb-2 fv-row fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2 font-bn">
                            <span class="required">
                                ভূমিকাসমূহ
                            </span>
                        </label>
                        <!--end::Label-->

                        <div class="input-group flex-nowrap">
                            <div class="input-group-text">
                                <i class="ki-solid ki-security-user fs-2"></i>
                            </div>
                            <select name="roles[]" id="roleSelect" class="form-select font-bn" required multiple>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!--begin::Input group-->
                    <div class="row mb-md-8 mb-2">
                        <div class="col-md-6">
                            <label class="required d-flex align-items-center fs-6 fw-semibold mb-2">
                                ফোন নম্বর
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="ki-solid ki-address-book fs-2">
                                    </i>
                                </span>
                                <input type="text" name="phone_number" class="form-control" placeholder="01712345678" required />
                            </div>
                        </div>
                        <div class="col-md-6 mt-md-0 mt-2">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                ইমেইল
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="ki-solid ki-sms fs-2">
                                    </i>
                                </span>
                                <input type="email" name="email" class="form-control"
                                    placeholder="example@gmail.com" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin:: Social Media-->
                    <div class="d-flex flex-column mb-md-8 mb-2 fv-row fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            ঠিকানা
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="ki-solid ki-geolocation-home fs-2">
                                </i>
                            </span>
                            <input type="text" name="address" class="form-control" />
                        </div>
                    </div>
                    <!--end:: Social Media-->

                    <!--begin::Image input-->
                    <div class="mb-md-8 mb-4 fv-row">
                        <label class="fs-6 fw-semibold mb-4 d-block">
                            <span>
                                ছবি
                            </span>
                            <span class="ms-1" data-bs-toggle="tooltip"
                                title="Image for the single employee section.">
                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span>
                        </label>
                        <div class="image-input image-input-outline" data-kt-image-input="true">
                            <!--begin::Image preview wrapper-->
                            <div class="image-input-wrapper"
                                style="background-image: url({{ asset('/assets/admin/assets/media/svg/avatars/blank.svg') }})">
                            </div>
                            <!--end::Image preview wrapper-->

                            <!--begin::Edit button-->
                            <label
                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                title="Change employee image">
                                <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span
                                        class="path2"></span></i>

                                <!--begin::Inputs-->
                                <input type="file" name="image" accept=".png, .jpg, .jpeg, .webp" />
                                <input type="hidden" name="avatar_remove" />
                                <!--end::Inputs-->
                            </label>
                            <!--end::Edit button-->

                            <!--begin::Cancel button-->
                            <span
                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                title="Cancel employee image">
                                <i class="ki-outline ki-cross fs-3"></i>
                            </span>
                            <!--end::Cancel button-->

                            <!--begin::Remove button-->
                            <span
                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                title="Remove employee image">
                                <i class="ki-outline ki-cross fs-3"></i>
                            </span>
                            <!--end::Remove button-->
                        </div>
                        <div class="form-text">
                            বৈধ ফাইল টাইপসমূহ: png, jpg, jpeg, webp. | সর্বোচ্চ সাইজ: ১MB
                        </div>
                    </div>
                    <!--end::Image input-->

                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">
                            বাতিল করুন
                        </button>

                        <button type="submit" class="btn btn-success">
                            <span class="indicator-label">
                                যোগ করুন
                            </span>
                            <span class="indicator-progress">
                                অপেক্ষা করুন...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
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
@endcan
@can('edit-user')
<div class="modal fade font-bn" id="modal_update_user" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content rounded">
           <!--begin::Modal header-->
           <div class="modal-header pb-3 mb-8 border-0 justify-content-between bg-light-dark">
            <!--begin::Heading-->
            <div class="text-center">
               <!--begin::Title-->
               <h3 class="text-gray-800 fw-semibold fs-4" id=""></h3>
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
                    action="{{ route('admin.users.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <input type="hidden" id="updateId" name="id">
                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-md-8 mb-2 fv-row fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">
                                নাম
                            </span>
                        </label>
                        <!--end::Label-->

                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="ki-solid ki-user fs-2"></i>
                            </div>
                            <input type="text" class="form-control" id="updateName" name="name" required>
                        </div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Input group-->

                    <div class="d-flex flex-column mb-md-8 mb-2 fv-row fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2 font-bn">
                            <span class="required">
                                ভূমিকাসমূহ
                            </span>
                        </label>
                        <!--end::Label-->

                        <div class="input-group flex-nowrap">
                            <div class="input-group-text">
                                <i class="ki-solid ki-security-user fs-2"></i>
                            </div>
                            <select name="roles[]" id="updateRoleSelect" class="form-select font-bn" required multiple>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!--begin::Input group-->
                    <div class="row mb-md-8 mb-2">
                        <div class="col-md-6">
                            <label class="required d-flex align-items-center fs-6 fw-semibold mb-2">
                                ফোন নম্বর
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="ki-solid ki-address-book fs-2">
                                    </i>
                                </span>
                                <input type="text" name="phone_number" id="updatePhoneNumber" class="form-control" placeholder="01712345678" required />
                            </div>
                        </div>
                        <div class="col-md-6 mt-md-0 mt-2">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                ইমেইল
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="ki-solid ki-sms fs-2">
                                    </i>
                                </span>
                                <input type="email" id="updateEmail" name="email" class="form-control" placeholder="example@gmail.com" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin:: Social Media-->
                    <div class="d-flex flex-column mb-md-8 mb-2 fv-row fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            ঠিকানা
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="ki-solid ki-geolocation-home fs-2">
                                </i>
                            </span>
                            <input type="text" name="address" id="updateAddress" class="form-control" />
                        </div>
                    </div>
                    <!--end:: Social Media-->

                    <!--begin::Image input-->
                    <div class="mb-md-8 mb-4 fv-row">
                        <label class="fs-6 fw-semibold mb-4 d-block">
                            <span>
                                ছবি
                            </span>
                            <span class="ms-1" data-bs-toggle="tooltip"
                                title="Image for the single employee section.">
                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span>
                        </label>
                        <div class="image-input image-input-outline" data-kt-image-input="true">
                            <!--begin::Image preview wrapper-->
                            <div class="image-input-wrapper" id="updateImage"
                                style="background-image: url({{ asset('/assets/admin/assets/media/svg/avatars/blank.svg') }})">
                            </div>
                            <!--end::Image preview wrapper-->

                            <!--begin::Edit button-->
                            <label
                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                title="Change employee image">
                                <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span
                                        class="path2"></span></i>

                                <!--begin::Inputs-->
                                <input type="file" name="image" accept=".png, .jpg, .jpeg, .webp" />
                                <input type="hidden" name="avatar_remove" />
                                <!--end::Inputs-->
                            </label>
                            <!--end::Edit button-->

                            <!--begin::Cancel button-->
                            <span
                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                title="Cancel employee image">
                                <i class="ki-outline ki-cross fs-3"></i>
                            </span>
                            <!--end::Cancel button-->

                            <!--begin::Remove button-->
                            <span
                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                title="Remove employee image">
                                <i class="ki-outline ki-cross fs-3"></i>
                            </span>
                            <!--end::Remove button-->
                        </div>
                        <div class="form-text">
                            বৈধ ফাইল টাইপসমূহ: png, jpg, jpeg, webp. | সর্বোচ্চ সাইজ: ১MB
                        </div>
                    </div>
                    <!--end::Image input-->

                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">
                            বাতিল করুন
                        </button>

                        <button type="submit" class="btn btn-success">
                            <span class="indicator-label">
                                পরিবর্তন করুন
                            </span>
                            <span class="indicator-progress">
                                অপেক্ষা করুন...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
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
@endcan
@endsection

@section('exclusive_scripts')
<script src="{{ asset('./assets/admin/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
            // Select2
            $('#roleSelect').select2();
            $('#updateRoleSelect').select2();
        });

        const inputPageData = (data, asset) => {
            document.getElementById('updateId').value = data.id;
            document.getElementById('updateName').value = data.name;
            document.getElementById('updatePhoneNumber').value = data.phone_number;
            document.getElementById('updateEmail').value = data.email;
            document.getElementById('updateAddress').value = data.address;
            document.getElementById('updateImage').style.backgroundImage = `url(${asset}/${data.image})`;
            document.getElementById('modal_update_user').querySelector('.modal-header h3').innerText = data.name+' এর তথ্য পরিবর্তন করুন';

            // Set roles
            const roles = data.roles;
            const roleSelect = document.getElementById('updateRoleSelect');
            for (let i = 0; i < roleSelect.options.length; i++) {
                roleSelect.options[i].selected = false;
            }
            roles.forEach(role => {
                for (let i = 0; i < roleSelect.options.length; i++) {
                    if (roleSelect.options[i].value == role.id) {
                        roleSelect.options[i].selected = true;
                    }
                }
            });

            // trigger select2
            $('#updateRoleSelect').trigger('change');
        }
    // Class definition
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
                    { data: 'phone_number'},
                    { data: 'roles'},
                    { data: 'last_login_ip'},
                    { data: 'actions'},
                ],
                conditionalPaging: true
            };

            // Define datatable options to load
            var loadOptions;
            loadOptions = filesListOptions;

            datatable = $(table).DataTable(loadOptions);
        }

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