@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>{{ $link->name }} | Admin</title>
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
<form action="{{ route('admin.link.update') }}" id="aritcleForm" method="POST" enctype="multipart/form-data" id="kt_app_content_container" class="app-container container-xxl font-noto">
    @csrf
    @method('PATCH')
    <div class="card card-flush pb-0 bgi-position-y-center bgi-no-repeat mb-10 mt-5">
        <!--begin::Card header-->
        <div class="card-header pt-10 d-flex justify-content-between">
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
                        <h2 class="font-noto text-gray-900 min-w-50px" contenteditable id="changeTitle">{{ $link->name }}</h2>
                        <span class="ms-3">
                            <span class="ki-duotone ki-feather text-gray-800 fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </span>
                        </span>
                    </div>
                    <ol class="breadcrumb text-muted fs-6 fw-semibold">
                        @if($link->linkable_type === 'App\Models\MenuLink')
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.menu-link') }}" class="text-muted text-hover-primary text-hover-underline">মেনু সমূহ</a>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.menu-link.show', $link->linkable->id) }}" class="text-muted text-hover-primary text-hover-underline">{{ $link->linkable->title }}</a>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ $link->name }}</li>
                        @elseif($link->linkable_type === 'App\Models\Card')
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.card') }}" class="text-muted text-hover-primary text-hover-underline">কার্ড সমূহ</a>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.card.show', $link->linkable->id) }}" class="text-muted text-hover-primary text-hover-underline">{{ $link->linkable->title }}</a>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ $link->name }}</li>
                        @endif
                    </ol>
                </div>
                
                <!--end::Title-->
            </div>
            <!--begin::Input group-->
            <div class="w-md-250px">
                <select class="form-select" id="newLinkCategoryId" name="category">
                    <option value="" selected>কোনো ক্যাটেগরি নেই</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" @selected($category == $link->category)>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <!--end::Input group-->
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
                <!--begin::Image input-->
                <div class="fv-row" id="linkImage">
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
                        <div class="image-input-wrapper h-100px w-150px"
                        @if ($link->image)
                        style="background-image: url({{ asset('storage').'/'.$link->image }})"
                        @endif 
                        ></div>
                        <!--end::Image preview wrapper-->

                        <!--begin::Edit button-->
                        <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="change"
                        data-bs-toggle="tooltip"
                        data-bs-dismiss="click"
                        title="ছবি পরিবর্তন করুন">
                            <i class="ki-duotone ki-pencil fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            <!--begin::Inputs-->
                            <input type="file" name="image" accept=".png, .jpg, .jpeg, .webp" />
                            <!--end::Inputs-->
                        </label>
                        <!--end::Edit button-->
                    </div>
                    <div class="form-text">ফাইল টাইপ: png, jpg | সর্বোচ্চ সাইজ: 3MB</div>
                </div>
                <!--end::Image input-->
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
                {!! $link->article !!}
            </div>
        </div>
        <!--end::Card body-->
        <input type="hidden" name="name" id="linkNameInput" value="">
        <input type="hidden" name="article" id="linkArticleInput" value="">
        <input type="hidden" name="type" id="linkTypeInput" value="{{ $link->type }}">
        <input type="hidden" name="id" value="{{ $link->id }}">
    </div>
</form>
@endsection
<!--end::Main Content-->

<!--begin::Page Vendors Javascript and custom JS-->
@section('exclusive_scripts')
<script src="{{ asset('assets/admin/assets/plugins/custom/ckeditor/ckeditor-document.bundle.js') }}"></script>
<script src="{{ asset('assets/admin/assets/plugins/custom/axios/axios.min.js') }}"></script>
{{-- <script src="https://cdn.ckbox.io/ckbox/latest/ckbox.js"></script> --}}
<script>
let submitButton =  document.getElementById('submitButton');
document.addEventListener('DOMContentLoaded', function() {
            // Select2
            $('#newLinkCategoryId').select2({
                placeholder: "কোনো ক্যাটেগরি নেই",
                allowClear: true,
                tags: true
            });

            $('#newLinkCategoryId').trigger('change');
        });
        
let editor;
DecoupledEditor.create( document.querySelector( '#editor' ), {
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
        // plugins: [ 'ImageBlock'],
        ckfinder: {
            uploadUrl: '/api/image',
            options: {
                resourceType: 'Images'
            },
        },
        image: {
            insert: {
                type: 'block'
            },
            toolbar: [
                'imageStyle:block',
                '|',
                'toggleImageCaption',
                'imageTextAlternative',
            ],
        },
    })
    .then( ckeditor => {
        const toolbarContainer = document.querySelector( '#toolbar-container' );
        toolbarContainer.appendChild(ckeditor.ui.view.toolbar.element );
        editor = ckeditor;
        
        // on before remove image
        editor.model.document.on('change:data', () => {
            const changes = editor.model.document.differ.getChanges();
            changes.forEach(change => {
                // update submit button
                if(submitButton){
                    submitButton.disabled = false;
                    submitButton.classList.remove('btn-success');
                    submitButton.classList.add('btn-primary');
                    submitButton.innerHTML = '<i class="ki-duotone ki-tablet-text-up fs-2"><span class="path1"></span><span class="path2"></span></i>সেভ করুন';
                }

                console.log(change);

                if (change.type === 'attribute' && change.attributeKey === 'src' && change.attributeNewValue) {
                    axios.post('/api/link/{{ $link->id }}', {
                        _method: 'PATCH',
                        article: editor.getData()
                    }).then(response => {
                        if(submitButton){
                            submitButton.disabled = true;
                            submitButton.classList.remove('btn-primary');
                            submitButton.classList.add('btn-success');
                            submitButton.innerHTML = '<i class="ki-duotone ki-check fs-2"><span class="path1"></span><span class="path2"></span></i>সেভ হয়েছে';
                        }
                    }).catch(error => {
                        console.error(error);
                    });
                }
                if (change.type === 'remove' && (change.name === 'imageBlock' || change.name === 'imageInline' || change.name === 'image')) {
                    try {
                        const imageSrc = change.attributes.get('src');
                        axios.post(`/api/image/`, {
                            _method: 'DELETE',
                            url: imageSrc
                        }).then(response => {
                            // save the content
                            // Send the updated content to the server
                            axios.post('/api/link/{{ $link->id }}', {
                                _method: 'PATCH',
                                article: editor.getData()
                            }).then(response => {
                                if(submitButton){
                                    submitButton.disabled = true;
                                    submitButton.classList.remove('btn-primary');
                                    submitButton.classList.add('btn-success');
                                    submitButton.innerHTML = '<i class="ki-duotone ki-check fs-2"><span class="path1"></span><span class="path2"></span></i>সেভ হয়েছে';
                                }
                            }).catch(error => {
                                console.error(error);
                            });
                        }).catch(error => {
                            console.error(error);
                        });
                    } catch (error) {
                        console.error(error);
                    }
                }
            });
        });

        
    } )
    .catch( error => {
        console.error( error );
    } );

    document.getElementById('submitButton').addEventListener('click', function() {
    if (editor) {
        // Get updated content from CKEditor
        let content = editor.getData();
        document.getElementById('linkArticleInput').value = content;
        document.getElementById('linkNameInput').value = document.getElementById('changeTitle').innerText;

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
                font-bn">{{ $link->created_at->format('d M, Y') }}</div>
            </div>
            <div class="d-flex flex-column flex-grow-1">
                <div class="fw-bold font-bn">প্রকাশের সময়:</div>
                <div class="text-muted
                font-bn">{{ $link->created_at->format('h:i A') }}</div>
            </div>
        </div>
    </div>
</div> --}}