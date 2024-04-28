@extends('admin.layouts.app')
<!--begin::Page Title-->
@section('title')
    <title>{{ auth()->user()->name }}'s Profile | Admin</title>
@endsection
<!--end::Page Title-->

<!--begin::Page Custom Styles(used by this page)-->
@section('exclusive_styles')
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/admin/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assets/admin/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css">
    <!--end::Vendor Stylesheets-->
    <style>
        tbody.hide-child {
            display: none;
        }

        .image-input-placeholder {
            background-image: url('{{ asset('assets/admin/assets/media/svg/avatars/blank.svg') }}');
        }

        [data-bs-theme="dark"] .image-input-placeholder {
            background-image: url('{{ asset('assets/admin/assets/media/svg/avatars/blank-dark.svg') }}');
        }
    </style>
@endsection
<!--end::Page Custom Styles-->

<!--begin::Main Content-->
@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl mt-7 font-bn">
        <div class="d-flex flex-column flex-xl-row">
            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10 d-none d-md-block">

                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Card body-->
                    <div class="card-body pt-15">
                        <!--begin::Summary-->
                        <div class="d-flex flex-center flex-column mb-5">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-150px symbol-circle mb-7">
                                <img src="{{ asset('storage').'/'.auth()->user()->image }}" alt="" class="object-fit-cover">
                            </div>
                            <!--end::Avatar-->

                            <!--begin::Name-->
                            <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">{{ auth()->user()->name }}</a>
                            <!--end::Name-->

                            <!--begin::Email-->
                            @if (auth()->user()->company)
                            <a href="#" class="fs-5 fw-semibold text-muted text-hover-primary mb-6">{{ auth()->user()->company }}</a>
                            @else
                            <a href="#" class="fs-5 fw-semibold text-muted text-hover-primary mb-6">{{ auth()->user()->email }}</a>
                            @endif
                            <!--end::Email-->
                        </div>
                        <!--end::Summary-->

                        <!--begin::Details toggle-->
                        <div class="d-flex flex-stack fs-4 py-3">
                            <div class="fw-bold">
                                তথ্যাবলী
                            </div>

                            <!--begin::Badge-->
                            <div class="badge badge-light-info d-inline"></div>
                            <!--begin::Badge-->
                        </div>
                        <!--end::Details toggle-->

                        <div class="separator separator-dashed my-3"></div>
                        
                        <!--begin::Details content-->
                        <div class="pb-5 fs-6">
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">ID</div>
                            <div class="text-gray-600">ID-{{ auth()->user()->id }}</div>
                            <!--begin::Details item-->
                            {{-- <!--begin::Details item-->
                            <div class="fw-bold mt-5">Position</div>
                            <div class="text-gray-600">{{ ucfirst(auth()->user()->designation ?? '') }}</div>
                            <!--begin::Details item--> --}}
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">ই-মেইল</div>
                            <div class="text-gray-600"><a href="#"
                                    class="text-gray-600 text-hover-primary">{{ auth()->user()->email }}</a></div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">ফোন নম্বর</div>
                            <div class="text-gray-600">{{ auth()->user()->phone_number ?? '' }}</div>
                            <!--begin::Details item-->
                        </div>
                        <!--end::Details content-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">
                {{-- <!--begin:::Tabs-->
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 active" id="settingsTabButton" data-bs-toggle="tab"
                            href="#customer_general">General Settings</a>
                    </li>
                    <!--end:::Tab item-->
                </ul>
                <!--end:::Tabs--> --}}

                <!--begin:::Tab content-->
                <div class="tab-content" id="tabContent">
                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade show active" id="customer_general" role="tabpanel">
                        <!--begin::Card-->
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card body-->
                            <div class="card-body pt-0 pb-5">
                                <!--begin::Form-->
                                <form class="form" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" id="profile_form">
                                    @csrf
                                    @method('PATCH')
                                    <!--begin::Input group-->
                                    <div class="mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span>ছবি</span>

                                            <span class="ms-1" data-bs-toggle="tooltip"
                                                title="Allowed file types: png, jpg, jpeg.">
                                                <i class="ki-duotone ki-information fs-7">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Image input wrapper-->
                                        <div class="mt-1">
                                            <!--begin::Image input placeholder-->
                                            <!--end::Image input placeholder-->

                                            <!--begin::Image input-->
                                            <div class="image-input image-input-outline image-input-placeholder"
                                                data-kt-image-input="true">
                                                <!--begin::Preview existing avatar-->
                                                <div class="image-input-wrapper w-125px h-125px"
                                                    style="background-image: url({{ asset('storage').'/'.auth()->user()->image }})">
                                                </div>
                                                <!--end::Preview existing avatar-->

                                                <!--begin::Edit-->
                                                <label
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                    title="পরবর্তন করুন">
                                                    <i class="ki-duotone ki-pencil fs-7">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    <!--begin::Inputs-->
                                                        <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Edit-->

                                                <!--begin::Cancel-->
                                                <span
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                    title="বাতিল করুন">
                                                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span
                                                            class="path2"></span></i> </span>
                                                <!--end::Cancel-->
                                            </div>
                                            <!--end::Image input-->
                                        </div>
                                        <!--end::Image input wrapper-->
                                    </div>
                                    <!--end::Input group-->

                                    <div class="row row-cols-1">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold mb-2 required">নাম</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <i class="bi bi-person fs-3"></i>
                                                </div>
                                                <input type="text" class="form-control" placeholder="" name="name" value="{{ auth()->user()->name }}" required/> 
                                            </div>
                                            <!--end::Input-->
                                            @error('name')
                                            <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <!--begin::Row-->
                                    <div class="row row-cols-1 row-cols-md-2">
                                        <!--begin::Col-->
                                        <div class="col">
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="required">ই-মেইল</span>

                                                    <span class="ms-1" data-bs-toggle="tooltip" title="আপনি এই ই-মেইল ব্যবহার করে লগইন করতে পারেন">
                                                        <i class="ki-duotone ki-information fs-7">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i> 
                                                    </span>
                                                </label>
                                                <!--end::Label-->

                                                <!--begin::Input-->
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <i class="bi bi-envelope fs-3"></i>
                                                    </div>  
                                                    <input type="email" class="form-control" placeholder="" name="email" value="{{ auth()->user()->email }}" />
                                                </div>
                                                <!--end::Input-->

                                                @error('email')
                                                    <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Col-->

                                        <!--begin::Col-->
                                        <div class="col">
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="required">ফোন নম্বর</span>

                                                    <span class="ms-1" data-bs-toggle="tooltip" title="আপনার ফোন নম্বর যাতে আমরা আপনার সাথে যোগাযোগ করতে পারি">
                                                        <i class="ki-duotone ki-information fs-7">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </span>
                                                </label>
                                                <!--end::Label-->

                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <i class="bi bi-telephone fs-3"></i>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="" name="phone_number" value="{{ auth()->user()->phone_number }}" required/>
                                                </div>
                                                <!--begin::Input-->
                                                <!--end::Input-->
                                                @error('phone_number')
                                                    <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>  
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">ঠিকানা</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <i class="bi bi-geo-alt fs-3"></i>
                                            </div>
                                            <input type="text" class="form-control" name="address" value="{{ auth()->user()->address }}" />
                                        </div>
                                        <!--end::Input-->
                                        @error('address')
                                            <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">বর্তমান পাসওয়ার্ড</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <i class="la la-key fs-3"></i>
                                            </div>
                                            <input type="password" class="form-control" name="current_password" />
                                        </div>
                                        <!--end::Input-->
                                        @error('password')
                                            <div class="fv-plugins message-container invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!--end::Input group-->

                                    <div class="d-flex justify-content-end">
                                        <!--begin::Button-->
                                        <button type="submit" id="profile_submit"
                                            class="btn btn-light-primary">
                                            <span class="indicator-label">পরিবর্তন করুন</span>
                                            <span class="indicator-progress">অপেক্ষা করুন...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                        <!--end::Button-->
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->

                        <!--begin::Card-->
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>পাসওয়ার্ড পরিবর্তন করুন</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0 pb-5">
                                <!--begin::Table wrapper-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed gy-5"
                                        id="kt_table_users_login_session">
                                        <!--begin::Table body-->
                                        <tbody class="fs-6 fw-semibold text-gray-600">
                                            <tr>
                                                <td class="text-danger">পাসওয়ার্ড</td>
                                                <td>******</td>
                                                <td class="text-end">
                                                    <button type="button"
                                                        class="btn btn-icon btn-active-light-danger w-30px h-30px ms-auto"
                                                        data-bs-toggle="modal" data-bs-target="#kt_modal_update_password">
                                                        <i class="ki-duotone ki-pencil fs-3"><span
                                                                class="path1"></span><span class="path2"></span></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table wrapper-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end:::Tab pane-->
                </div>
                <!--end:::Tab content-->
            </div>
            <!--end::Content-->
        </div>
    </div>
    
    <div class="modal fade font-bn" id="kt_modal_update_password" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">পাসওয়ার্ড পরিবর্তন করুন</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="update_password_form" class="form" action="{{ route('admin.profile.password') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <!--begin::Input group -->
                        <div class="fv-row mb-10">
                            <label class="required form-label fs-6 mb-2">বর্তমান পাসওয়ার্ড</label>

                            <input class="form-control form-control-lg" type="password" placeholder="****" name="current_password" autocomplete="off" />
                        </div>
                        <!--end::Input group--->

                        <!--begin::Input group-->
                        <div class="mb-10 fv-row" data-kt-password-meter="true">
                            <!--begin::Wrapper-->
                            <div class="mb-1">
                                <!--begin::Label-->
                                <label class="form-label fw-semibold fs-6 mb-2">
                                    নতুন পাসওয়ার্ড
                                </label>
                                <!--end::Label-->

                                <!--begin::Input wrapper-->
                                <div class="position-relative mb-3">
                                    <input class="form-control form-control-lg" type="password"
                                        placeholder="" name="password" autocomplete="off" />

                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                        data-kt-password-meter-control="visibility">
                                        <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span></i> <i class="ki-duotone ki-eye d-none fs-1"><span
                                                class="path1"></span><span class="path2"></span><span
                                                class="path3"></span></i> </span>
                                </div>
                                <!--end::Input wrapper-->

                                <!--begin::Meter-->
                                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                </div>
                                <!--end::Meter-->
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Hint-->
                            <div class="text-muted">
                                {{-- Use 8 or more characters with a mix of letters, numbers & symbols. --}}
                                অবশ্যই ৮ অথবা তার অধিক অক্ষর হতে হবে। বর্ণ, সংখ্যা এবং চিহ্নের মিশ্রণ থাকা ভালো।
                            </div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group--->

                        <!--begin::Input group--->
                        <div class="fv-row mb-10">
                            <label class="form-label fw-semibold fs-6 mb-2">নতুন পাসওয়ার্ড নিশ্চিত করুন</label>

                            <input class="form-control form-control-lg" type="password" placeholder=""
                                name="password_confirmation" autocomplete="off" />
                        </div>
                        <!--end::Input group--->

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">
                                বাতিল করুন
                            </button>

                            <button type="submit" class="btn btn-danger" data-kt-users-modal-action="submit">
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
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
@endsection
<!--end::Main Content-->
    
@section('exclusive_scripts')
    <script>
        // Class definition
        var updateProfile = function () {
            var submitButton;
            var validator;
            var form;
            var passwordForm;
            var passwordSubmitButton;

            // Init form inputs
            var handleForm = function () {
                validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            'name': {
                                validators: {
                                    notEmpty: {
                                        message: 'নাম অবশ্যই প্রয়োজন'
                                    }
                                }
                            },
                            'email': {
                                validators: {
                                    emailAddress: {
                                        message: 'একটি বৈধ ই-মেইল ঠিকানা প্রদান করুন'
                                    },
                                    notEmpty: {
                                        message: 'ই-মেইল অবশ্যই প্রয়োজন'
                                    }
                                }
                            },
                            'phone_number': {
                                validators: {
                                    notEmpty: {
                                        message: 'ফোন নম্বর অবশ্যই প্রয়োজন'
                                    },
                                    stringLength: {
                                        min: 11,
                                        max: 11,
                                        message: 'ফোন নম্বর অবশ্যই ১১ অক্ষরের হতে হবে'
                                    },
                                }
                            },
                            'current_password': {
                                validators: {
                                    notEmpty: {
                                        message: 'বর্তমান পাসওয়ার্ড অবশ্যই প্রয়োজন'
                                    }
                                }
                            },
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
                
                passwordFormValidator = FormValidation.formValidation(
                    passwordForm,
                    {
                        fields: {
                            'current_password': {
                                validators: {
                                    notEmpty: {
                                        message: 'বর্তমান পাসওয়ার্ড অবশ্যই প্রয়োজন'
                                    }
                                }
                            },
                            'password': {
                                validators: {
                                    notEmpty: {
                                        message: 'নতুন পাসওয়ার্ড অবশ্যই প্রয়োজন'
                                    },
                                    stringLength: {
                                        min: 8,
                                        message: 'পাসওয়ার্ড অবশ্যই ৮ অক্ষরের হতে হবে'
                                    }
                                }
                            },
                            'password_confirmation': {
                                validators: {
                                    notEmpty: {
                                        message: 'নতুন পাসওয়ার্ড নিশ্চিত করুন'
                                    },
                                    identical: {
                                        compare: function () {
                                            return form.querySelector('[name="password"]').value;
                                        },
                                        message: 'নতুন পাসওয়ার্ড এবং নিশ্চিত পাসওয়ার্ড মেলে না'
                                    }
                                }
                            },
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

                
                // Action buttons
                submitButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    // Validate form before submit
                    if (validator) {
                        validator.validate().then(function (status) {
                            if (status == 'Valid') {
                                submitButton.setAttribute('data-kt-indicator', 'on');

                                // Disable submit button whilst loading
                                submitButton.disabled = true;

                                // Submit form
                                form.submit();

                            } else {
                                Swal.fire({
                                    title: "সঠিক তথ্য প্রদান করুন!",
                                    text: "আপনার প্রদত্ত তথ্য সঠিক নয়। দয়া করে সঠিক তথ্য প্রদান করুন।",
                                    icon: "warning",
                                    buttonsStyling: false,
                                    confirmButtonText: "ঠিক আছে!",
                                    customClass: {
                                        confirmButton: "btn btn-danger font-bn order-2",
                                        cancelButton: 'btn btn-secondary font-bn order-1 right-gap',
                                        title: "font-bn",
                                        container: "font-bn",
                                    }
                                });
                            }
                        });
                    }
                });

                passwordSubmitButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    // Validate form before submit
                    if (passwordFormValidator) {
                        passwordFormValidator.validate().then(function (status) {
                            if (status == 'Valid') {
                                passwordSubmitButton.setAttribute('data-kt-indicator', 'on');

                                // Disable submit button whilst loading
                                passwordSubmitButton.disabled = true;

                                // Submit form
                                passwordForm.submit();

                            } else {
                                Swal.fire({
                                    title: "সঠিক তথ্য প্রদান করুন!",
                                    text: "আপনার প্রদত্ত তথ্য সঠিক নয়। দয়া করে সঠিক তথ্য প্রদান করুন।",
                                    icon: "warning",
                                    buttonsStyling: false,
                                    confirmButtonText: "ঠিক আছে!",
                                    customClass: {
                                        confirmButton: "btn btn-danger font-bn order-2",
                                        cancelButton: 'btn btn-secondary font-bn order-1 right-gap',
                                        title: "font-bn",
                                        container: "font-bn",
                                    }
                                });
                            }
                        });
                    }
                });
            }

            return {
                // Public functions
                init: function () {
                    // Elements
                    form = document.querySelector('#profile_form');
                    submitButton = form.querySelector('#profile_submit');

                    passwordForm = document.querySelector('#update_password_form');
                    passwordSubmitButton = passwordForm.querySelector('[data-kt-users-modal-action="submit"]');

                    handleForm();
                }
            };
        }();
        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            updateProfile.init();
        });

    </script>
@endsection
<!--end::Page Vendors Javascript and custom JS-->
