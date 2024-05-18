<?php

namespace App\Http\Requests;

use App\Models\TradeLicenseApplication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class TradeLicensePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:trade_license_applications,id', ],
            'bank' => ['nullable', 'string'],
            'bank_branch' => ['nullable', 'string'],
            'bank_invoice_no' => ['nullable', 'string'],
            'image' => ['required', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'আবেদন নম্বর অবশ্যই প্রয়োজন।',
            'id.integer' => 'আবেদন নম্বর সঠিক নয়।',
            'id.exists' => 'আবেদন নম্বর সঠিক নয়।',
            'image.required' => 'পেমেন্ট স্লিপ অবশ্যই প্রয়োজন।',
            'image.image' => 'পেমেন্ট স্লিপ সঠিক নয়।',
            'image.max' => 'পেমেন্ট স্লিপ অতিরিক্ত বড়।',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = redirect()->back()->withInput()->withErrors($validator->errors());

        throw new ValidationException($validator, $response);
    }
}
