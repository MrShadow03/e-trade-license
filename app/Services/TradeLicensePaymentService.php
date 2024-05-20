<?php 
namespace App\Services;

use App\Helpers\Helpers;
use App\Models\TradeLicensePayment;
use App\Models\TradeLicenseApplication;

class TradeLicensePaymentService {
    public static function payWithBank($tradeLicenseApplication, $amount, $type = Helpers::FORM_FEE) {
        $payment = TradeLicensePayment::create([
            'trade_license_application_id' => $tradeLicenseApplication->id,
            'amount' => $amount,
            'method' => Helpers::BANK_PAYMENT,
            'type' => $type,
            'bank' => request()->bank ?? null,
            'bank_branch' => request()->bank_branch ?? null,
            'bank_invoice_no' => request()->bank_invoice_no ?? null,
            'status' => 'pending'
        ]);

        $image = Helpers::resizeImage('image', 1000, false, [
            'brightness' => 10,
            'contrast' => 10,
        ]);

        $mediaCollection = $type === Helpers::FORM_FEE ? 'form-fee-payment-slip' : 'license-fee-payment-slip';

        $payment->addMedia($image)->toMediaCollection($mediaCollection);

        return $payment;
    }

    public static function verifyPayment($request, $type = Helpers::FORM_FEE) {
        $tlApplication = TradeLicenseApplication::findOrFail($request['application_id']);
        $payment = $type === Helpers::FORM_FEE ? $tlApplication->getFormFeePayment() : $tlApplication->getLicenseFeePayment();

        if ($request['isVerified'] == '0') {
            self::denyPayment($tlApplication, $payment);
            return 'denied';
        }

        $paymentData = [];

        if ($type === Helpers::FORM_FEE) {
            $paymentData = [
                'form_fee' => $payment->amount,
            ];
        }else {
            $paymentData = [
                'new_application_fee' => $tlApplication->new_application_fee,
                'signboard_fee' => $tlApplication->signboard_fee,
                'income_tax' => $tlApplication->income_tax_amount,
                'vat' => $tlApplication->vat_amount,
                'surcharge' => Helpers::SURCHARGE,
            ];
        }

        $tlApplication->update([
            'status' => Helpers::APPROVED_STATES[$tlApplication->status] ?? $tlApplication->status,
            ...$paymentData
        ]);

        $payment->update([
            'status' => 'verified',
            'fields' => $paymentData,
        ]);

        return 'verified';
    }

    protected static function denyPayment($tlApplication, $payment) {
        $tlApplication->update([
            'status' => Helpers::DENIED_STATES[$tlApplication->status] ?? $tlApplication->status
        ]);

        $payment->delete();
    }
}






?>