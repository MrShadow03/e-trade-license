<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class TradeLicenseStoreRequest extends FormRequest {
    public function authorize(): bool{
        return true;
    }

    public function rules(): array {
        return [
            'name_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF} ]+$/u'],
            'name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\. ]+$/'],
            'business_category_id' => ['required', 'exists:business_categories,id'],
            'signboard_id' => ['required', 'exists:signboards,id'],
            'father_name_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF} ]+$/u'],
            'father_name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\. ]+$/'],
            'mother_name_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF} ]+$/u'],
            'mother_name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\. ]+$/'],
            'spouse_name_bn' => ['nullable', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF} ]+$/u'],
            'spouse_name' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z\. ]+$/'],
            'national_id_no' => ['required'],
            'birth_registration_no' => ['required_without_all:national_id_no,passport_no'],
            'passport_no' => ['required_without_all:national_id_no,birth_registration_no'],
            'business_organization_name_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF}\" ]+$/u', 'unique:trade_license_applications,business_organization_name_bn'],
            'business_organization_name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z ]+$/', 'unique:trade_license_applications,business_organization_name'],
            'nature_of_business_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF} ]+$/u'],
            'business_category_id' => ['required', 'exists:business_categories,id'],
            'address_of_business_organization_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF}\,\.\- ]+$/u'],
            'address_of_business_organization' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\,\.\- ]+$/'],
            'zone_bn' => ['nullable', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF} ]+$/u'],
            'ward_no' => ['required'],
            'tin_no' => ['nullable', 'regex:/^[0-9]+$/'],
            'bin_no' => ['nullable', 'regex:/^[0-9]+$/'],
            'phone_no' => ['required', 'min:11', 'max:11'],
            'email' => ['nullable', 'email'],
            'fiscal_year' => ['required'],
            'business_starting_date' => ['required'],
            'ca_holding_no' => ['required'],
            'ca_road_no' => ['nullable'],
            'ca_post_code' => ['nullable'],
            'ca_village_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF}\,\.\- ]+$/u'],
            'ca_village' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\,\.\- ]+$/'],
            'ca_post_office_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF}\,\.\- ]+$/u'],
            'ca_post_office' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\,\.\- ]+$/'],
            'ca_division_bn' => ['required', 'string', 'max:255'],
            'ca_district_bn' => ['required', 'string', 'max:255'],
            'ca_upazilla_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF}\,\.\- ]+$/u'],
            'ca_upazilla' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\,\.\- ]+$/'],
            'pa_holding_no' => ['required'],
            'pa_road_no' => ['nullable'],
            'pa_post_code' => ['nullable'],
            'pa_village_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF}\,\.\- ]+$/u'],
            'pa_village' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\,\.\- ]+$/'],
            'pa_post_office_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF}\,\.\- ]+$/u'],
            'pa_post_office' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\,\.\- ]+$/'],
            'pa_division_bn' => ['required', 'string', 'max:255'],
            'pa_district_bn' => ['required', 'string', 'max:255'],
            'pa_upazilla_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF}\,\.\- ]+$/u'],
            'pa_upazilla' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\,\.\- ]+$/'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'documents' => ['required', 'array'],
            'documents.*' => ['required', 'mimes:jpeg,png,jpg,pdf', 'max:1024'],
        ];
    }

    public function attributes(): array {
        return [
            'name_bn' => 'মালিকের নাম (বাংলা)',
            'name' => 'মালিকের নাম (ইংরেজি)',
            'father_name_bn' => 'পিতার নাম (বাংলা)',
            'father_name' => 'পিতার নাম (ইংরেজি)',
            'mother_name_bn' => 'মাতার নাম (বাংলা)',
            'mother_name' => 'মাতার নাম (ইংরেজি)',
            'spouse_name_bn' => 'স্বামী/স্ত্রীর নাম (বাংলা)',
            'spouse_name' => 'স্বামী/স্ত্রীর নাম (ইংরেজি)',
            'national_id_no' => 'জাতীয় পরিচয়পত্র নং',
            'birth_registration_no' => 'জন্ম নিবন্ধন নং',
            'passport_no' => 'পাসপোর্ট নং',
            'business_organization_name_bn' => 'প্রতিষ্ঠানের নাম (বাংলা)',
            'business_organization_name' => 'প্রতিষ্ঠানের নাম (ইংরেজি)',
            'nature_of_business_bn' => 'ব্যবসার প্রকৃতি (বাংলা)',
            'business_category_id' => 'ব্যবসার ধরণ (বাংলা)',
            'address_of_business_organization_bn' => 'প্রতিষ্টানের ঠিকানা (বাংলা)',
            'address_of_business_organization' => 'প্রতিষ্টানের ঠিকানা (ইংরেজি)',
            'zone_bn' => 'জোন (বাংলা)',
            'ward_no' => 'ওয়ার্ড নং',
            'tin_no' => 'টিন নং',
            'bin_no' => 'বিআইএন নং',
            'phone_no' => 'ফোন নং',
            'email' => 'ইমেইল',
            'fiscal_year' => 'অর্থবছর',
            'business_starting_date' => 'ব্যবসা শুরুর তারিখ',
            'ca_holding_no' => 'স্থায়ী ঠিকানা হোল্ডিং নং',
            'ca_road_no' => 'স্থায়ী ঠিকানা রোড নং',
            'ca_post_code' => 'স্থায়ী ঠিকানা পোস্ট কোড',
            'ca_village_bn' => 'স্থায়ী ঠিকানা গ্রাম (বাংলা)',
            'ca_village' => 'স্থায়ী ঠিকানা গ্রাম (ইংরেজি)',
            'ca_post_office_bn' => 'স্থায়ী ঠিকানা পোস্ট অফিস (বাংলা)',
            'ca_post_office' => 'স্থায়ী ঠিকানা পোস্ট অফিস (ইংরেজি)',
            'ca_division_bn' => 'স্থায়ী ঠিকানা বিভাগ (বাংলা)',
            'ca_district_bn' => 'স্থায়ী ঠিকানা জেলা (বাংলা)',
            'ca_upazilla_bn' => 'স্থায়ী ঠিকানা উপজেলা (বাংলা)',
            'ca_upazilla' => 'স্থায়ী ঠিকানা উপজেলা (ইংরেজি)',
            'pa_holding_no' => 'বর্তমান ঠিকানা হোল্ডিং নং',
            'pa_road_no' => 'বর্তমান ঠিকানা রোড নং',
            'pa_post_code' => 'বর্তমান ঠিকানা পোস্ট কোড',
            'pa_village_bn' => 'বর্তমান ঠিকানা গ্রাম (বাংলা)',
            'pa_village' => 'বর্তমান ঠিকানা গ্রাম (ইংরেজি)',
            'pa_post_office_bn' => 'বর্তমান ঠিকানা পোস্ট অফিস (বাংলা)',
            'pa_post_office' => 'বর্তমান ঠিকানা পোস্ট অফিস (ইংরেজি)',
            'pa_division_bn' => 'বর্তমান ঠিকানা বিভাগ (বাংলা)',
            'pa_district_bn' => 'বর্তমান ঠিকানা জেলা (বাংলা)',
            'pa_upazilla_bn' => 'বর্তমান ঠিকানা উপজেলা (বাংলা)',
            'pa_upazilla' => 'বর্তমান ঠিকানা উপজেলা (ইংরেজি)',
        ];
    }

    public function messages(): array {
        return [
            'name_bn.required' => 'মালিকের নাম অবশ্যই পূরণ করতে হবে',
            'name_bn.string' => 'অক্ষর হতে হবে',
            'name_bn.max' => 'নাম অধিকতম ২৫৫ অক্ষর হতে পারে',
            'name_bn.regex' => 'বাংলা অক্ষর এবং স্পেস হতে পারে',
            'name.string' => 'অক্ষর হতে হবে',
            'name.max' => 'নাম অধিকতম ২৫৫ অক্ষর হতে পারে',
            'name.regex' => 'ইংরেজি অক্ষর এবং স্পেস হতে পারে',
            'father_name_bn.required' => 'পিতার নাম অবশ্যই পূরণ করতে হবে',
            'father_name_bn.string' => 'অক্ষর হতে হবে',
            'father_name_bn.max' => 'নাম অধিকতম ২৫৫ অক্ষর হতে পারে',
            'father_name_bn.regex' => 'বাংলা অক্ষর এবং স্পেস হতে পারে',
            'father_name.string' => 'অক্ষর হতে হবে',
            'father_name.max' => 'নাম অধিকতম ২৫৫ অক্ষর হতে পারে',
            'father_name.regex' => 'ইংরেজি অক্ষর এবং স্পেস হতে পারে',
            'mother_name_bn.required' => 'মাতার নাম অবশ্যই পূরণ করতে হবে',
            'mother_name_bn.string' => 'অক্ষর হতে হবে',
            'mother_name_bn.max' => 'নাম অধিকতম ২৫৫ অক্ষর হতে পারে',
            'mother_name_bn.regex' => 'বাংলা অক্ষর এবং স্পেস হতে পারে',
            'mother_name.string' => 'অক্ষর হতে হবে',
            'mother_name.max' => 'নাম অধিকতম ২৫৫ অক্ষর হতে পারে',
            'mother_name.regex' => 'ইংরেজি অক্ষর এবং স্পেস হতে পারে',
            'spouse_name_bn.string' => 'অক্ষর হতে হবে',
            'spouse_name_bn.max' => 'নাম অধিকতম ২৫৫ অক্ষর হতে পারে',
            'spouse_name_bn.regex' => 'বাংলা অক্ষর এবং স্পেস হতে পারে',
            'spouse_name.string' => 'অক্ষর হতে হবে',
            'spouse_name.max' => 'নাম অধিকতম ২৫৫ অক্ষর হতে পারে',
            'spouse_name.regex' => 'ইংরেজি অক্ষর এবং স্পেস হতে পারে',
            'national_id_no.required_without_all' => 'জাতীয় পরিচয়পত্র নং অবশ্যই পূরণ করতে হবে',
            'birth_registration_no.required_without_all' => 'জন্ম নিবন্ধন নং অবশ্যই পূরণ করতে হবে',
            'passport_no.required_without_all' => 'পাসপোর্ট নং অবশ্যই পূরণ করতে হবে',
            'business_organization_name_bn.required' => 'প্রতিষ্ঠানের নাম অবশ্যই পূরণ করতে হবে',
            'business_organization_name_bn.string' => 'অক্ষর হতে হবে',
            'business_organization_name_bn.max' => 'নাম অধিকতম ২৫৫ অক্ষর হতে পারে',
            'business_organization_name_bn.regex' => 'বাংলা অক্ষর এবং স্পেস হতে পারে',
            'business_organization_name.required' => 'প্রতিষ্ঠানের নাম অবশ্যই পূরণ করতে হবে',
            'business_organization_name.string' => 'অক্ষর হতে হবে',
            'business_organization_name.max' => 'নাম অধিকতম ২৫৫ অক্ষর হতে পারে',
            'nature_of_business_bn.string' => 'অক্ষর হতে হবে',
            'nature_of_business_bn.max' => 'প্রকৃতি অধিকতম ২৫৫ অক্ষর হতে পারে',
            'nature_of_business_bn.regex' => 'বাংলা অক্ষর এবং স্পেস হতে পারে',
            'business_category_id.required' => 'ব্যবসার ধরণ অবশ্যই পূরণ করতে হবে',
            'business_category_id.exists' => 'ব্যবসার ধরণ সঠিক নয়',
            'address_of_business_organization_bn.required' => 'প্রতিষ্টানের ঠিকানা অবশ্যই পূরণ করতে হবে',
            'address_of_business_organization_bn.string' => 'অক্ষর হতে হবে',
            'address_of_business_organization_bn.max' => 'ঠিকানা অধিকতম ২৫৫ অক্ষর হতে পারে',
            'address_of_business_organization_bn.regex' => 'বাংলা অক্ষর, স্পেস, কমা, ডট এবং ড্যাশ হতে পারে',
            'address_of_business_organization.required' => 'প্রতিষ্টানের ঠিকানা অবশ্যই পূরণ করতে হবে',
            'address_of_business_organization.string' => 'অক্ষর হতে হবে',
            'address_of_business_organization.max' => 'ঠিকানা অধিকতম ২৫৫ অক্ষর হতে পারে',
            'address_of_business_organization.regex' => 'ইংরেজি অক্ষর, স্পেস, কমা, ডট এবং ড্যাশ হতে পারে',
            'zone_bn.required' => 'জোন অবশ্যই পূরণ করতে হবে',
            'zone_bn.string' => 'অক্ষর হতে হবে',
            'zone_bn.max' => 'জোন অধিকতম ২৫৫ অক্ষর হতে পারে',
            'zone_bn.regex' => 'বাংলা অক্ষর এবং স্পেস হতে পারে',
            'ward_no.required' => 'ওয়ার্ড নং অবশ্যই পূরণ করতে হবে',
            'tin_no.required' => 'টিন নং অবশ্যই পূরণ করতে হবে',
            'bin_no.required' => 'বিআইএন নং অবশ্যই পূরণ করতে হবে',
            'phone_no.required' => 'ফোন নং অবশ্যই পূরণ করতে হবে',
            'phone_no.min' => 'ফোন নং অবশ্যই ১১ সংখ্যার হতে হবে',
            'phone_no.max' => 'ফোন নং অধিকতম ১১ সংখ্যার হতে পারে',
            'email.email' => 'ইমেইল সঠিক নয়',
            'fiscal_year.required' => 'অর্থবছর অবশ্যই পূরণ করতে হবে',
            'business_starting_date.required' => 'ব্যবসা শুরুর তারিখ অবশ্যই পূরণ করতে হবে',
            'ca_holding_no.required' => 'স্থায়ী ঠিকানা হোল্ডিং নং অবশ্যই পূরণ করতে হবে',
            'ca_village_bn.required' => 'স্থায়ী ঠিকানা গ্রাম (বাংলা) অবশ্যই পূরণ করতে হবে',
            'ca_village_bn.string' => 'অক্ষর হতে হবে',
            'ca_village_bn.max' => 'গ্রাম (বাংলা) অধিকতম ২৫৫ অক্ষর হতে পারে',
            'ca_village_bn.regex' => 'বাংলা অক্ষর, স্পেস, কমা, ডট এবং ড্যাশ হতে পারে',
            'ca_village.required' => 'স্থায়ী ঠিকানা গ্রাম (ইংরেজি) অবশ্যই পূরণ করতে হবে',
            'ca_village.string' => 'অক্ষর হতে হবে',
            'ca_village.max' => 'গ্রাম (ইংরেজি) অধিকতম ২৫৫ অক্ষর হতে পারে',
            'ca_village.regex' => 'ইংরেজি অক্ষর, স্পেস, কমা, ডট এবং ড্যাশ হতে পারে',
            'ca_post_office_bn.required' => 'স্থায়ী ঠিকানা পোস্ট অফিস (বাংলা) অবশ্যই পূরণ করতে হবে',
            'ca_post_office_bn.string' => 'অক্ষর হতে হবে',
            'ca_post_office_bn.max' => 'পোস্ট অফিস (বাংলা) অধিকতম ২৫৫ অক্ষর হতে পারে',
            'ca_post_office_bn.regex' => 'বাংলা অক্ষর, স্পেস, কমা, ডট এবং ড্যাশ হতে পারে',
            'ca_post_office.required' => 'স্থায়ী ঠিকানা পোস্ট অফিস (ইংরেজি) অবশ্যই পূরণ করতে হবে',
            'ca_post_office.string' => 'অক্ষর হতে হবে',
            'ca_post_office.max' => 'পোস্ট অফিস (ইংরেজি) অধিকতম ২৫৫ অক্ষর হতে পারে',
            'ca_post_office.regex' => 'ইংরেজি অক্ষর, স্পেস, কমা, ডট এবং ড্যাশ হতে পারে',
            'ca_division_bn.required' => 'স্থায়ী ঠিকানা বিভাগ (বাংলা) অবশ্যই পূরণ করতে হবে',
            'ca_division_bn.string' => 'অক্ষর হতে হবে',
            'ca_division_bn.max' => 'বিভাগ (বাংলা) অধিকতম ২৫৫ অক্ষর হতে পারে',
            'ca_district_bn.required' => 'স্থায়ী ঠিকানা জেলা (বাংলা) অবশ্যই পূরণ করতে হবে',
            'ca_district_bn.string' => 'অক্ষর হতে হবে',
            'ca_district_bn.max' => 'জেলা (বাংলা) অধিকতম ২৫৫ অক্ষর হতে পারে',
            'ca_upazilla_bn.required' => 'স্থায়ী ঠিকানা উপজেলা (বাংলা) অবশ্যই পূরণ করতে হবে',
            'ca_upazilla_bn.string' => 'অক্ষর হতে হবে',
            'ca_upazilla_bn.max' => 'উপজেলা (বাংলা) অধিকতম ২৫৫ অক্ষর হতে পারে',
            'ca_upazilla_bn.regex' => 'বাংলা অক্ষর, স্পেস, কমা, ডট এবং ড্যাশ হতে পারে',
            'ca_upazilla.required' => 'স্থায়ী ঠিকানা উপজেলা (ইংরেজি) অবশ্যই পূরণ করতে হবে',
            'ca_upazilla.string' => 'অক্ষর হতে হবে',
            'ca_upazilla.max' => 'উপজেলা (ইংরেজি) অধিকতম ২৫৫ অক্ষর হতে পারে',
            'ca_upazilla.regex' => 'ইংরেজি অক্ষর, স্পেস, কমা, ডট এবং ড্যাশ হতে পারে',
            'pa_holding_no.required' => 'বর্তমান ঠিকানা হোল্ডিং নং অবশ্যই পূরণ করতে হবে',
            'pa_village_bn.required' => 'বর্তমান ঠিকানা গ্রাম (বাংলা) অবশ্যই পূরণ করতে হবে',
            'pa_village_bn.string' => 'অক্ষর হতে হবে',
            'pa_village_bn.max' => 'গ্রাম (বাংলা) অধিকতম ২৫৫ অক্ষর হতে পারে',
            'pa_village_bn.regex' => 'বাংলা অক্ষর, স্পেস, কমা, ডট এবং ড্যাশ হতে পারে',
            'pa_village.required' => 'বর্তমান ঠিকানা গ্রাম (ইংরেজি) অবশ্যই পূরণ করতে হবে',
            'pa_village.string' => 'অক্ষর হতে হবে',
            'pa_village.max' => 'গ্রাম (ইংরেজি) অধিকতম ২৫৫ অক্ষর হতে পারে',
            'pa_village.regex' => 'ইংরেজি অক্ষর, স্পেস, কমা, ডট এবং ড্যাশ হতে পারে',
            'pa_post_office_bn.required' => 'বর্তমান ঠিকানা পোস্ট অফিস (বাংলা) অবশ্যই পূরণ করতে হবে',
            'pa_post_office_bn.string' => 'অক্ষর হতে হবে',
            'pa_post_office_bn.max' => 'পোস্ট অফিস (বাংলা) অধিকতম ২৫৫ অক্ষর হতে পারে',
            'pa_post_office_bn.regex' => 'বাংলা অক্ষর, স্পেস, কমা, ডট এবং ড্যাশ হতে পারে',
            'pa_post_office.required' => 'বর্তমান ঠিকানা পোস্ট অফিস (ইংরেজি) অবশ্যই পূরণ করতে হবে',
            'pa_post_office.string' => 'অক্ষর হতে হবে',
            'pa_post_office.max' => 'পোস্ট অফিস (ইংরেজি) অধিকতম ২৫৫ অক্ষর হতে পারে',
            'pa_post_office.regex' => 'ইংরেজি অক্ষর, স্পেস, কমা, ডট এবং ড্যাশ হতে পারে',
            'pa_division_bn.required' => 'বর্তমান ঠিকানা বিভাগ (বাংলা) অবশ্যই পূরণ করতে হবে',
            'pa_division_bn.string' => 'অক্ষর হতে হবে',
            'pa_division_bn.max' => 'বিভাগ (বাংলা) অধিকতম ২৫৫ অক্ষর হতে পারে',
            'pa_district_bn.required' => 'বর্তমান ঠিকানা জেলা (বাংলা) অবশ্যই পূরণ করতে হবে',
            'pa_district_bn.string' => 'অক্ষর হতে হবে',
            'pa_district_bn.max' => 'জেলা (বাংলা) অধিকতম ২৫৫ অক্ষর হতে পারে',
            'pa_upazilla_bn.required' => 'বর্তমান ঠিকানা উপজেলা (বাংলা) অবশ্যই পূরণ করতে হবে',
            'pa_upazilla_bn.string' => 'অক্ষর হতে হবে',
            'pa_upazilla_bn.max' => 'উপজেলা (বাংলা) অধিকতম ২৫৫ অক্ষর হতে পারে',
            'pa_upazilla_bn.regex' => 'বাংলা অক্ষর, স্পেস, কমা, ডট এবং ড্যাশ হতে পারে',
            'pa_upazilla.required' => 'বর্তমান ঠিকানা উপজেলা (ইংরেজি) অবশ্যই পূরণ করতে হবে',
            'pa_upazilla.string' => 'অক্ষর হতে হবে',
            'pa_upazilla.max' => 'উপজেলা (ইংরেজি) অধিকতম ২৫৫ অক্ষর হতে পারে',
            'pa_upazilla.regex' => 'ইংরেজি অক্ষর, স্পেস, কমা, ডট এবং ড্যাশ হতে পারে',
            'image.required' => 'ছবি অবশ্যই প্রদান করতে হবে',
            'image.image' => 'ছবি হতে হবে',
            'image.mimes' => 'ছবি অবশ্যই jpeg, jpg, png ফরম্যাটে হতে হবে',
            'image.max' => 'ছবি অধিকতম ২ মেগাবাইট হতে পারে',
            'document.required' => 'প্রয়োজনীয় ডকুমেন্ট সমূহ অবশ্যই দিতে হবে',
            'document.*.required' => 'ডকুমেন্টটি প্রদান করুন',
            'document.*.max' => 'ডকুমেন্টটি সর্বোচ্চ ১ মেগাবাইট হতে পারে'
        ];
    }

    public function failedValidation(Validator $validator){
        $response = redirect()->back()
            ->withInput($this->input())
            ->withErrors($validator->errors());
            
        throw new ValidationException($validator, $response);
    }
}
