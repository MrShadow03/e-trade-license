<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class AdminUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update-admins');
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:admins,phone,' . $this->admin->id],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:admins,email,' . $this->admin->id],
            'role' => ['required', 'string', 'exists:roles,name'],
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
            'email.unique' => 'এই ইমেইল ঠিকানা ইতিমধ্যে নিবন্ধিত',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = redirect()->back()
            ->with('errors', $validator->errors()->first());

        throw new ValidationException($validator, $response);
    }
}
