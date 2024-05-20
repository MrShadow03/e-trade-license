<?php

namespace App\Http\Requests;

use App\Models\TradeLicenseApplication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class TradeLicenseCorrectionRequest extends FormRequest
{
    protected $changeableFields = [];
    protected $documents = [];
    protected $customRules = [];
    
    public function __construct()
    {
        $application = request()->route('trade_license_application');
        $this->changeableFields = array_keys($application->corrections);

        // separate fields that prefixed with 'document-'
        $this->documents = [];
        foreach ($this->changeableFields as $field) {
            if (str_starts_with($field, 'document-')) {
                $this->documents[] = $field;
            }
        }
        // add 'validation rules' for each document field
        if($this->documents !== []) {
            $this->customRules['documents'] = 'required|array';
            $this->customRules['documents.*'] = 'required|file|mimes:png,jpg,jpeg,pdf|max:2048';
        }

        $this->changeableFields = array_diff($this->changeableFields, $this->documents);

        // if there is image field separate it from changeable fields
        if (in_array('image', $this->changeableFields)) {
            $this->customRules['image'] = 'required|file|mimes:jpeg,png,jpg|max:2048';
            // remove image field from changeable fields
            $this->changeableFields = array_diff($this->changeableFields, ['image']);
        }

        // add 'validation rules' for each changeable field
        foreach ($this->changeableFields as $field) {
            $this->customRules[$field] = 'nullable';
        }

    }
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            ...$this->customRules,
        ];
    }

    public function messages(): array
    {
        $messages = [];

        foreach($this->documents as $field) {
            $field = str_replace('document-', '', $field);
            $messages[$field.'.required'] = 'ডকুমেন্ট আপলোড করুন';
            $messages[$field.'.file'] = 'ডকুমেন্ট ফাইল হতে হবে';
            $messages[$field.'.mimes'] = 'ডকুমেন্ট ফরমেট pdf হতে হবে';
            $messages[$field.'.max'] = 'ডকুমেন্ট আকার ২ মেগাবাইট এর মধ্যে হতে হবে';
        }

        return [
            'image.required' => 'ছবি আপলোড করুন',
            'image.file' => 'ছবি ফাইল হতে হবে',
            'image.mimes' => 'ছবির ফরমেট jpeg, png, jpg হতে হবে',
            'image.max' => 'ছবির আকার ২ মেগাবাইট এর মধ্যে হতে হবে',
            ...$messages,
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = redirect()->back()
            ->withInput()
            ->withErrors($validator->errors()->all());

            dd($response);
        throw new ValidationException($validator, $response);
    }
}
