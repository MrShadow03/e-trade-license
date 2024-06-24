<?php

namespace App\Http\Requests;

use App\Helpers\Helpers;
use App\Models\TradeLicenseApplication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class TradeLicensePaymentVerificationRequest extends FormRequest
{
    public function authorize(): bool {
        $application = TradeLicenseApplication::findOrFail($this->application_id);

        return auth()->user()->can('verify-form-fee-payment') && $application->status === Helpers::PENDING_FORM_FEE_VERIFICATION ||
        auth()->user()->can('verify-amendment-fee-payment') && $application->getActiveAmendment()?->status === Helpers::PENDING_AMENDMENT_FEE_VERIFICATION ||
        auth()->user()->can('verify-license-fee-payment') && $application->status === Helpers::PENDING_LICENSE_FEE_VERIFICATION ||
        auth()->user()->can('verify-license-renewal-fee-payment') && $application->status === Helpers::PENDING_LICENSE_RENEWAL_FEE_VERIFICATION;
    }

    public function rules(): array {
        return [
            'application_id' => 'required|exists:trade_license_applications,id',
            'isVerified' => 'required|boolean',
        ];
    }

    public function failedValidation(Validator $validator) {
        $response = redirect()->back()->withInput()->withErrors($validator->errors());

        throw new ValidationException($validator, $response);
    }
}
