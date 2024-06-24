
$(document).ready(function() {
    //initialize select2
    $('[name="business_category_id"]').select2({
        placeholder: "ব্যবসার ধরন নির্বাচন করুন",
        allowClear: true
    });
    // $('[name="ca_district_bn"]').select2();
    // $('[name="pa_district_bn"]').select2();
    $('[name="ward_no"]').select2();
    $('[name="signboard_id"]').select2();

    //initialize maxlength
    $('[name="national_id_no"]').maxlength({
        threshold: 13,
        warningClass: "badge badge-primary",
        limitReachedClass: "badge badge-success",
        limitExceededClass: "badge badge-danger"
    });
    $('[name="birth_registration_no"]').maxlength({
        threshold: 17,
        warningClass: "badge badge-danger",
        limitReachedClass: "badge badge-success",
        limitExceededClass: "badge badge-danger"
    });
    $('[name="passport_no"]').maxlength({
        warningClass: "badge badge-danger",
        limitReachedClass: "badge badge-success",
        limitExceededClass: "badge badge-danger"
    });
    $('[name="phone_no"]').maxlength({
        threshold: 11,
        warningClass: "badge badge-danger",
        limitReachedClass: "badge badge-success",
        limitExceededClass: "badge badge-danger"
    });

    //initialize assignDistrictis
    // assignDistricts('caDivisionBn', 'caDistrictBn');
    // assignDistricts('paDivisionBn', 'paDistrictBn');

    //initialize setLicenseFee
});

var imageInputElement = document.querySelectorAll(".document_input");
    imageInputElement.forEach(function (element) {
        element.addEventListener("change", function (e) {
            var fileName = e.target.files[0].name;
            var ext = fileName.split('.').pop();
            var documentId = e.target.getAttribute('data-document-id');
            var imageWrapper = document.querySelector('#imageWrapper'+documentId);
            imageWrapper.innerHTML = '';

            if (ext == 'pdf') {
                if (imageWrapper) {
                    let i = document.createElement('i');
                    i.className = 'fa fa-file-pdf image_wrapper_icon text-danger';
                    let span = document.createElement('span');
                    span.className = 'p-2 text-muted fs-7';
                    // keep the first 10 characters of the file name and add ... at the end with the extension
                    span.innerHTML = fileName.substring(0, 10) + '...' + ext;
                    imageWrapper.appendChild(span);
                    imageWrapper.appendChild(i);
                }

            }
        }
    );
});

var documentCancel = document.querySelectorAll(".document_cancel");

documentCancel?.forEach(function (element) {
    element.addEventListener("click", function (e) {
        var documentId = element.getAttribute('data-document-id');
        var imageWrapper = document.querySelector('#imageWrapper'+documentId);

        imageWrapper.innerHTML = '<i class="fal fa-file-invoice image_wrapper_icon text-danger"></i>';
    });
});

var divisionsAndDistricts = [
    [
        "চট্টগ্রাম",
        [
            "কুমিল্লা",
            "ফেনী",
            "ব্রাহ্মণবাড়িয়া",
            "রাঙ্গামাটি",
            "নোয়াখালী",
            "চাঁদপুর",
            "লক্ষ্মীপুর",
            "চট্টগ্রাম",
            "কক্সবাজার",
            "খাগড়াছড়ি",
            "বান্দরবান",
        ],
    ],
    [
        "রাজশাহী",
        [
            "সিরাজগঞ্জ",
            "পাবনা",
            "বগুড়া",
            "রাজশাহী",
            "নাটোর",
            "জয়পুরহাট",
            "চাঁপাইনবাবগঞ্জ",
            "নওগাঁ",
        ],
    ],
    [
        "খুলনা",
        [
            "যশোর",
            "সাতক্ষীরা",
            "মেহেরপুর",
            "নড়াইল",
            "চুয়াডাঙ্গা",
            "কুষ্টিয়া",
            "মাগুরা",
            "খুলনা",
            "বাগেরহাট",
            "ঝিনাইদহ",
        ],
    ],
    [
        "বরিশাল",
        ["ঝালকাঠি", "পটুয়াখালী", "পিরোজপুর", "বরিশাল", "ভোলা", "বরগুনা"],
    ],
    ["সিলেট", ["সিলেট", "মৌলভীবাজার", "হবিগঞ্জ", "সুনামগঞ্জ"]],
    [
        "ঢাকা",
        [
            "নরসিংদী",
            "গাজীপুর",
            "শরীয়তপুর",
            "নারায়ণগঞ্জ",
            "টাঙ্গাইল",
            "কিশোরগঞ্জ",
            "মানিকগঞ্জ",
            "ঢাকা",
            "মুন্সিগঞ্জ",
            "রাজবাড়ী",
            "মাদারীপুর",
            "গোপালগঞ্জ",
            "ফরিদপুর",
        ],
    ],
    [
        "রংপুর",
        [
            "পঞ্চগড়",
            "দিনাজপুর",
            "লালমনিরহাট",
            "নীলফামারী",
            "গাইবান্ধা",
            "ঠাকুরগাঁও",
            "রংপুর",
            "কুড়িগ্রাম",
        ],
    ],
    ["ময়মনসিংহ", ["শেরপুর", "ময়মনসিংহ", "জামালপুর", "নেত্রকোণা"]],
];
const assignDistricts = (divisionElementID, districtElementID) => {
    const divisionElement = document.getElementById(divisionElementID);
    const districtElement = document.getElementById(districtElementID);
    const division = divisionElement.value;
    const districts = divisionsAndDistricts.find((item) => item[0] === division)[1];
    districtElement.innerHTML = "";
    districts.forEach((district) => {
        const option = document.createElement("option");
        option.value = district;
        option.text = district;
        districtElement.appendChild(option);
    });

    // Trigger change event
    districtElement.dispatchEvent(new Event("change"));
};

const caHoldingNo = document.querySelector('[name="ca_holding_no"]');
const caRoadNo = document.querySelector('[name="ca_road_no"]');
const caPostCode = document.querySelector('[name="ca_post_code"]');
const caVillageBn = document.querySelector('[name="ca_village_bn"]');
const caVillage = document.querySelector('[name="ca_village"]');
const caPostOfficeBn = document.querySelector('[name="ca_post_office_bn"]');
const caPostOffice = document.querySelector('[name="ca_post_office"]');
const caDivisionBn = document.querySelector('[name="ca_division_bn"]');
const caDistrictBn = document.querySelector('[name="ca_district_bn"]');
const caUpazillaBn = document.querySelector('[name="ca_upazilla_bn"]');
const caUpazilla = document.querySelector('[name="ca_upazilla"]');

const paHoldingNo = document.querySelector('[name="pa_holding_no"]');
const paRoadNo = document.querySelector('[name="pa_road_no"]');
const paPostCode = document.querySelector('[name="pa_post_code"]');
const paVillageBn = document.querySelector('[name="pa_village_bn"]');
const paVillage = document.querySelector('[name="pa_village"]');
const paPostOfficeBn = document.querySelector('[name="pa_post_office_bn"]');
const paPostOffice = document.querySelector('[name="pa_post_office"]');
const paDivisionBn = document.querySelector('[name="pa_division_bn"]');
const paDistrictBn = document.querySelector('[name="pa_district_bn"]');
const paUpazillaBn = document.querySelector('[name="pa_upazilla_bn"]');
const paUpazilla = document.querySelector('[name="pa_upazilla"]');

const sameAsCurrentCheckbox = document.getElementById("sameAsCurrentAddress");

[caHoldingNo, caRoadNo, caPostCode, caVillageBn, caVillage, caPostOfficeBn, caPostOffice, caDivisionBn, caDistrictBn, caUpazillaBn, caUpazilla].forEach((element) => {
    ['keyup', 'change', 'input'].forEach((event) => {
        element?.addEventListener(event, () => {
            if (sameAsCurrentCheckbox.checked) {
                sameAsCa(sameAsCurrentCheckbox, element.getAttribute('name').replace('ca_', 'pa_'));
            }
        });
    });
});


const sameAsCa = (element, revalidationField = null) => {

    if (element.checked) {
        paHoldingNo.value = caHoldingNo.value;
        paRoadNo.value = caRoadNo.value;
        paPostCode.value = caPostCode.value;
        paVillageBn.value = caVillageBn.value;
        paVillage.value = caVillage.value;
        paPostOfficeBn.value = caPostOfficeBn.value;
        paPostOffice.value = caPostOffice.value;
        paDivisionBn.value = caDivisionBn.value;
        paDistrictBn.value = caDistrictBn.value;
        paUpazillaBn.value = caUpazillaBn.value;
        paUpazilla.value = caUpazilla.value;

        // Trigger change event for all elements
        [paDivisionBn, paDistrictBn].forEach((element) => {
            element.dispatchEvent(new Event("change"));
        });
        
        const validator = KTSigninGeneral.getValidator();

        if (revalidationField) {
            validator.revalidateField(revalidationField);
        }else {
            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    // Valid form, proceed with your logic
                } else {
                    // Invalid form, handle accordingly
                }
            });
        }
    } 
};

['national_id_no', 'birth_registration_no', 'passport_no'].forEach((name) => {
    const element = document.querySelector(`[name="${name}"]`);
    element.addEventListener('input', () => {
        const validator = KTSigninGeneral.getValidator();
        validator.revalidateField('national_id_no');
        validator.revalidateField('birth_registration_no');
        validator.revalidateField('passport_no');
    });
});


var validator;
var KTSigninGeneral = function() {
    // Elements
    var form;
    var submitButton;
    var fileInputs;
    var documentNames = JSON.parse(document.getElementById('documentsInput').value);

    var handleValidation = function(e) {
        const requiredAndEnglish = (regex = /^[A-Za-z\. ]+$/, notEmptyMessage="অবশ্যই প্রদান করতে হবে") => ({
            notEmpty: {
                message: notEmptyMessage
            },
            callback: {
                message: 'শুধুমাত্র ইংরেজি অক্ষর গ্রহণযোগ্য',
                callback: function(value, validator, field) {
                    // Check if value is either a valid email or a valid phone number
                    var input = value.element;
                    value = value.value;

                    if (value.trim() === '') {
                        return true; // Skip validation if field is empty
                    }
                    
                    var englishPattern = regex;

                    if (englishPattern.test(value)) {
                        return true;
                    }

                    //delete the last character from the input
                    input.value = input.value.slice(0, -1);
                    return false;
                }
            }
        });

        var requiredAndBengali = (regex = /^[\u0980-\u09FF ]+$/, notEmptyMessage="অবশ্যই প্রদান করতে হবে") => ({
            notEmpty: {
                message: notEmptyMessage
            },
            callback: {
                message: 'শুধুমাত্র বাংলা অক্ষর গ্রহণযোগ্য',
                callback: function(value, validator, field) {
                    // Check if value is either a valid email or a valid phone number
                    var input = value.element;
                    value = value.value;


                    if (value.trim() === '') {
                        return true; // Skip validation if field is empty
                    }
                    
                    var bengaliPattern = regex;

                    if (bengaliPattern.test(value)) {
                        return true;
                    }

                    //delete the last character from the input
                    input.value = input.value.slice(0, -1);
                    
                    return false;
                }
            }
        });

        var documentValidations = {};
        documentNames.forEach((doc) => {
            documentValidations['documents['+doc+']'] = {
                validators: {
                    notEmpty: {
                        message: 'ডকুমেন্টটি সংযুক্ত করুন'
                    },
                    file: {
                        extension: 'jpeg,jpg,png,pdf',
                        type: 'image/jpeg,image/png,application/pdf',
                        maxSize: 1048576,   // 1MB
                        message: 'সঠিক ফাইল ফরম্যাট: jpeg, jpg, png, pdf <br> সর্বোচ্চ আকার ১ মেগাবাইট'
                    }
                }
            };
        });

        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    ...documentValidations,
                    'image': {
                        validators: {
                            notEmpty: {
                                message: 'ছবি আপলোড করুন'
                            },
                            file: {
                                extension: 'jpeg,jpg,png',
                                type: 'image/jpeg,image/png',
                                maxSize: 1024*1024*2,   // 2MB
                                message: 'সঠিক ফাইল ফরম্যাট: jpeg, jpg, png | সর্বোচ্চ আকার ২ মেগাবাইট'
                            }
                        }
                    },
                    'name_bn': {
                        validators: requiredAndBengali(),
                    },
                    'name': {
                        validators: requiredAndEnglish(),
                    },
                    'father_name_bn': {
                        validators: requiredAndBengali(),
                    },
                    'father_name': {
                        validators: requiredAndEnglish(),
                    },
                    'mother_name_bn': {
                        validators: requiredAndBengali(),
                    },
                    'mother_name': {
                        validators: requiredAndEnglish(),
                    },
                    'spouse_name_bn': {
                        validators: {
                            callback: {
                                message: 'শুধুমাত্র বাংলা অক্ষর গ্রহণযোগ্য',
                                callback: function(value, validator, field) {
                                    // Check if value is either a valid email or a valid phone number
                                    var input = value.element;
                                    value = value.value;

                                    if (value.trim() === '') {
                                        return true; // Skip validation if field is empty
                                    }
                                    
                                    var bengaliPattern = /^[\u0980-\u09FF ]+$/;

                                    if (bengaliPattern.test(value)) {
                                        return true;
                                    }

                                    //delete the last character from the input
                                    input.value = input.value.slice(0, -1);

                                    return false;
                                }
                            }
                        }
                    },
                    'spouse_name': {
                        validators: {
                            callback: {
                                message: 'শুধুমাত্র ইংরেজি অক্ষর গ্রহণযোগ্য',
                                callback: function(value, validator, field) {
                                    // Check if value is either a valid email or a valid phone number
                                    var input = value.element;
                                    value = value.value;

                                    if (value.trim() === '') {
                                        return true; // Skip validation if field is empty
                                    }
                                    
                                    var englishPattern = /^[A-Za-z ]+$/;

                                    if (englishPattern.test(value)) {
                                        return true;
                                    }

                                    //delete the last character from the input
                                    input.value = input.value.slice(0, -1);
                                    
                                    return false;
                                }
                            }
                        }
                    },
                    'national_id_no': {
                        validators: {
                            stringLength: {
                                min: 13,
                                max: 17,
                                message: 'জাতীয় পরিচয়পত্র নং ১৩ থেকে ১৭ অক্ষরের মধ্যে হতে হবে'
                            },
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                            },
                            callback: {
                                message: 'যেকোনো একটি অবশ্যই প্রদান করতে হবে',
                                callback: function(value, validator, field) {
                                    var nationalId = $('[name="national_id_no"]').val();
                                    var birthCertificate = $('[name="birth_registration_no"]').val();
                                    var passport = $('[name="passport_no"]').val();

                                    if (nationalId.trim() === '' && birthCertificate.trim() === '' && passport.trim() === '') {
                                        return false;
                                    }

                                    $regex = /^[0-9]+$/;

                                    return true;
                                }
                            }
                        }
                    },
                    'birth_registration_no': {
                        validators: {
                            stringLength: {
                                min: 17,
                                max: 17,
                                message: 'জন্ম নিবন্ধন নং ১৭ অক্ষরের হতে হবে'
                            },
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                            },
                            callback: {
                                message: 'যেকোনো একটি অবশ্যই প্রদান করতে হবে',
                                callback: function(value, validator, field) {
                                    var nationalId = $('[name="national_id_no"]').val();
                                    var birthCertificate = $('[name="birth_registration_no"]').val();
                                    var passport = $('[name="passport_no"]').val();

                                    if (nationalId.trim() === '' && birthCertificate.trim() === '' && passport.trim() === '') {
                                        return false;
                                    }

                                    return true;
                                }
                            }
                        }
                    },
                    'passport_no': {
                        validators: {
                            stringLength: {
                                min: 9,
                                max: 9,
                                message: 'পাসপোর্ট নং ৯ অক্ষরের হতে হবে'
                            },
                            callback: {
                                message: 'যেকোনো একটি অবশ্যই প্রদান করতে হবে',
                                callback: function(value, validator, field) {
                                    var nationalId = $('[name="national_id_no"]').val();
                                    var birthCertificate = $('[name="birth_registration_no"]').val();
                                    var passport = $('[name="passport_no"]').val();

                                    if (nationalId.trim() === '' && birthCertificate.trim() === '' && passport.trim() === '') {
                                        return false;
                                    }

                                    //make the passport number uppercase
                                    value.element.value = value.element.value.toUpperCase();

                                    return true;
                                }
                            }
                        }
                    },
                    'business_organization_name_bn': {
                        validators: requiredAndBengali()
                    },
                    'business_organization_name': {
                        validators: requiredAndEnglish()
                    },
                    'address_of_business_organization_bn': {
                        validators: requiredAndBengali(/^[\u0980-\u09FF\,\.\- ]+$/)
                    },
                    'address_of_business_organization': {
                        validators: requiredAndEnglish(/^[A-Za-z0-9\,\.\- ]+$/)
                    },
                    'nature_of_business_bn': {
                        validators: {
                            notEmpty: {
                                message: 'অবশ্যই নির্বাচন করতে হবে'
                            }
                        }
                    },
                    'signboard_id': {
                        validators: {
                            notEmpty: {
                                message: 'অবশ্যই নির্বাচন করতে হবে'
                            }
                        }
                    },
                    'business_category_id': {
                        validators: {
                            notEmpty: {
                                message: 'অবশ্যই নির্বাচন করতে হবে'
                            }
                        }
                    },
                    'ward_no': {
                        validators: {
                            notEmpty: {
                                message: 'অবশ্যই নির্বাচন করতে হবে'
                            }
                        }
                    },
                    'phone_no': {
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
                    'tin_no': {
                        validators: {
                            
                        }
                    },
                    'bin_no': {
                        validators: {
                            
                        }
                    },
                    'business_start_date': {
                        validators: {
                            notEmpty: {
                                message: 'অবশ্যই প্রদান করতে হবে'
                            }
                        }
                    },

                    'email': {
                        validators: {
                            emailAddress: {
                                message: 'সঠিক ইমেইল প্রদান করুন'
                            }
                        }
                    },
                    'ca_holding_no': {
                        validators: {
                            notEmpty: {
                                message: 'অবশ্যই প্রদান করতে হবে'
                            },
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                            }
                        }
                    },
                    'ca_road_no': {
                        validators: 
                        {
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                            }
                        }
                    },
                    'ca_post_code': {
                        validators: {
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                            }
                        }
                    },
                    'ca_village_bn': {
                        validators: requiredAndBengali(/^[\u0980-\u09FF\,\.\- ]+$/)
                    },
                    'ca_village': {
                        validators: requiredAndEnglish(/^[A-Za-z0-9\,\.\- ]+$/)
                    },
                    'ca_post_office_bn': {
                        validators: requiredAndBengali(/^[\u0980-\u09FF\,\.\- ]+$/)
                    },
                    'ca_post_office': {
                        validators: requiredAndEnglish(/^[A-Za-z0-9\,\.\- ]+$/)
                    },
                    'ca_upazilla_bn': {
                        validators: requiredAndBengali(/^[\u0980-\u09FF\,\.\- ]+$/)
                    },
                    'ca_upazilla': {
                        validators: requiredAndEnglish(/^[A-Za-z0-9\,\.\- ]+$/)
                    },
                    'pa_holding_no': {
                        validators: {
                            notEmpty: {
                                message: 'অবশ্যই প্রদান করতে হবে'
                            },
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                            }
                        }
                    },
                    'pa_road_no': {
                        validators: 
                        {
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                            }
                        }
                    },
                    'pa_post_code': {
                        validators: {
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: 'শুধুমাত্র ইংরেজি সংখ্যা গ্রহণযোগ্য'
                            }
                        }
                    },
                    'pa_village_bn': {
                        validators: requiredAndBengali(/^[\u0980-\u09FF\,\.\- ]+$/)
                    },
                    'pa_village': {
                        validators: requiredAndEnglish(/^[A-Za-z0-9\,\.\- ]+$/)
                    },
                    'pa_post_office_bn': {
                        validators: requiredAndBengali(/^[\u0980-\u09FF\,\.\- ]+$/)
                    },
                    'pa_post_office': {
                        validators: requiredAndEnglish(/^[A-Za-z0-9\,\.\- ]+$/)
                    },
                    'pa_upazilla_bn': {
                        validators: requiredAndBengali(/^[\u0980-\u09FF\,\.\- ]+$/)
                    },
                    'pa_upazilla': {
                        validators: requiredAndEnglish(/^[A-Za-z0-9\,\.\- ]+$/)
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        // eleInvalidClass: '',  // comment to enable invalid state icons
                        // eleValidClass: '' // comment to enable valid state icons
                    })
                }
            }
        );
    }

    var handleSubmit = function(e) {
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
                } else {
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
            });
        });
    }


    // Public functions
    return {
        // Initialization
        init: function() {
            form = document.querySelector('#tl_application_form');
            submitButton = document.querySelector('#tl_application_submit');
            handleValidation();
            handleSubmit();
        },
        getValidator: function() {
            return validator;
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTSigninGeneral.init();
});