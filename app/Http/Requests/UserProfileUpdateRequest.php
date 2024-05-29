<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UserProfileUpdateRequest extends FormRequest
{
    public function rules(): array {
        return [
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'address' => ['nullable', 'string', 'max:255'],
            'current_password' => ['required', 'current_password'],
            'image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function authorize(): bool {
        return true;
    }

    public function messages(): array {
        return [
            'current_password.current_password' => 'বর্তমান পাসওয়ার্ড সঠিক নয়।',
            'email.unique' => 'এই ইমেইল পূর্বে নিবন্ধিত হয়েছে।',
            'image.image' => 'ছবি হতে হবে।',
            'image.max' => 'ছবির আকার ২ মেগাবাইটের বড় হতে পারবে না।',
        ];
    }

    public function failedValidation(Validator $validator) {
        $response = redirect()->route('user.profile.edit')->with('error', $validator->errors()->first());
        throw new ValidationException($validator, $response);
    }
}
