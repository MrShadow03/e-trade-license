<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <title>E-Trade License | Barishal City Corporation</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/Barisal_City_Corporation_logo.png') }}">

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" /> 
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('/assets/plugins/global/font-awesome.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/css/custom.css') }}" rel="stylesheet" type="text/css">
    <!--end::Global Stylesheets Bundle-->

    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
    <style>
        @media (min-width: 600px) {
            body {
                background-image: url('{{ asset("/assets/img/login-bg.png") }}');
            }
        }
    </style>
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column justify-content-center flex-column-fluid flex-lg-row" style="background-image: url('{{ asset('assets/img/login_bg.jpg') }}'); background-size: cover;">

            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-0 p-lg-20">
                <!--begin::Card-->
                <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-sm-600px w-100 p-10">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">

                        <!--begin::Form-->
                        <form class="form w-100 font-bn" novalidate="novalidate" id="sign_in_form" method="POST" action="{{ route('user.login.store') }}">
                            @csrf
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <img class="w-150px mb-10" alt="Logo" src="{{ asset('assets/img/Barisal_City_Corporation_logo.png') }}" style="width: 150px; aspect-ratio: 1; object-fit:contain">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bold mb-3 font-bn">ই-ট্রেড লাইসেন্স</h1>
                                <!--end::Title-->

                                <!--begin::Subtitle-->
                                <div class="text-gray-700 fw-semibold fs-6 font-bn">ফোন নম্বর এবং পাসওয়ার্ড দিয়ে লগইন করুন</div>
                                <!--end::Subtitle--->
                            </div>
                            @error('phone')
                            <div class="text-center text-danger fs-base pb-5 font-bn">ফোন নম্বর কিংবা পাসওয়ার্ড সঠিক নয়!</div>
                            @enderror
                            <!--begin::Heading-->

                            <!--begin::Input group--->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fal fa-phone-alt fs-3"></i>
                                    </span>
                                    <input type="text" placeholder="ফোন নম্বর" name="phone" value="" autocomplete="off" class="form-control font-bn">
                                </div>
                                <!--end::Email-->
                            </div>

                            <!--end::Input group--->
                            <div class="fv-row mb-3">
                                <!--begin::Password-->
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fal fa-lock fs-3"></i>
                                    </span>
                                    <input type="password" placeholder="পাসওয়ার্ড" name="password" autocomplete="off" class="form-control font-bn">
                                </div>
                                <!--end::Password-->
                            </div>
                            <!--end::Input group--->
                            
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8 mt-5">

                                <label class="form-check form-check-custom">
                                    <input class="form-check-input h-20px w-20px" type="checkbox" name="remember">
                                    <span class="form-check-label fw-semibold font-bn">আমার ডিভাইস মনে রাখুন</span>
                                </label>

                                <!--begin::Link-->
                                <a href="{{ route('user.password.request') }}" class="text-primary text-hover-underline font-bn">
                                    পাসওয়ার্ড মনে নেই ?
                                </a>
                                <!--end::Link-->
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="submit" id="sign_in_submit" class="btn btn-success font-bn">

                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">
                                        লগইন</span>
                                    <!--end::Indicator label-->

                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">
                                        অপেক্ষা করুন... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                            <!--end::Submit button-->
                        </form>
                        <!--end::Form-->

                        <div class="text-gray-700 text-center fw-semibold fs-6 font-bn">
                            একাউন্ট নেই ?&nbsp;
                    
                            <a href="{{ route('user.register') }}" class="text-primary text-hover-underline">
                                নিবন্ধন করুন
                            </a>
                        </div>

                    </div>
                    <!--end::Wrapper-->

                    {{-- <!--begin::Footer-->
                    <div class="px-lg-10 text-center">
                        <span class="fs-base text-gray-800 opacity-6">Developed By <a href="https://www.barishalcity.gov.bd" class="text-primary">Barishal City Corporation</a> | 2024</span>
                    </div>
                    <!--end::Footer--> --}}
                </div>
                <!--end::Card-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('/assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->

    <script>
        // Class definition
        var KTSigninGeneral = function() {
            // Elements
            var form;
            var submitButton;
            var validator;

            // Handle form
            var handleValidation = function(e) {
                // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
                validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {					
                            'phone': {
                                validators: {
                                    notEmpty: {
                                        message: 'ফোন নম্বর প্রদান করুন'
                                    },
                                    callback: {
                                        message: 'একটি বৈধ ফোন নম্বর প্রদান করুন',
                                        callback: function(value, validator, $field) {
                                            // Check if value is either a valid email or a valid phone number
                                            value = value.value;

                                            if (value.trim() === '') {
                                                return true; // Skip validation if field is empty
                                            }
                                            
                                            var phonePattern = /^01\d{9}$/;

                                            if (phonePattern.test(value)) {
                                                return true;
                                            }
                            
                                            return false;
                                        }
                                    }
                                }
                            },
                            'password': {
                                validators: {
                                    notEmpty: {
                                        message: 'পাসওয়ার্ড প্রদান করুন'
                                    }
                                }
                            } 
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: '.fv-row',
                                eleInvalidClass: '',  // comment to enable invalid state icons
                                eleValidClass: '' // comment to enable valid state icons
                            })
                        }
                    }
                );	
            }

            var handleSubmitDemo = function(e) {
                // Handle form submit
                submitButton.addEventListener('click', function (e) {
                    // Prevent button default action
                    e.preventDefault();

                    // Validate form
                    validator.validate().then(function (status) {
                        if (status == 'Valid') {
                            // Show loading indication
                            submitButton.setAttribute('data-kt-indicator', 'on');

                            // Disable button to avoid multiple click 
                            submitButton.disabled = true;

                            // Submit the form
                            form.submit()

                            // Remove loading indication

                              						
                        }
                    });
                });
            }


            // Public functions
            return {
                // Initialization
                init: function() {
                    form = document.querySelector('#sign_in_form');
                    submitButton = document.querySelector('#sign_in_submit');
                    
                    handleValidation();
                    handleSubmitDemo();
                }
            };
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            KTSigninGeneral.init();
        });
    </script>

</body>
</html>
