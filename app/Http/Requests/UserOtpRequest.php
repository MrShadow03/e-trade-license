<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UserOtpRequest extends FormRequest
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
        return [
            'otp' => 'required|string|max:6',
            'send_to' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'otp.required' => 'অনুগ্রহ করে আপনার প্রাপ্ত ওটিপি নম্বরটি প্রদান করুন।',
            'otp.max' => 'ওটিপি নম্বরটি ৬ সংখ্যার হতে হবে।',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = redirect()->back()
            ->withInput($this->input())
            ->withErrors($validator->errors()->getMessages());

        throw new ValidationException($validator, $response);
    }
}
