<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class AdminStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create-admins');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:admins'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:admins'],
            'role' => ['required', 'string', 'exists:roles,name'],
            'address' => ['nullable', 'string', 'max:255'],
            'wards' => ['required', 'array'],
            'wards.*' => ['required', 'integer', 'exists:wards,ward_no'],
            'image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'নাম অবশ্যই প্রয়োজন',
            'phone.required' => 'ফোন নম্বর অবশ্যই প্রয়োজন',
            'phone.unique' => 'এই ফোন নম্বরটি ইতিমধ্যে নিবন্ধিত',
            'email.email' => 'ইমেইল ঠিকানা সঠিক নয়',
            'role.required' => 'ভূমিকা অবশ্যই প্রয়োজন',
            'role.exists' => 'ভূমিকা সঠিক নয়',
            'wards.required' => 'ওয়ার্ড অবশ্যই প্রয়োজন',
            'wards.*.exists' => 'ওয়ার্ড সঠিক নয়',
            'email.unique' => 'এই ইমেইল ঠিকানা ইতিমধ্যে নিবন্ধিত',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = redirect()->back()->withInput()->withErrors($validator->errors());
        dd($response);
        throw new ValidationException($validator, $response);
    }
}
