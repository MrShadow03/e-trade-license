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

        $payment = TradeLicensePaymentService::payWithBank($tradeLicenseApplication, $formFee);

        return redirect()->route('user.trade_license_applications')->with('success', 'ফর্ম ফি যাচাই করার জন্য অপেক্ষা করুন।');
    }
}
