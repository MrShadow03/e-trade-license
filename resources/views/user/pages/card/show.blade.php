@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>Menu Mangaer | {{ $card->title }} | Admin</title>
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
                <div class="d-flex align-items-start">
                    <!--begin::Icon-->
                    <div class="symbol symbol-circle me-5">
                        <img src="{{ asset('storage'.'/'.$card->image) }}" alt="{{ $card->title }}">               
                    </div>
                    <!--end::Icon-->
    
                    <!--begin::Title-->
                    <div class="d-flex flex-column">
                        <h2 class="font-bn">
                            {{ $card->title }}
                        </h2>
                        <div class="text-gray-600 fs-5 font-noto">{{ App\Helpers\Helpers::convertToBanglaDigits($card->links()->count()) }} টি লিংক</div>
                        <ol class="breadcrumb text-muted fs-6 fw-semibold mt-4">
                            <li class="breadcrumb-item text-muted"><a href="{{ route('admin.card') }}" class="text-muted text-hover-primary text-hover-underline">কার্ডসমূহ</a></li>
                            <li class="breadcrumb-item text-muted">{{ $card->title }}</li>
                        </ol>                        
                    </div>
                    <!--end::Title-->
                </div>

                @can('create-card')
                <button type="button" class="btn btn-flex btn-primary font-bn text-white" data-bs-toggle="modal" data-bs-target="#modal_add_link">
                    <i class="ki-duotone ki-fasten fs-2 text-white">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    লিংক যুক্ত করুন
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
            <!--begin::Table-->
            <table id="kt_file_manager_list" data-kt-filemanager-table="files" class="table align-middle table-row-dashed fs-6 gy-5 font-bn">
                <thead class="border-bottom">
                    <tr class="text-start text-gray-700 fw-bold fs-6 text-uppercase gs-0">
                        <th class="">নাম</th>
                        <th class="">সর্বশেষ আপডেট</th>
                        <th class=""></th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @foreach ($card->links as $link)
                    <tr>
                        <td class="py-0">
                            <div class="d-flex align-items-center">
                                <span class="icon-wrapper">
                                    @if ($link->type == 'pdf')
                                    <i class="fas fa-file-pdf fs-2x text-danger me-4"></i>
                                    @elseif ($link->type == 'image')
                                    <i class="fas fa-file-image fs-2x text-success me-4"></i>
                                    @elseif ($link->type == 'url')
                                    <i class="fas fa-file-export fs-2x text-info me-4"></i>
                                    @else
                                    <i class="fas fa-file-alt fs-2x text-primary me-4"></i>
                                    @endif
                                </span>
                                <a 
                                @if ($link->type == 'article')
                                    href="{{ route('admin.link.edit', $link->id) }}"
                                @elseif ($link->type == 'pdf' || $link->type == 'image')
                                    href="javascript:void(0);" 
                                    onclick="inputPageData({{ json_encode($link) }}, '{{ asset('storage') }}')"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal_update_notice"
                                @elseif ($link->type == 'url')
                                    href="{{ $link->url }}"
                                @endif
                                class="text-gray-800 text-hover-primary"
                                target="_self"
                                >{{ $link->name}}</a>
                                @if ($link->visibility)
                                <i class="ki-duotone ki-fasten text-primary fs-3 m-0 ps-3">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                @endif
                                @if ($link->type === 'article' && (!$link->article))
                                <i class="ki-duotone ki-information text-danger fs-3 m-0 ps-1" title="অনুচ্ছেদ যুক্ত করুন">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                @endif
                            </div>
                        </td>
                        <td>
                            {{ $link->updated_at->format('d M Y, h:i a') }}
                        </td class="py-0">
                        <td class="text-end py-0" data-kt-filemanager-table="action_dropdown">
                            <div class="d-flex justify-content-end">
                                <!--begin::Share link-->
                                <div class="ms-2">
                                    @can('edit-card')
                                    @if($link->type == 'article')
                                        <a href="{{ route('admin.link.edit', $link->id) }}" class="btn btn-sm btn-icon btn-light-info" target="_self" title="পরিবর্তন করুন">
                                            <i class="ki-solid ki-feather fs-3 m-0">
                                            </i>
                                        </a>
                                    @elseif($link->type == 'pdf' || $link->type == 'image' || $link->type == 'url')
                                        <a  href="javascript:void(0);" 
                                        onclick="inputPageData({{ json_encode($link) }}, '{{ asset('storage') }}')"
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
                                    action="{{ route('admin.link.visibility', $link->id) }}"  
                                    class="btn btn-sm btn-icon 
                                    {{ $link->visibility ? 'btn-light-primary' : 'btn-secondary' }}"  
                                    method="POST"
                                    onclick="this.submit()"
                                    title="{{ $link->visibility ? 'ওয়েবসাইট থেকে সরিয়ে ফেলুন' : 'ওয়েবসাইটে যোগ করুন' }}"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        @if ($link->visibility)    
                                        <i class="ki-duotone ki-fasten fs-3 m-0">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        @else
                                        <i class="ki-duotone ki-fasten fs-3 m-0">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        @endif
                                    </form>
                                    @endcan

                                    @can('delete-card')
                                    <form 
                                    action="{{ route('admin.link.destroy', $link->id) }}"  
                                    class="btn btn-sm btn-icon btn-light-danger" 
                                    method="POST"
                                    onclick="submitForm(this, event, '{{ $link->name }}')"
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
    @can('create-card')
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
                       <h3 class="text-gray-800 fw-semibold fs-4">নতুন লিংক</h3>
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
                        action="{{ route('admin.card.link.store', $card->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>নাম</span>
                            </label>
                            <!--end::Label-->

                            <input type="text" class="form-control" name="name">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->
                        
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
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
                       <h3 class="text-gray-800 fw-semibold fs-4">আপডেট লিংক</h3>
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
                        <input type="hidden" name="id" id="linkUpdateId">
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-4 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>নাম</span>
                            </label>
                            <!--end::Label-->

                            <input type="text" id="linkUpdateName" class="form-control" name="name">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
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
@endsection
<!--end::Page Vendors Javascript and custom JS-->


@section('exclusive_scripts')
    <script>

        function submitForm(form, event, title){
            event.preventDefault();
            Swal.fire({
                title: `আপনি কি \"${title}\" মেনু লিংক ডিলিট করতে চান?`,
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
        let linkUpdateType = document.getElementById('linkUpdateType');
        let linkUpdateDoc = document.getElementById('linkUpdateDoc');
        let linkUpdateUrl = document.getElementById('linkUpdateUrl');
        let linkUpdateImageWrapper = document.getElementById('linkUpdateImageWrapper');
        let linkUpdateImageSection = document.getElementById('linkUpdateImageSection');
        let linkUpdateDocSection = document.getElementById('linkUpdateDocSection');
        let linkUpdateUrlSection = document.getElementById('linkUpdateUrlSection');

        function inputPageData(data, assetPath){
            linkUpdateId.value = data.id;
            linkUpdateName.value = data.name;
            linkUpdateType.value = data.type;
            linkUpdateUrl.value = data.url;
            linkUpdateImageWrapper.style.backgroundImage = `url('${assetPath}/${data.image}')`;

            updateSection(data.type);
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
    </script>
@endsection
