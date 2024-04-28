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
                        <h2 class="font-bn">নোটিশ বোর্ড</h2>
                        <div class="text-muted">
                            {{ App\Helpers\Helpers::convertFileSize($notices->sum('size')) }} <span class="mx-3">|</span> {{ $notices->count() }} টি নোটিশ
                        </div>
                    </div>
                    <!--end::Title-->
                </div>

                @can('create-notice')
                <button type="button" class="btn btn-flex btn-success font-bn text-white" data-bs-toggle="modal" data-bs-target="#modal_add_link">
                    <i class="ki-duotone ki-tablet-text-up fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    নতুন নোটিশ
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
                    <input type="text" data-kt-filemanager-table-filter="search" class="form-control w-250px ps-15 font-bn" placeholder="নোটিশ সার্চ করুন" />
                </div>
                <!--end::Search--> 
            </div>
    
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-filemanager-table-toolbar="base">
                    @canany(['view-notice-category', 'create-notice-category', 'edit-notice-category', 'delete-notice-category'])
                    <!--begin::Category-->
                    <button class="btn btn-flex btn-light-success" id="kt_drawer_chat_toggle">
                        <i class="ki-duotone ki-burger-menu-5 fs-6 me-1">
                        </i>
                        ক্যাটেগরি সমূহ
                    </button>
                    <!--end::Category--> 
                    @endcanany
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
                        <th class="">ধরন</th>
                        <th class="">সাইজ</th>
                        <th class="">সর্বশেষ আপডেট</th>
                        <th class=""></th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600 font-noto">
                    {{-- @for ($i = 0; $i < 50; $i++) --}}
                    @foreach ($notices as $notice)
                    <tr>
                        <td class="py-1">
                            <div class="d-flex align-items-center">
                                <span class="icon-wrapper">
                                    @if ($notice->link?->type == 'pdf')
                                    <i class="fas fa-file-pdf fs-2x text-danger me-4"></i>
                                    @elseif ($notice->link?->type == 'image')
                                    <i class="fas fa-file-image fs-2x text-success me-4"></i>
                                    @elseif ($notice->link?->type == 'url')
                                    <i class="fas fa-file-export fs-2x text-info me-4"></i>
                                    @else
                                    <i class="fas fa-file-alt fs-2x text-primary me-4"></i>
                                    @endif
                                </span>
                                <a 
                                @if ($notice->link?->type == 'article')
                                href="{{ route('admin.link.edit', $notice->link?->id) }}"
                                @elseif ($notice->link?->type == 'pdf' || $notice->link?->type == 'image')
                                href="javascript:void(0);" 
                                onclick="inputPageData({{ json_encode($notice) }}, '{{ asset('storage') }}')"
                                data-bs-toggle="modal"
                                data-bs-target="#modal_update_notice"
                                @elseif ($notice->link?->type == 'url')
                                href="{{ $notice->link?->url }}"
                                @endif
                                class="text-gray-800 text-hover-primary fs-5 text-truncate w-250px"
                                target="_self"
                                >{{ $notice->link?->name}}</a>
                                @if ($notice->link?->visibility)
                                <i class="ki-duotone ki-pin text-primary fs-3 m-0 ps-3">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                @endif
                                @if ($notice->link?->type === 'article' && (!$notice->link?->article))
                                <i class="ki-duotone ki-information text-danger fs-3 m-0 ps-1" title="অনুচ্ছেদ যুক্ত করুন">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                @endif
                            </div>
                        </td>
                        <td class="py-1">{{ $notice->category?->name }}</td>
                        <td class="py-1 font-bn" data-order="{{ $notice->link?->size }}">{{ App\Helpers\Helpers::convertFileSize($notice->link?->size) }}</td>
                        <td class="py-1 font-bn">
                            {{ $notice->link?->updated_at->format('d M Y, h:i a') }}
                        </td>
                        <td class="text-end py-1" data-kt-filemanager-table="action_dropdown">
                            <div class="d-flex justify-content-end">
                                <!--begin::Share link-->
                                <div class="ms-2">
                                    @can('edit-notice')
                                    @can('edit-notice-category-'.$notice->category->name)
                                    @if($notice->link?->type == 'article')
                                        <a href="{{ route('admin.link.edit', $notice->link?->id) }}" class="btn btn-sm btn-icon btn-light-info" target="_self" title="পরিবর্তন করুন">
                                            <i class="ki-solid ki-feather fs-3 m-0">
                                            </i>
                                        </a>
                                    @elseif($notice->link?->type == 'pdf' || $notice->link?->type == 'image' || $notice->link?->type == 'url')
                                        <a  href="javascript:void(0);" 
                                        onclick="inputPageData({{ json_encode($notice) }}, '{{ asset('storage') }}')"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal_update_link"
                                        class="btn btn-sm btn-icon btn-light-info"
                                        title="পরিবর্তন করুন"
                                        >
                                            <i class="ki-solid ki-feather fs-3 m-0">
                                            </i>
                                        </a>
                                    @endif
                                    <form 
                                    action="{{ route('admin.link.visibility', $notice->link?->id) }}"  
                                    class="btn btn-sm btn-icon 
                                    {{ $notice->link?->visibility ? 'btn-light-primary' : 'btn-secondary' }}"  
                                    method="POST"
                                    onclick="this.submit()"
                                    title="{{ $notice->link?->visibility ? 'ওয়েবসাইট থেকে সরিয়ে ফেলুন' : 'ওয়েবসাইটে যোগ করুন' }}"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        @if ($notice->link?->visibility)    
                                        <i class="ki-duotone ki-pin fs-3 m-0">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        @else
                                        <i class="ki-duotone ki-pin fs-3 m-0">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        @endif
                                    </form>
                                    @endcan
                                    @endcan

                                    @can('delete-notice')
                                    @can('delete-notice-category-'.$notice->category->name)
                                    <form 
                                    action="{{ route('admin.link.destroy', $notice->link?->id) }}"  
                                    class="btn btn-sm btn-icon btn-light-danger" 
                                    method="POST"
                                    onclick="submitForm(this, event, '{{ $notice->link?->name }}')"
                                    title="ডিলিট করুন"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <i class="ki-solid ki-trash fs-3 m-0">
                                        </i>
                                    </form>
                                    @endcan
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

    @can('edit-notice')
    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body">  
            <div class="d-inline w-100">
                <div class="marquee" style="width: 90%">
                    <span class="marquee-content">
                        {{ $marquee ? $marquee->article : '' }}
                    </span>
                </div>
            </div>
            <a class="btn btn-sm btn-flex btn-info"
            href="javascript:void(0);"
            data-bs-toggle="modal"
            data-bs-target="#changeMarquee"
            >
                <i class="ki-solid ki-feather fs-2"></i>
                পরিবর্তন করুন
            </a>
        </div>
        <!--end::Card body-->
    </div>
    @endcan
</div>
@endsection
<!--end::Main Content-->

@section('exclusive_modals')
    @can('create-notice')
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
                       <h3 class="text-gray-800 fw-semibold fs-4">নতুন নোটিশ</h3>
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
                        action="{{ route('admin.notice.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>শিরোনাম</span>
                            </label>
                            <!--end::Label-->

                            <input type="text" class="form-control" name="name">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>তারিখ</span>
                            </label>
                            <!--end::Label-->

                            <input type="date" class="form-control" name="start_date" value="{{ date('Y-m-d') }}" required>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>

                         <!--begin::Input group-->
                        <div class="d-flex flex-column mb-6 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>ক্যাটেগরি</span>
                            </label>
                            <!--end::Label-->

                            <select class="form-select" id="newLinkCategoryId" name="notice_category_id" data-dropdown-parent="#modal_add_link" required>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Input group-->
                        
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-6 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>নোটিশের ধরন</span>
                            </label>
                            <!--end::Label-->

                            {{-- {{ dd($latest_link->type) }} --}}
                            <select class="form-select" id="linkType" onchange="changeLinkInput()" name="type">
                                <option value="pdf" @selected($latest_link ? $latest_link->type === 'pdf' : false)>পিডিএফ</option>
                                <option value="image" @selected($latest_link ? $latest_link->type === 'image' : false)>ছবি</option>
                                <option value="article" @selected($latest_link ? $latest_link->type === 'article' : false)>অনুচ্ছেদ</option>
                                <option value="url" @selected($latest_link ? $latest_link->type === 'url' : false)>ইন্টারনেট লিংক</option>
                            </select>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container d-none" id="linkUrl">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>URL যুক্ত করুন</span>
                            </label>
                            <!--end::Label-->

                            <div class="input-group">
                                <span class="input-group-text" id="url">
                                    <i class="ki-solid ki-fasten fs-1">
                                    </i>
                                </span>
                                <input type="text" name="url" id="newLinkUrl" class="form-control" placeholder="www.barisalcity.gov.bd" aria-label="url" aria-describedby="url"/>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container d-none" id="linkDoc">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>ডকুমেন্ট</span>
                            </label>
                            <!--end::Label-->

                            <input type="file" class="form-control" name="document">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                            <div class="form-text">ফাইল টাইপ: .pdf | সর্বোচ্চ সাইজ: 10MB</div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Image input-->
                        <div class="mb-10 fv-row d-none" id="linkImage">
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
                                <div class="image-input-wrapper" style="background-image: url({{ asset('/assets/admin/assets/media/svg/avatars/blank.svg') }})"></div>
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

    @can('edit-notice')
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
                       <h3 class="text-gray-800 fw-semibold fs-4">আপডেট নোটিশ</h3>
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
                        action="{{ route('admin.notice.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="id" id="linkUpdateId">
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>শিরোনাম</span>
                            </label>
                            <!--end::Label-->

                            <input type="text" id="linkUpdateName" class="form-control" name="name">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->
                        
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>তারিখ</span>
                            </label>
                            <!--end::Label-->

                            <input type="date" id="linkUpdateStartDate" class="form-control" name="start_date" required>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>ক্যাটেগরি</span>
                            </label>
                            <!--end::Label-->

                            <select class="form-select" id="linkUpdateCategory" name="notice_category_id" data-dropdown-parent="#modal_update_link">
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <!--end::Input group-->
                        
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>নোটিশের ধরন</span>
                            </label>
                            <!--end::Label-->

                            <select class="form-select" id="linkUpdateType" onchange="updateSection(this.value)" name="type">
                                <option value="pdf">পিডিএফ</option>
                                <option value="image">ছবি</option>
                                <option value="article">অনুচ্ছেদ</option>
                                <option value="url">ইন্টারনেট লিংক</option>
                            </select>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container d-none" id="linkUpdateUrlSection">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>URL যুক্ত করুন</span>
                            </label>
                            <!--end::Label-->

                            <div class="input-group">
                                <span class="input-group-text" id="url">
                                    <i class="ki-solid ki-fasten fs-1">
                                    </i>
                                </span>
                                <input type="text" name="url" id="linkUpdateUrl" class="form-control" placeholder="www.barisalcity.gov.bd" aria-label="url" aria-describedby="url"/>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container d-none" id="linkUpdateDocSection">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>ডকুমেন্ট</span>
                            </label>
                            <!--end::Label-->

                            <input type="file" class="form-control" id="linkUpdateDoc" name="document">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                            <div class="form-text">ফাইল টাইপ: .pdf | সর্বোচ্চ সাইজ: 10MB</div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Image input-->
                        <div class="mb-10 fv-row d-none" id="linkUpdateImageSection">
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
                                <div class="image-input-wrapper" id="linkUpdateImageWrapper"></div>
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

    @can('edit-notice')
    <!--begin::Page edit modal-->
    <div class="modal fade font-bn" id="changeMarquee" tabindex="-1" aria-hidden="true">
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
                            পরিবর্তন করুন
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
                        action="{{ route('admin.link.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="name" value="marquee">
                        <input type="hidden" name="slug" value="marquee">
                        <input type="hidden" name="type" value="article">
                        <input type="hidden" name="id" value="{{ $marquee->id }}" id="updateMarquee">
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>
                                    কন্টেন্ট
                                </span>
                            </label>
                            <!--end::Label-->

                            <textarea type="text" id="marqueeContent" class="form-control" name="article" rows="10">{{ $marquee->article }}</textarea>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->

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

    @can('view-notice-category')
    <!--begin::drawer-->
    <div id="kt_drawer_chat" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="chat" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'100%', 'md': '500px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_drawer_chat_toggle" data-kt-drawer-close="#kt_drawer_chat_close">

        <!--begin::Messenger-->
        <div class="card w-100 border-0 rounded-0 font-bn" id="kt_drawer_chat_messenger">
            <!--begin::Card header-->
            <div class="card-header pe-5" id="kt_drawer_chat_messenger_header">
                <!--begin::Title-->
                <div class="card-title">
                    <!--begin::User-->
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">
                            ক্যাটেগরি সমূহ
                        </a>
    
                        <!--begin::Info-->
                        <div class="mb-0 lh-1">
                            <span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
                            <span class="fs-7 fw-semibold text-muted">{{ App\Helpers\Helpers::convertToBanglaDigits($categories->count()) }} টি ক্যাটেগরি</span>
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->
    
                <!--begin::Card toolbar-->
                <div class="card-toolbar">

                    @can('create-notice-category')
                    <!--begin::Menu-->
                    <a href="#" data-bs-toggle="modal" data-bs-target="#category_new_modal" class="me-0 btn btn-sm btn-success">
                        <i class="ki-duotone ki-file fs-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        নতুন ক্যাটেগরি
                    </a>
                    <!--end::Menu-->
                    @endcan
    
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" id="kt_drawer_chat_close">
                        <i class="ki-duotone ki-cross-square fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
    
            <!--begin::Card body-->
            <div class="card-body" id="kt_drawer_chat_messenger_body">
                <!--begin::Content-->
                <div class="scroll-y me-n5 pe-5" data-kt-element="messages" data-kt-scroll="true"
                    data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                    data-kt-scroll-dependencies="#kt_drawer_chat_messenger_header, #kt_drawer_chat_messenger_footer"
                    data-kt-scroll-wrappers="#kt_drawer_chat_messenger_body" data-kt-scroll-offset="0px">
                    <!--begin::Content-->
                        <!--begin::List Widget 4-->
                <div class="card card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body pt-5">
                        @foreach ($categories as $category)
                        <!--begin::Item-->
                        <div class="d-flex align-items-sm-center {{ $loop->last ? '' : 'mb-3' }}">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-50px me-5">
                                <i class="fas fa-folder fs-2"></i>
                            </div>
                            <!--end::Symbol-->
    
                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <div class="flex-grow-1 me-2">
                                    <a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold font-bn">{{  $category->name }}</a>
                                    <span class="text-muted fw-semibold d-block fs-7">{{  App\Helpers\Helpers::convertToBanglaDigits($category->notice_count) }} টি নোটিশ</span>
                                </div>
                                <div class="my-2">
                                    @can('edit-notice-category')
                                    <a href="#" class="btn btn-icon btn-light-info btn-sm me-1" title="Some info about it's function!" data-bs-toggle="modal" data-bs-target="#category_update_modal" onclick="inputCategoryData({{ json_encode($category) }})">
                                        <i class="ki-duotone ki-pencil fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                    @endcan

                                    @can('delete-notice-category')
                                    @if (!($category->notice_count))
                                    <form class="d-inline me-1"
                                        action="{{ route('admin.notice-category.destroy', $category->id) }}" 
                                        method="POST"
                                        onclick="submitForm(this, event,  '{{ $category->name }}')"
                                        >
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-icon btn-light-danger btn-sm me-1" title="Some info about it's function!">
                                            <i class="ki-duotone ki-trash fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                        </button>
                                    </form>
                                    @endif
                                    @endcan
                                </div>
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->
                        @endforeach
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::List Widget 4-->
                    <!--end::Content-->
                </div>
                <!--end::Messages-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Messenger-->
    </div>
    <!--end::drawer-->
    @endcan

    @can('create-notice-category')
    <!--begin::Category new modal-->
    <div class="modal fade" id="category_new_modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
            <div class="modal-header pb-3 mb-8 border-0 justify-content-between bg-light-dark">
                <!--begin::Heading-->
                <div class="text-center">
                    <!--begin::Title-->
                    <h3 class="text-gray-800 fw-semibold fs-4 font-bn">
                        নতুন ক্যাটেগরি
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
                        action="{{ route('admin.notice-category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="ki-solid ki-file fs-1"></i>
                                </span>
                                <input type="text" name="name" class="form-control font-bn" placeholder="ক্যাটেগরির নাম" aria-describedby="category name" />
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="text-center font-bn">
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
    <!--end::Category new modal-->
    @endcan

    @can('edit-notice-category')
    <!--begin::Category update modal-->
    <div class="modal fade" id="category_update_modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
            <div class="modal-header pb-3 mb-8 border-0 justify-content-between bg-light-dark">
                <!--begin::Heading-->
                <div class="text-center">
                    <!--begin::Title-->
                    <h3 class="text-gray-800 fw-semibold fs-4 font-bn">
                        আপডেট ক্যাটেগরি
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
                        action="{{ route('admin.notice-category.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="id" id="editCategoryId">

                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="ki-solid ki-file fs-1"></i>
                                </span>
                                <input type="text" name="name" id="editCategoryName" class="form-control font-bn" placeholder="ক্যাটেগরির নাম" />
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="text-center font-bn">
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
    <!--end::Category update modal-->
    @endcan
@endsection
<!--begin::Page Vendors Javascript and custom JS-->
@section('exclusive_scripts')
<script src="{{ asset('./assets/admin/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select2
            $('#newLinkCategoryId').select2();
            $('#linkUpdateCategory').select2();

            changeLinkInput();
        });

        function inputCategoryData(data, storagePath) {
            // change the form title
            $('#editCategoryId').val(data.id);
            $('#editCategoryName').val(data.name);
        }

        function submitForm(form, event, title){
            event.preventDefault();
            Swal.fire({
                title: `আপনি কি "${title}" করতে চান?`,
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

        function changeLinkInput(){
            let linkType = document.getElementById('linkType').value;
            let linkDoc = document.getElementById('linkDoc');
            let linkImage = document.getElementById('linkImage');
            let linkUrl = document.getElementById('linkUrl');

            if(linkType == 'pdf'){
                linkDoc.classList.remove('d-none');
                linkImage.classList.add('d-none');
                linkImage.value = '';
                linkUrl.classList.add('d-none');
                linkUrl.value = '';
            }else if(linkType == 'image'){
                linkImage.classList.remove('d-none');
                linkDoc.classList.add('d-none');
                linkDoc.value = '';
                linkUrl.classList.add('d-none');
                linkUrl.value = '';
            }else if(linkType == 'url'){
                linkUrl.classList.remove('d-none');
                linkDoc.classList.add('d-none');
                linkDoc.value = '';
                linkImage.classList.add('d-none');
                linkImage.value = '';
            }else{
                linkImage.classList.remove('d-none');
                linkDoc.classList.add('d-none');
                linkDoc.value = '';
                linkUrl.classList.add('d-none');
                linkUrl.value = '';
            }
        }

        let linkUpdateName = document.getElementById('linkUpdateName');
        let linkUpdateCategory = document.getElementById('linkUpdateCategory');
        let linkUpdateType = document.getElementById('linkUpdateType');
        let linkUpdateDoc = document.getElementById('linkUpdateDoc');
        let linkUpdateUrl = document.getElementById('linkUpdateUrl');
        let linkUpdateImageWrapper = document.getElementById('linkUpdateImageWrapper');
        let linkUpdateImageSection = document.getElementById('linkUpdateImageSection');
        let linkUpdateDocSection = document.getElementById('linkUpdateDocSection');
        let linkUpdateUrlSection = document.getElementById('linkUpdateUrlSection');

        function inputPageData(data, assetPath){
            linkUpdateId.value = data.id
            linkUpdateName.value = data.link?.name;
            linkUpdateStartDate.value = data.start_date?.split(' ')[0];
            // update select2
            data.category && $('#linkUpdateCategory').val(data.category.id).trigger('change');
            linkUpdateType.value = data.link?.type;
            linkUpdateUrl.value = data.link?.url;
            linkUpdateImageWrapper.style.backgroundImage = `url('${assetPath}/${data.link.image}')`;

            updateSection(data.link.type);
        }

        function updateSection(type){
            if(type == 'pdf'){
                linkUpdateDocSection.classList.remove('d-none');
                linkUpdateImageSection.classList.add('d-none');
                linkUpdateUrlSection.classList.add('d-none');
            }else if(type == 'image'){
                linkUpdateImageSection.classList.remove('d-none');
                linkUpdateDocSection.classList.add('d-none');
                linkUpdateUrlSection.classList.add('d-none');
                linkUpdateDoc.value = '';
            }else if(type == 'url'){
                linkUpdateUrlSection.classList.remove('d-none');
                linkUpdateDocSection.classList.add('d-none');
                linkUpdateImageSection.classList.add('d-none');
                linkUpdateDoc.value = '';
            }else{
                linkUpdateImageSection.classList.remove('d-none');
                linkUpdateDocSection.classList.add('d-none');
                linkUpdateDoc.value = '';
            }
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
                    { data: 'category'},
                    { data: 'size'},
                    { data: 'date', orderable: false },
                    { data: 'action' },
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
<!--end::Page Vendors Javascript and custom JS-->
