<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\TradeLicenseApplication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class OwnershipTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rule = User::where('national_id_no', $this->national_id_no)->exists() ? 'nullable' : 'required';
            
        return [
            'owner_name_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF} ]+$/u'],
            'owner_name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z ]+$/'],
            'father_name_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF} ]+$/u'],
            'father_name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z ]+$/'],
            'mother_name_bn' => ['required', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF} ]+$/u'],
            'mother_name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z ]+$/'],
            'spouse_name_bn' => ['nullable', 'string', 'max:255', 'regex:/^[\x{0980}-\x{09FF} ]+$/u'],
            'spouse_name' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z ]+$/'],
            'national_id_no' => ['required_without_all:birth_registration_no,passport_no', 'not_in:' . $this->user()->national_id_no],
            'birth_registration_no' => ['required_without_all:national_id_no,passport_no'],
            'passport_no' => ['required_without_all:national_id_no,birth_registration_no'],
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
            'image' => [$rule, 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'owners-nid' => ['required', 'mimes:jpeg,png,jpg,pdf', 'max:1024'],
            'ownership-transfer-deed' => ['required', 'mimes:jpeg,png,jpg,pdf', 'max:1024'],
        ];
    }

    public function messages()
    {
        return [
            'owner_name_bn.required' => 'মালিকের নাম অবশ্যই পূরণ করতে হবে',
            'owner_name_bn.string' => 'অক্ষর হতে হবে',
            'owner_name_bn.max' => 'নাম অধিকতম ২৫৫ অক্ষর হতে পারে',
            'owner_name_bn.regex' => 'বাংলা অক্ষর এবং স্পেস হতে পারে',
            'owner_name.string' => 'অক্ষর হতে হবে',
            'owner_name.max' => 'নাম অধিকতম ২৫৫ অক্ষর হতে পারে',
            'owner_name.regex' => 'ইংরেজি অক্ষর এবং স্পেস হতে পারে',
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
            'national_id_no.not_in' => 'আপনি নিজের জাতীয় পরিচয়পত্র নং ব্যবহার করতে পারবেন না',
            'birth_registration_no.required_without_all' => 'জন্ম নিবন্ধন নং অবশ্যই পূরণ করতে হবে',
            'passport_no.required_without_all' => 'পাসপোর্ট নং অবশ্যই পূরণ করতে হবে',
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
            'owners-nid.required' => 'মালিকের জাতীয় পরিচয়পত্র অবশ্যই প্রদান করতে হবে',
            'owners-nid.mimes' => 'মালিকের জাতীয় পরিচয়পত্র অবশ্যই jpeg, jpg, png, pdf ফরম্যাটে হতে হবে',
            'owners-nid.max' => 'মালিকের জাতীয় পরিচয়পত্র অধিকতম ১ মেগাবাইট হতে পারে',
            'ownership-transfer-deed.required' => 'মালিকানা স্থানান্তর দলিল অবশ্যই প্রদান করতে হবে',
            'ownership-transfer-deed.mimes' => 'মালিকানা স্থানান্তর দলিল অবশ্যই jpeg, jpg, png, pdf ফরম্যাটে হতে হবে',
            'ownership-transfer-deed.max' => 'মালিকানা স্থানান্তর দলিল অধিকতম ১ মেগাবাইট হতে পারে',
        ];
    }

    public function failedValidation(Validator $validator){
        $response = redirect()->back()
            ->withInput($this->input())
            ->withErrors($validator->errors());
            
        throw new ValidationException($validator, $response);
    }
}
