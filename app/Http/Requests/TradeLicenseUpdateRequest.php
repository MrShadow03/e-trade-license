<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class TradeLicenseUpdateRequest extends FormRequest {
    public function authorize(): bool{
        return true;
    }

    public function rules(): array {
        return [
            'application_id' => ['required', 'exists:trade_license_applications,id'],
            'business_category_id' => ['required', 'exists:business_categories,id'],
            'signboard_id' => ['required', 'exists:signboards,id'],
            'business_organization_name_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF}\" ]+$/u'],
            'business_organization_name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\.\- ]+$/'],
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
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'documents' => ['nullable', 'array'],
            'documents.*' => ['nullable', 'mimes:jpeg,png,jpg,pdf', 'max:1024'],
        ];
    }

    public function attributes(): array {
        return [
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
        ];
    }

    public function messages(): array {
        return [
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
        dd($response);
        throw new ValidationException($validator, $response);
    }
}
