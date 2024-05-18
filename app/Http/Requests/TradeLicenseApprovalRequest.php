<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class TradeLicenseApprovalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'isApproved' => 'required|boolean',
            'message' => 'required_if:isApproved,false',
            'corrections' => 'nullable|array',
            'corrections.*' => 'array',
            'corrections.*.*' => 'nullable|string',
        ];
    }

    public function messages(): array {
        return [
            'message.required_if' => 'মন্তব্য অবশ্যই প্রদান করতে হবে যদি আবেদনটি অনুমোদিত না হয়।',
        ];
    }

    public function failedValidation(Validator $validator) {
        $response = redirect()->back()
        ->withInput($this->input())
        ->withErrors($validator->errors());
        dd($response);

        throw new ValidationException($validator, $response);
    }
}
