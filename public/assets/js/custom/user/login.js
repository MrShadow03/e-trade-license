var KTSigninGeneral = function() {
    // Elements
    var form;
    var submitButton;
    var validator;

    // Handle form
    var handleValidation = function(e) {
        validator = FormValidation.formValidation(
            form,
            {
                fields: {					
                    'emailOrPhone': {
                        validators: {
                            notEmpty: {
                                message: 'ফোন নম্বর অথবা ই-মেইল প্রদান করুন'
                            },
                            callback: {
                                message: 'একটি বৈধ ই-মেইল অথবা ফোন নম্বর প্রদান করুন',
                                callback: function(value, validator, $field) {
                                    // Check if value is either a valid email or a valid phone number
                                    value = value.value;

                                    if (value.trim() === '') {
                                        return true; // Skip validation if field is empty
                                    }
                                    
                                    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                    var phonePattern = /^01\d{9}$/;
                                    console.log(value)
                                    console.log('emailPattern', emailPattern.test(value))
                                    console.log('phonePattern', phonePattern.test(value))

                                    if (emailPattern.test(value) || phonePattern.test(value)) {
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
                                message: 'পাসওয়ার্ড প্রদান করুন'
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
            form = document.querySelector('#kt_sign_in_form');
            submitButton = document.querySelector('#kt_sign_in_submit');
            handleValidation();
            handleSubmitDemo();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTSigninGeneral.init();
});