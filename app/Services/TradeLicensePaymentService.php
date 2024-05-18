<?php 
namespace App\Services;

use App\Helpers\Helpers;
use App\Models\TradeLicensePayment;
use App\Models\TradeLicenseApplication;

class TradeLicensePaymentService {
    public static function payWithBank($tradeLicenseApplication, $amount) {
        $payment = TradeLicensePayment::create([
            'trade_license_application_id' => $tradeLicenseApplication->id,
            'amount' => $amount,
            'method' => Helpers::BANK_PAYMENT,
            'type' => Helpers::FORM_FEE,
            'bank' => request()->bank ?? null,
            'bank_branch' => request()->bank_branch ?? null,
            'bank_invoice_no' => request()->bank_invoice_no ?? null,
            'status' => 'pending'
        ]);

        $image = Helpers::resizeImage('image', 1000, false, [
            'brightness' => 10,
            'contrast' => 10,
        ]);

        $payment->addMedia($image)->toMediaCollection('payment-slip');

        $tradeLicenseApplication->update([
            'status' => Helpers::PENDING_FORM_FEE_VERIFICATION
        ]);

        return $payment;
    }

    public static function verifyFormFeePayment($request) {
        $tlApplication = TradeLicenseApplication::findOrFail($request['application_id']);
        $payment = $tlApplication->getFormFeePayment();

        if ($request['isVerified'] == '0') {
            self::denyFormFeePayment($tlApplication, $payment);
            return 'denied';
        }

        $tlApplication->update([
            'status' => Helpers::PENDING_ASSISTANT_APPROVAL,
            'form_fee' => $payment->amount
        ]);

        $payment->update([
            'status' => 'verified'
        ]);

        return 'verified';
    }

    protected static function denyFormFeePayment($tlApplication, $payment) {
        $tlApplication->update([
            'status' => Helpers::DENIED_FORM_FEE_VERIFICATION
        ]);

        $payment->delete();
    }
}






?>