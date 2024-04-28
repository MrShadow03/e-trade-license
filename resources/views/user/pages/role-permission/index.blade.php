@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>Role & Permissions | Admin</title>
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
                            <i class="ki-solid ki-key fs-2x text-success">
                            </i>                
                        </div>
                    </div>
                    <!--end::Icon-->
    
                    <!--begin::Title-->
                    <div class="d-flex flex-column">
                        <h2 class="font-bn">
                            ভূমিকা এবং অনুমতি
                        </h2>
                        {{-- <div class="text-muted fw-bold font-noto">{{ App\Helpers\Helpers::convertToBanglaDigits($menu_links->count()) }} টি মেনু</div>  --}}
                    </div>
                    <!--end::Title-->
                </div>

                @can('create-role')
                <button type="button" class="btn btn-flex btn-success font-bn" data-bs-toggle="modal" data-bs-target="#modal_add_role">
                    <i class="ki-solid ki-key fs-2">
                    </i>
                    নতুন কর্মচারী ভূমিকা
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
    <!--begin::Roles-->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
        <!--begin::Col-->
        <div class="col-md-4">
            <!--begin::Card-->
            <div class="card card-flush h-md-100">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>সুপার অ্যাডমিন</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-1">
                    <!--begin::Permissions-->
                        <table class="table table-striped">
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                <!--begin::Table row-->
                                <tr>
                                    <td class="text-gray-800">ক্ষেত্র</td>
                                    <td class="text-gray-800">দেখা</td>
                                    <td class="text-gray-800">তৈরি</td>
                                    <td class="text-gray-800">পরি:</td>
                                    <td class="text-gray-800">ডিলিট</td>
                                </tr>
                                @php
                                    $allPermissions = ($permissions->merge($noticeCategoryPermissions))->toArray();
                                    $totalPermissions = count($allPermissions);
                                    $remainingPermissions = $totalPermissions - 5;
                                    $remainingPermissions = $remainingPermissions < 0 ? 0 : $remainingPermissions;
                                    $rowCounter = 0;
                                @endphp
                                @foreach ($allPermissions as $model => $permission)
                                @if ($rowCounter > 4)
                                    @break
                                @endif
                                <tr>
                                    <td class="text-gray-800 py-2">{{ $model }}</td>
                                    @foreach (['view', 'create', 'edit', 'delete'] as $item)
                                    <td class="py-2">
                                        <i class="ki-solid ki-check fs-2 text-success"></i>
                                    </td>  
                                    @endforeach
                                    @php
                                        $rowCounter++;
                                    @endphp
                                </tr>
                                @endforeach
                                <!--end::Table row-->
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        @if ($remainingPermissions > 0)
                        <a href="#" data-bs-toggle="modal" onclick="setPermissionViewModalData({{ json_encode($allPermissions) }}, 'সুপার অ্যাডমিন')" data-bs-target="#modal_view_permissions" class="text-primary text-hover-underline">আরও {{ App\Helpers\Helpers::ConvertToBanglaDigits($remainingPermissions) }} টি অনুমতি দেখুন...</a>
                        @endif
                    <!--end::Permissions-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Col-->
        @foreach ($rolePermissions as $role)
        <!--begin::Col-->
        <div class="col-md-4">
            <!--begin::Card-->
            <div class="card card-flush h-md-100">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>{{ $role->name }}</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-1">
                    <!--begin::Users-->
                    <div class="fw-bold text-gray-600 mb-5">Total users with this role: 5</div>
                    <!--end::Users-->

                    <!--begin::Permissions-->
                        <table class="table table-striped">
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                <!--begin::Table row-->
                                <tr>
                                    <td class="text-gray-800">ক্ষেত্র</td>
                                    <td class="text-gray-800">দেখা</td>
                                    <td class="text-gray-800">তৈরি</td>
                                    <td class="text-gray-800">পরি:</td>
                                    <td class="text-gray-800">ডিলিট</td>
                                </tr>
                                @php
                                    $totalPermissions = count($role->permissions);
                                    $remainingPermissions = $totalPermissions - 5;
                                    $remainingPermissions = $remainingPermissions < 0 ? 0 : $remainingPermissions;
                                    $rowCounter = 0;
                                @endphp
                                @foreach ($role->permissions as $model => $permission)
                                @if ($rowCounter > 4)
                                    @break
                                @endif
                                <tr>
                                    <td class="text-gray-800 py-2">{{ $model }}</td>
                                    @foreach (['view', 'create', 'edit', 'delete'] as $item)
                                    <td class="py-2">
                                        @if (in_array($item, $permission))
                                            <i class="ki-solid ki-check fs-2 text-success"></i>
                                            {{-- <span class="text-success fw-semibold">হ্যাঁ</span> --}}
                                            @else
                                            <i class="ki-solid ki-cross fs-2 text-danger"></i>
                                            {{-- <span class="text-danger fw-semibold">না</span> --}}
                                        @endif
                                    </td>  
                                    @endforeach
                                    @php
                                        $rowCounter++;
                                    @endphp
                                </tr>
                                @endforeach
                                <!--end::Table row-->
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        @if ($remainingPermissions > 0)
                        <a href="#" data-bs-toggle="modal" onclick="setPermissionViewModalData({{ json_encode($role->permissions) }}, '{{ $role->name }}')" data-bs-target="#modal_view_permissions" class="text-primary text-hover-underline">আরও {{ App\Helpers\Helpers::ConvertToBanglaDigits($remainingPermissions) }} টি অনুমতি দেখুন...</a>
                        @endif
                    <!--end::Permissions-->
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->
                <div class="card-footer d-flex align-items-center flex-wrap pt-0">      
                    <a href="#" class="btn btn-light-success my-1 me-2">
                        বিস্তারিত দেখুন
                    </a>

                    @can('edit-role')
                    <button type="button" onclick="setPermissionUpdateModalData({{ json_encode($role) }})" class="btn btn-light-primary my-1 me-2" data-bs-toggle="modal" data-bs-target="#modal_update_role">
                        পরিবর্তন করুন
                    </button>
                    @endcan

                    @can('delete-role')
                    <form action="{{ route('admin.role-permissions.destroy', $role->id) }}" method="POST" onclick="submitForm(this, event, '{{ $role->name }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-light-danger btn-icon">
                            <i class="la la-trash fs-2"></i>
                        </button>
                    </form>
                    @endcan
                </div>
                <!--end::Card footer-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Col-->
        @endforeach
    </div>
    <!--end::Roles-->
</div>
@endsection
<!--end::Main Content-->

@section('exclusive_modals')
@can('create-role')
<div class="modal fade font-bn user-select-none" id="modal_add_role" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-gray-100">
                <!--begin::Modal title-->
                <h2 class="fw-bold">
                    নতুন কর্মচারী ভূমিকা
                </h2>
                <!--end::Modal title-->

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-lg-5 my-7">
                <!--begin::Form-->
                <form id="modal_add_role_form" class="form" action="{{ route('admin.role-permissions.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column border-bottom scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header" data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">
                                <span class="required">ভূমিকা</span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="la la-user fs-3"></i>
                                </div>
                                <input class="form-control" placeholder="ভূমিকার নাম প্রদান করুন" name="role_name" />
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Permissions-->
                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">
                                অনুমতিসমূহ
                            </label>
                            <!--end::Label-->

                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <!--begin::Table body-->
                                    <tbody class="text-gray-600 fw-semibold">
                                        <!--begin::Table row-->
                                        <tr>
                                            <td class="text-gray-800">
                                                Administrator Access
                                            </td>
                                            <td>
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-custom me-9">
                                                    <input class="form-check-input" type="checkbox" value="" id="roles_select_all" />
                                                    <span class="form-check-label text-gray-700" for="roles_select_all">
                                                        সব অনুমতি দিন
                                                    </span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </td>
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        @foreach ($permissions as $model => $modelPermissions)
                                        <tr>
                                            <!--begin::Label-->
                                            <td class="text-gray-800 py-2">{{ $model }}</td>
                                            <!--end::Label-->

                                            <!--begin::Options-->
                                            <td class="py-2">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex">
                                                    @foreach ($modelPermissions as $modelPermissionName => $permission)
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-sm form-check-custom me-5 me-lg-20">
                                                        <input id="{{ $modelPermissionName }}" class="form-check-input" type="checkbox" value="1" name="permissions[{{ $modelPermissionName }}]" 
                                                        @if($modelPermissionName === 'create-notice')
                                                            onclick="toggleCategoryPermissions('create-notice', '.notice-permission-row')"
                                                        @endif
                                                        />
                                                        <span class="form-check-label text-gray-700">
                                                            {{ App\Helpers\Helpers::translatePermission($permission) }}
                                                        </span>
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    @endforeach
                                                </div>
                                                <!--end::Wrapper-->
                                            </td>
                                            <!--end::Options-->
                                        </tr>
                                        @endforeach
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        @foreach ($noticeCategoryPermissions as $model => $NCPermissions)
                                        <tr class="notice-permission-row d-none {{ $loop->first ? 'border-top' : '' }}">
                                            <!--begin::Label-->
                                            <td class="text-info py-2 {{ $loop->first ? 'pt-5' : '' }}">{{ $model }}</td>
                                            <!--end::Label-->

                                            <!--begin::Options-->
                                            <td class="py-2 {{ $loop->first ? 'pt-5' : '' }}">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex">
                                                    @foreach ($NCPermissions as $permissionName => $permission)
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-sm form-check-custom me-5 me-lg-20">
                                                        <input class="form-check-input" type="checkbox" value="1" name="permissions[{{ $permissionName }}]"/>
                                                        <span class="form-check-label text-gray-700">
                                                            {{ App\Helpers\Helpers::translatePermission($permission) }}
                                                        </span>
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    @endforeach
                                                </div>
                                                <!--end::Wrapper-->
                                            </td>
                                            <!--end::Options-->
                                        </tr>
                                        @endforeach
                                        <!--end::Table row-->
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Permissions-->
                    </div>
                    <!--end::Scroll-->

                    <!--begin::Actions-->
                    <div class="text-center pt-10">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">
                            বাতিল করুন
                        </button>

                        <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
                            <span class="indicator-label">
                                তৈরি করুন
                            </span>
                            <span class="indicator-progress">
                                তৈরি হচ্ছে...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
@endcan
@can('edit-role')
<div class="modal fade font-bn user-select-none" id="modal_update_role" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-gray-100">
                <!--begin::Modal title-->
                <h2 class="fw-bold" id="updateTitle">
                    ভূমিকা
                </h2>
                <!--end::Modal title-->

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-lg-5 my-7">
                <!--begin::Form-->
                <form id="modal_update_role_form" class="form" action="{{ route('admin.role-permissions.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="role_id" id="updateId">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column border-bottom scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header" data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">
                                <span class="required">ভূমিকা</span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="la la-user fs-3"></i>
                                </div>
                                <input class="form-control" placeholder="ভূমিকার নাম প্রদান করুন" name="role_name" id="updateRoleName" />
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Permissions-->
                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">
                                অনুমতিসমূহ
                            </label>
                            <!--end::Label-->

                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <!--begin::Table body-->
                                    <tbody class="text-gray-600 fw-semibold">
                                        <!--begin::Table row-->
                                        <tr>
                                            <td class="text-gray-800">
                                                Administrator Access
                                            </td>
                                            <td>
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-custom me-9">
                                                    <input class="form-check-input" type="checkbox" value="" id="update_roles_select_all" />
                                                    <span class="form-check-label text-gray-700" for="update_roles_select_all">
                                                        সব অনুমতি দিন
                                                    </span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </td>
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        @foreach ($permissions as $model => $permissions)
                                        <tr>
                                            <!--begin::Label-->
                                            <td class="text-gray-800 py-2">{{ $model }}</td>
                                            <!--end::Label-->

                                            <!--begin::Options-->
                                            <td class="py-2">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex">
                                                    @foreach ($permissions as $permissionName => $permission)
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-sm form-check-custom me-5 me-lg-20">
                                                        <input id="update{{ $permissionName }}" class="form-check-input" type="checkbox" value="{{ $permissionName }}" name="permissions[]"
                                                        @if($permissionName === 'create-notice')
                                                            onclick="toggleCategoryPermissions('updatecreate-notice', '.update-notice-permission-row')"
                                                        @endif
                                                        />
                                                        <span class="form-check-label text-gray-700">
                                                            {{ App\Helpers\Helpers::translatePermission($permission) }}
                                                        </span>
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    @endforeach
                                                </div>
                                                <!--end::Wrapper-->
                                            </td>
                                            <!--end::Options-->
                                        </tr>
                                        @endforeach
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        @foreach ($noticeCategoryPermissions as $model => $permissions)
                                        <tr class="update-notice-permission-row d-none {{ $loop->first ? 'border-top' : '' }}">
                                            <!--begin::Label-->
                                            <td class="text-info py-2 {{ $loop->first ? 'pt-5' : '' }}">{{ $model }}</td>
                                            <!--end::Label-->

                                            <!--begin::Options-->
                                            <td class="py-2 {{ $loop->first ? 'pt-5' : '' }}">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex">
                                                    @foreach ($permissions as $permissionName => $permission)
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-sm form-check-custom me-5 me-lg-20">
                                                        <input id="update{{ $permissionName }}" class="form-check-input" type="checkbox" value="{{ $permissionName }}" name="permissions[]"/>
                                                        <span class="form-check-label text-gray-700">
                                                            {{ App\Helpers\Helpers::translatePermission($permission) }}
                                                        </span>
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    @endforeach
                                                </div>
                                                <!--end::Wrapper-->
                                            </td>
                                            <!--end::Options-->
                                        </tr>
                                        @endforeach
                                        <!--end::Table row-->
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Permissions-->
                    </div>
                    <!--end::Scroll-->

                    <!--begin::Actions-->
                    <div class="text-center pt-10">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">
                            বাতিল করুন
                        </button>

                        <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
                            <span class="indicator-label">
                                পরিবর্তন করুন
                            </span>
                            <span class="indicator-progress">
                                পরিবর্তন হচ্ছে...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
@endcan
<div class="modal fade font-bn" id="modal_view_permissions" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header bg-gray-100">
                <!--begin::Modal title-->
                <h2 class="fw-bold" id="viewPermissionModalTitle"></h2>
                <!--end::Modal title-->

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-lg-5 my-7" id="viewPermissionModalTableWrapper">
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
<script>
function submitForm(form, event, title){
    event.preventDefault();
    Swal.fire({
        title: `আপনি কি \'${title}\' ভূমিকা ডিলিট করতে চান?`,
        text: "একবার ডিলিট করার পর এটি ফেরত আনা যাবে না!",
        icon: "question",
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
function setPermissionViewModalData(permissions, roleName){
    const modalTitle = document.getElementById('viewPermissionModalTitle');
    const modalTableWrapper = document.getElementById('viewPermissionModalTableWrapper');
    const permissionsInBangla = {
        'view': 'দেখা',
        'create': 'তৈরি',
        'edit': 'পরিবর্তন',
        'delete': 'মুছে ফেলুন'
    };
    modalTableWrapper.innerHTML = 
    `<div class="table-responsive">
        <!--begin::Table-->
        <table class="table align-middle table-bordered table-striped fs-6 gy-5">
            <!--begin::Table body-->
            <tbody class="text-gray-600 fw-semibold">
                <!--begin::Table row-->
                <tr>
                    <td class="text-gray-800">
                        ক্ষেত্র
                    </td>
                    <td class="text-gray-800">
                        দেখা
                    </td>
                    <td class="text-gray-800">
                        তৈরি
                    </td>
                    <td class="text-gray-800">
                        পরিবর্তন
                    </td>
                    <td class="text-gray-800">
                        ডিলিট
                    </td>
                </tr>
                <!--end::Table row-->
                <!--begin::Table row-->
                ${Object.keys(permissions).map(model => {
                    return `<tr>
                                <td class="text-gray-800 py-2">${model}</td>
                                ${Object.keys(permissions[model]).map(permission => {
                                    return `<td class="py-2">
                                                ${permissions[model][permission] ? '<i class="ki-solid ki-check fs-2 text-success"></i>' : '<i class="ki-solid ki-cross fs-2 text-danger"></i>'}
                                            </td>`
                                }).join('')}
                            </tr>`
                }).join('')}
                <!--end::Table row-->
            </tbody>
            <!--end::Table body-->
        </table>
        <!--end::Table-->
    </div>`;

    modalTitle.innerHTML = roleName;
}

function setPermissionUpdateModalData(role){
    const updateTitle = document.getElementById('updateTitle');
    const updateRoleName = document.getElementById('updateRoleName');
    const updateId = document.getElementById('updateId');
    updateTitle.innerHTML = role.name;
    updateRoleName.value = role.name;
    updateId.value = role.id;

    // reset all checkboxes of update modal
    const modal = document.getElementById('modal_update_role');
    const checkboxes = modal.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });

    Object.values(role.permissions).forEach(permission => {
        Object.keys(permission).forEach(key => {
            const permissionCheckbox = document.getElementById(`update${key}`);
            if(permissionCheckbox){
                permissionCheckbox.checked = true;
            }
        });
    });

    const noticePermissions = document.querySelectorAll('.update-notice-permission-row');
    const createNoticeInput = document.getElementById('updatecreate-notice');

    if(createNoticeInput && createNoticeInput.checked){
        noticePermissions.forEach(permission => {
            permission.classList.add('d-table-row-group');
            permission.classList.remove('d-none');
        });
    }else{
        noticePermissions.forEach(permission => {
            permission.classList.add('d-none');
            permission.classList.remove('d-table-row-group');

            const checkboxes = permission.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        });
    }
}

function toggleCategoryPermissions(checkBoxId, rowsId){
    let noticeCreateInput = document.getElementById(checkBoxId);
    let noticePermissions = document.querySelectorAll(rowsId);

    if(noticeCreateInput.checked){
        noticePermissions.forEach(permission => {
            permission.classList.add('d-table-row-group');
            permission.classList.remove('d-none');
        });
    }else{
        noticePermissions.forEach(permission => {
            permission.classList.add('d-none');
            permission.classList.remove('d-table-row-group');

            let checkboxes = permission.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        });
    }
}

// Class definition
var KTUsersAddRole = function () {
    // Shared variables
    // const element = document.getElementById('kt_modal_add_role');
    const addRoleForm = document.querySelector('#modal_add_role_form');
    const updateRoleForm = document.querySelector('#modal_update_role_form');
    const addSelectAll = document.getElementById('roles_select_all');
    const updateSelectAll = document.getElementById('update_roles_select_all');
    // const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    // var initAddRole = () => {

    //     // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    //     var validator = FormValidation.formValidation(
    //         form,
    //         {
    //             fields: {
    //                 'role_name': {
    //                     validators: {
    //                         notEmpty: {
    //                             message: 'Role name is required'
    //                         }
    //                     }
    //                 },
    //             },

    //             plugins: {
    //                 trigger: new FormValidation.plugins.Trigger(),
    //                 bootstrap: new FormValidation.plugins.Bootstrap5({
    //                     rowSelector: '.fv-row',
    //                     eleInvalidClass: '',
    //                     eleValidClass: ''
    //                 })
    //             }
    //         }
    //     );

    //     // Close button handler
    //     const closeButton = element.querySelector('[data-kt-roles-modal-action="close"]');
    //     closeButton.addEventListener('click', e => {
    //         e.preventDefault();

    //         Swal.fire({
    //             text: "Are you sure you would like to close?",
    //             icon: "warning",
    //             showCancelButton: true,
    //             buttonsStyling: false,
    //             confirmButtonText: "Yes, close it!",
    //             cancelButtonText: "No, return",
    //             customClass: {
    //                 confirmButton: "btn btn-primary",
    //                 cancelButton: "btn btn-active-light"
    //             }
    //         }).then(function (result) {
    //             if (result.value) {
    //                 modal.hide(); // Hide modal				
    //             } 
    //         });
    //     });

    //     // Cancel button handler
    //     const cancelButton = element.querySelector('[data-kt-roles-modal-action="cancel"]');
    //     cancelButton.addEventListener('click', e => {
    //         e.preventDefault();

    //         Swal.fire({
    //             text: "Are you sure you would like to cancel?",
    //             icon: "warning",
    //             showCancelButton: true,
    //             buttonsStyling: false,
    //             confirmButtonText: "Yes, cancel it!",
    //             cancelButtonText: "No, return",
    //             customClass: {
    //                 confirmButton: "btn btn-primary",
    //                 cancelButton: "btn btn-active-light"
    //             }
    //         }).then(function (result) {
    //             if (result.value) {
    //                 form.reset(); // Reset form	
    //                 modal.hide(); // Hide modal				
    //             } else if (result.dismiss === 'cancel') {
    //                 Swal.fire({
    //                     text: "Your form has not been cancelled!.",
    //                     icon: "error",
    //                     buttonsStyling: false,
    //                     confirmButtonText: "Ok, got it!",
    //                     customClass: {
    //                         confirmButton: "btn btn-primary",
    //                     }
    //                 });
    //             }
    //         });
    //     });

    //      // Submit button handler
    //      const submitButton = element.querySelector('[data-kt-roles-modal-action="submit"]');
    //      submitButton.addEventListener('click', function (e) {
    //          // Prevent default button action
    //          e.preventDefault();
 
    //          // Validate form before submit
    //          if (validator) {
    //              validator.validate().then(function (status) {
    //                  console.log('validated!');
 
    //                  if (status == 'Valid') {
    //                      // Show loading indication
    //                      submitButton.setAttribute('data-kt-indicator', 'on');
 
    //                      // Disable button to avoid multiple click 
    //                      submitButton.disabled = true;
 
    //                      // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
    //                      setTimeout(function () {
    //                          // Remove loading indication
    //                          submitButton.removeAttribute('data-kt-indicator');
 
    //                          // Enable button
    //                          submitButton.disabled = false;
 
    //                          // Show popup confirmation 
    //                          Swal.fire({
    //                              text: "Form has been successfully submitted!",
    //                              icon: "success",
    //                              buttonsStyling: false,
    //                              confirmButtonText: "Ok, got it!",
    //                              customClass: {
    //                                  confirmButton: "btn btn-primary"
    //                              }
    //                          }).then(function (result) {
    //                              if (result.isConfirmed) {
    //                                  modal.hide();
    //                              }
    //                          });
 
    //                          //form.submit(); // Submit form
    //                      }, 2000);
    //                  } else {
    //                      // Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
    //                      Swal.fire({
    //                          text: "Sorry, looks like there are some errors detected, please try again.",
    //                          icon: "error",
    //                          buttonsStyling: false,
    //                          confirmButtonText: "Ok, got it!",
    //                          customClass: {
    //                              confirmButton: "btn btn-primary"
    //                          }
    //                      });
    //                  }
    //              });
    //          }
    //      });
        

    // }

    // Select all handler
    const handleSelectAll = (selectAll, form) =>{
        const allCheckboxes = form.querySelectorAll('[type="checkbox"]');

        // Handle check state
        selectAll.addEventListener('change', e => {

            // Apply check state to all checkboxes
            allCheckboxes.forEach(c => {
                c.checked = e.target.checked;
            });
        });
    }

    return {
        // Public functions
        init: function () {
            // initAddRole();
            handleSelectAll(addSelectAll, addRoleForm);
            handleSelectAll(updateSelectAll, updateRoleForm);
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersAddRole.init();
});
</script>
@endsection
<!--end::Page Vendors Javascript and custom JS-->
