<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UserRegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:11', 'min:11', 'unique:'.User::class],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'নাম অবশ্যই প্রয়োজন',
            'phone.required' => 'ফোন নম্বর অবশ্যই প্রয়োজন',
            'phone.min' => 'ফোন নম্বর অবশ্যই ১১ সংখ্যার হতে হবে',
            'phone.max' => 'ফোন নম্বর অবশ্যই ১১ সংখ্যার হতে হবে',
            'phone.unique' => 'এই ফোন নম্বর দিয়ে ইতিমধ্যে একটি অ্যাকাউন্ট খোলা আছে',
            'email.email' => 'ই-মেইল ঠিক নয়',
            'email.unique' => 'এই ই-মেইল দিয়ে ইতিমধ্যে একটি অ্যাকাউন্ট খোলা আছে',
            'password.required' => 'পাসওয়ার্ড অবশ্যই প্রয়োজন',
            'password.min' => 'পাসওয়ার্ড অবশ্যই ৮ অক্ষরের হতে হবে',
            'password.confirmed' => 'নিশ্চিত পাসওয়ার্ড মেলে নি',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'নাম',
            'phone' => 'ফোন নম্বর',
            'email' => 'ই-মেইল',
            'address' => 'ঠিকানা',
            'password' => 'পাসওয়ার্ড',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = redirect()->back()
            ->withInput()
            ->withErrors($validator->errors()->all(), 'register');

        throw new ValidationException($validator, $response);
    }
}
