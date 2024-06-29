@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>এডমিনগণ</title>
@endsection
<!--end::Page Title-->

<!--begin::Page Custom Styles(used by this page)-->
@section('exclusive_styles')
<link href="{{ asset('/assets/plugins/global/select2.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/plugins/global/swal2.css') }}" rel="stylesheet" type="text/css">

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
                            <i class="ki-outline ki-profile-user fs-2x text-success">
                            </i>                
                        </div>
                    </div>
                    <!--end::Icon-->
    
                    <!--begin::Title-->
                    <div class="d-flex flex-column">
                        <h2 class="font-bn">
                            এডমিনগণ
                        </h2>
                        {{-- <div class="text-muted fw-bold font-noto">{{ App\Helpers\Helpers::convertToBanglaDigits($menu_links->count()) }} টি মেনু</div>  --}}
                    </div>
                    <!--end::Title-->
                </div>

                @can('create-user')
                <button type="button" class="btn btn-flex btn-success font-bn" data-bs-toggle="modal" data-bs-target="#modal_add_user">
                    <i class="ki-outline ki-security-user fs-2"></i> 
                    নতুন এডমিন
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
                    <i class="fal fa-search fs-3 position-absolute ms-6"></i>    
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
                        <th class="">ভূমিকাসমূহ</th>
                        <th class="">ওয়ার্ড সমূহ</th>
                        <th class=""></th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600 font-kohinoor">
                    {{-- @for ($i = 0; $i < 50; $i++) --}}
                    @foreach ($admins as $admin)
                    <tr>
                        <td class="py-1" data-order="{{ $admin->name }}">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-45px me-5">
                                    <img src="{{ Helpers::getImageUrl($admin, 'dp', 'thumb', 'admins') }}" alt="" />
                                </div>
                                <div>
                                    <a href="#" class="text-dark fw-semibold text-hover-primary mb-1 fs-4">{{ $admin->name }}</a>
                                    <br>
                                    <span class="text-muted text-muted fs-6">{{ $admin->phone }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-1 font-kohinoor">
                            @if($admin->can('do-everything'))
                            <span class="badge badge-light-primary">সুপার এডমিন</span>
                            @endif
                            
                            @foreach ($admin->roles as $role)
                                <span class="badge badge-light-primary">{{ ucwords(str_replace('-', ' ', $role->name)) }}</span>
                            @endforeach
                        </td>
                        <td class="py-1 font-kohinoor mw-200px">
                            @foreach ($admin->getWards() as $ward)
                            @php
                                $theme = 'success';
                                if($ward > 10 && $ward <= 20) {
                                    $theme = 'primary';
                                } else if($ward > 20) {
                                    $theme = 'info';
                                }
                            @endphp
                            <span class="badge fw-normal badge-sm badge-{{ $theme }} fs-7">{{ Helpers::convertToBanglaDigits($ward) }}</span>
                            @endforeach
                        </td>
                        <td class="text-end py-1" data-kt-filemanager-table="action_dropdown">
                            <div class="d-flex justify-content-end">
                                <!--begin::Share link-->
                                <div class="ms-2">
                                    @can('update-admin')
                                    <a  href="javascript:void(0);" onclick="inputPageData({{ json_encode($admin) }}, '{{ Helpers::getImageUrl($admin, 'dp') }}', {{ json_encode($admin->getWards()) }})" data-bs-toggle="modal" data-bs-target="#modal_update_user" class="btn btn-sm btn-icon btn-light-info" title="পরিবর্তন করুন">
                                        <i class="fal fa-edit fs-3 m-0"></i>
                                    </a>
                                    @endcan

                                    @can('delete-admin')
                                    <form 
                                    action="#"  
                                    class="btn btn-sm btn-icon btn-light-danger" 
                                    method="POST"
                                    onclick="submitForm(this, event, '{{ $admin->name }}')"
                                    title="ডিলিট করুন"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <i class="fal fa-trash-can fs-3 m-0">
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
                    নতুন এডমিন
               </h3>
               <!--end::Title-->
           </div>
           <!--end::Heading-->
           <!--begin::Close-->
           <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                <i class="ki-outline ki-cross fs-3"></i>
           </div>
           <!--end::Close-->
       </div>
       <!--begin::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                <!--begin:Form-->
                <form id="newAdminForm" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                    action="{{ route('admin.admins') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
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
                                style="background-image: url({{ asset('/assets/img/blank-image.svg') }})">
                            </div>
                            <!--end::Image preview wrapper-->

                            <!--begin::Edit button-->
                            <label
                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                title="Change employee image">
                                <i class="fal fa-cloud-upload fs-6"></i>

                                <!--begin::Inputs-->
                                <input type="file" class="file_input" name="image" accept=".png, .jpg, .jpeg"/>
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
                                <i class="fal fa-user fs-3"></i>
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
                                ভূমিকা
                            </span>
                        </label>
                        <!--end::Label-->

                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-user-tie fs-3"></i>
                            </div>
                            <select name="role" id="roleSelect" class="form-select font-bn" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ ucwords(str_replace('-', ' ', $role->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!--begin::Input group-->
                    <div class="row mb-md-8 mb-2">
                        <div class="col-md-6 fv-row">
                            <label class="required d-flex align-items-center fs-6 fw-semibold mb-2">
                                ফোন নম্বর
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fal fa-phone-alt fs-3">
                                    </i>
                                </span>
                                <input type="text" name="phone" class="form-control" placeholder="01712345678" required />
                            </div>
                        </div>
                        <div class="col-md-6 mt-md-0 mt-2 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                ই-মেইল
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fal fa-envelope fs-3">
                                    </i>
                                </span>
                                <input type="email" name="email" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    {{-- <!--begin:: Social Media-->
                    <div class="d-flex flex-column mb-md-8 mb-2 fv-row fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            ঠিকানা
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="fal fa-location-dot fs-2">
                                </i>
                            </span>
                            <input type="text" name="address" class="form-control" />
                        </div>
                    </div>
                    <!--end:: Social Media--> --}}

                    <div class="separator separator-content my-15">
                        <span class="w-200px text-gray-600
                         fs-5 fw-semibold">
                            ওয়ার্ড সমূহ
                        </span>
                    </div>

                    <div class="row row-cols-3 mb-15">
                        @php
                            $wards = range(1, 30);
                            $wardChunks = collect($wards)->chunk(10);
                        @endphp
                        @foreach ($wardChunks as $chunk)
                        <div class="col">
                            @foreach ($chunk as $ward)
                            @php
                                $theme = 'success';
                                if($ward > 10 && $ward <= 20) {
                                    $theme = 'primary';
                                } else if($ward > 20) {
                                    $theme = 'info';
                                }
                            @endphp
                            <div class="form-check {{ $loop->first ? '' : 'pt-3' }} form-check-custom form-check-{{ $theme }}">
                                <input class="form-check-input" name="wards[]" type="checkbox" value="{{ $ward }}" id="wardCheckbox{{ $ward }}" />
                                <label class="form-check-label font-kohinoor fs-5 text-gray-800" for="wardCheckbox{{ $ward }}">
                                    {{ Helpers::convertToBanglaDigits($ward) }} নং ওয়ার্ড
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>

                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">
                            বাতিল করুন
                        </button>

                        <button type="submit" id="newAdminSubmitButton" class="btn btn-success">
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
@can('update-user')
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
               <h3 class="text-gray-800 fw-semibold fs-4" id="updateModalTitle"></h3>
               <!--end::Title-->
           </div>
           <!--end::Heading-->
           <!--begin::Close-->
           <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
            <i class="ki-outline ki-cross fs-3"></i>
           </div>
           <!--end::Close-->
       </div>
       <!--begin::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                <!--begin:Form-->
                <form id="updateAdminForm" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                    action="{{ route('admin.admins') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <input type="hidden" id="updateId" name="id">
                    <!--begin::Image input-->
                    <div class="mb-md-8 mb-4 fv-row">
                        <label class="fs-6 fw-semibold mb-4 d-block">
                            <span>
                                ছবি
                            </span>
                            <span class="ms-1" data-bs-toggle="tooltip"
                                title="Image for the single employee section.">
                                <i class="fal fa-info-circle fs-6">
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
                                <i class="fal fa-cloud-upload fs-6"></i>

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
                                <i class="fal fa-user fs-3"></i>
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

                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fal fa-user-tie fs-3"></i>
                            </div>
                            <select name="role" id="updateRoleSelect" class="form-select font-bn" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ ucwords(str_replace('-', ' ', $role->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!--begin::Input group-->
                    <div class="row mb-md-8 mb-2">
                        <div class="col-md-6 fv-row">
                            <label class="required d-flex align-items-center fs-6 fw-semibold mb-2">
                                ফোন নম্বর
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fal fa-phone-alt fs-3">
                                    </i>
                                </span>
                                <input type="text" name="phone" id="updatePhoneNumber" class="form-control" placeholder="01712345678" required />
                            </div>
                        </div>
                        <div class="col-md-6 mt-md-0 mt-2 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                ইমেইল
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fal fa-envelope fs-3">
                                    </i>
                                </span>
                                <input type="email" id="updateEmail" name="email" class="form-control" placeholder="example@gmail.com" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <div class="separator separator-content my-15">
                        <span class="w-200px text-gray-600
                         fs-5 fw-semibold">
                            ওয়ার্ড সমূহ
                        </span>
                    </div>

                    <div class="row row-cols-3 mb-15">
                        @php
                            $wards = range(1, 30);
                            $wardChunks = collect($wards)->chunk(10);
                        @endphp
                        @foreach ($wardChunks as $chunk)
                        <div class="col">
                            @foreach ($chunk as $ward)
                            @php
                                $theme = 'success';
                                if($ward > 10 && $ward <= 20) {
                                    $theme = 'primary';
                                } else if($ward > 20) {
                                    $theme = 'info';
                                }
                            @endphp
                            <div class="form-check {{ $loop->first ? '' : 'pt-3' }} form-check-custom form-check-{{ $theme }}">
                                <input class="form-check-input update_admin_ward" name="wards[]" type="checkbox" value="{{ $ward }}" id="wardUpdateCheckbox{{ $ward }}" />
                                <label class="form-check-label font-kohinoor fs-5 text-gray-800" for="wardUpdateCheckbox{{ $ward }}">
                                    {{ Helpers::convertToBanglaDigits($ward) }} নং ওয়ার্ড
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>

                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">
                            বাতিল করুন
                        </button>

                        <button type="submit" class="btn btn-success" id="updateAdminSubmitButton">
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
<script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    const inputPageData = (data, imageUrl, wards) => {
        document.getElementById('updateId').value = data.id;
        document.getElementById('updateName').value = data.name;
        document.getElementById('updatePhoneNumber').value = data.phone;
        document.getElementById('updateEmail').value = data.email;
        document.getElementById('updateImage').style.backgroundImage = `url(${imageUrl})`;
        document.getElementById('updateModalTitle').innerText = `প্রোফাইল সম্পাদন করুন: ${data.name}`;

        console.log(wards);

        // Set wards
        const wardCheckboxes = document.querySelectorAll('.update_admin_ward');
        wardCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });

        wards.forEach(ward => {
            document.getElementById(`wardUpdateCheckbox${ward}`).checked = true;
        });

        // Set roles
        $('#updateRoleSelect').val(data.roles.map(role => role.name));

        // trigger select2
        $('#updateRoleSelect').trigger('change');
    }

    const form = document.getElementById('newAdminForm');
    const updateForm = document.getElementById('updateAdminForm');

    var validator = FormValidation.formValidation(
        form,
        {
            fields: {
                'name': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        },
                        regexp: {
                            message: 'অক্ষর অনুমোদিত',
                            regexp: /^[a-zA-Z\u0980-\u09FF\. ]+$/,
                        },
                    }
                },
                'role': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        }
                    }
                },
                'phone': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                        },
                        stringLength: {
                            min: 11,
                            max: 11,
                            message: 'ফোন নম্বর ১১ সংখ্যার হতে হবে'
                        }
                    }
                },
                'email': {
                    validators: {
                        emailAddress: {
                            message: 'একটি বৈধ ইমেইল ঠিকানা প্রদান করুন'
                        }
                    }
                },
                'image': {
                    validators: {
                        file: {
                            extension: 'jpeg,jpg,png',
                                    type: 'image/jpeg,image/png',
                                    maxSize: 1024*1024*1,  // 1MB
                                    message: 'সঠিক ফাইল ফরম্যাট: jpeg, jpg, png | সর্বোচ্চ আকার ১ মেগাবাইট'

                        }
                    }
                }
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            }
        }
    );

    const submitButton = document.getElementById('newAdminSubmitButton');
    submitButton.addEventListener('click', function (e) {
        // Prevent default button action
        e.preventDefault();

        // Validate form before submit
        if (validator) {
            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;

                    // submit form
                    form.submit();
                }else{
                    Swal.fire({
                        title: `আবেদন সম্পাদন করা যাবে না!`,
                        text: "সকল প্রয়োজনীয় তথ্য সঠিকভাবে প্রদান করুন।",
                        icon: "error",
                        confirmButtonText: "ঠিক আছে",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            title: "font-bn",
                            container: "font-bn",
                        }
                    });
                }
            })
        }
    });

    var updateValidator = FormValidation.formValidation(
        updateForm,
        {
            fields: {
                'name': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        },
                        regexp: {
                            message: 'অক্ষর অনুমোদিত',
                            regexp: /^[a-zA-Z\u0980-\u09FF\. ]+$/,
                        },
                    }
                },
                'role': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        }
                    }
                },
                'phone': {
                    validators: {
                        notEmpty: {
                            message: 'অবশ্যই প্রদান করতে হবে'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                        },
                        stringLength: {
                            min: 11,
                            max: 11,
                            message: 'ফোন নম্বর ১১ সংখ্যার হতে হবে'
                        }
                    }
                },
                'email': {
                    validators: {
                        emailAddress: {
                            message: 'একটি বৈধ ইমেইল ঠিকানা প্রদান করুন'
                        }
                    }
                },
                'image': {
                    validators: {
                        file: {
                            extension: 'jpeg,jpg,png',
                            type: 'image/jpeg,image/png',
                            maxSize: 1024*1024*1,  // 1MB
                            message: 'সঠিক ফাইল ফরম্যাট: jpeg, jpg, png | সর্বোচ্চ আকার ১ মেগাবাইট'
                        }
                    }
                }
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            }
        }
    );

    const updateSubmitButton = document.getElementById('updateAdminSubmitButton');
    updateSubmitButton.addEventListener('click', function (e) {
        // Prevent default button action
        e.preventDefault();

        // Validate form before submit
        if (updateValidator) {
            updateValidator.validate().then(function (status) {
                if (status == 'Valid') {
                    // Show loading indication
                    updateSubmitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    updateSubmitButton.disabled = true;

                    // submit form
                    updateForm.submit();
                }else{
                    Swal.fire({
                        title: `আবেদন সম্পাদন করা যাবে না!`,
                        text: "সকল প্রয়োজনীয় তথ্য সঠিকভাবে প্রদান করুন।",
                        icon: "error",
                        confirmButtonText: "ঠিক আছে",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            title: "font-bn",
                            container: "font-bn",
                        }
                    });
                }
            })
        }
    });

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
                    { data: 'roles'},
                    { data: 'wards'},
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