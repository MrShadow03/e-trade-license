<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class LocationChangeRequest extends FormRequest{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'address_of_business_organization_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF}\,\.\- ]+$/u'],
            'address_of_business_organization' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\,\.\- ]+$/'],
            'zone_bn' => ['nullable', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF} ]+$/u'],
            'ward_no' => ['required'], 
        ];
    }

    public function messages(): array {
        return [
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
            'document.required' => 'দলিল অবশ্যই আপলোড করতে হবে',
        ];
    }

    public function failedValidation(Validator $validator){
        $response = redirect()->back()
            ->withInput($this->input())
            ->withErrors($validator->errors());
            
        throw new ValidationException($validator, $response);
    }
}
