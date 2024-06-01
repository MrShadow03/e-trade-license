<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\TradeLicenseApplication;
use App\Services\TradeLicenseApplicationService;
use App\Http\Requests\TradeLicensePaymentRequest;
use App\Http\Requests\TradeLicensePaymentVerificationRequest;
use App\Services\TradeLicensePaymentService;

class TradeLicensePaymentController extends Controller{
    public function storeFromFee(TradeLicensePaymentRequest $request){
        $tradeLicenseApplication = TradeLicenseApplication::findOrFail($request->id);

        Gate::authorize('payFormFee', $tradeLicenseApplication);

        $formFee = Helpers::TRADE_LICENSE_FORM_FEE;

        TradeLicensePaymentService::payWithBank($tradeLicenseApplication, $formFee);

        $tradeLicenseApplication->update([
            'status' => Helpers::PENDING_FORM_FEE_VERIFICATION
        ]);

        return redirect()->route('user.trade_license_applications')->with('success', 'ফর্ম ফি যাচাই করার জন্য অপেক্ষা করুন।');
    }

    public function storeLicenseFee(TradeLicensePaymentRequest $request){
        $tradeLicenseApplication = TradeLicenseApplication::findOrFail($request->id);

        Gate::authorize('payLicenseFee', $tradeLicenseApplication);

        TradeLicensePaymentService::payWithBank($tradeLicenseApplication, $tradeLicenseApplication->total_new_license_fee, Helpers::LICENSE_FEE);

        $tradeLicenseApplication->update([
            'status' => Helpers::PENDING_LICENSE_FEE_VERIFICATION
        ]);

        return redirect()->route('user.trade_license_applications')->with('success', 'লাইসেন্স ফি যাচাই করার জন্য অপেক্ষা করুন।');
    }

    public function storeLicenseRenewalFee(TradeLicensePaymentRequest $request){
        $tradeLicenseApplication = TradeLicenseApplication::findOrFail($request->id);

        Gate::authorize('payLicenseRenewalFee', $tradeLicenseApplication);

        TradeLicensePaymentService::payWithBank($tradeLicenseApplication, $tradeLicenseApplication->total_license_renewal_fee, Helpers::LICENSE_RENEWAL_FEE);

        $tradeLicenseApplication->update([
            'status' => Helpers::PENDING_LICENSE_RENEWAL_FEE_VERIFICATION
        ]);

        return redirect()->route('user.trade_license_applications')->with('success', 'লাইসেন্স নবায়ন ফি যাচাই করার জন্য অপেক্ষা করুন।');
    }
}
