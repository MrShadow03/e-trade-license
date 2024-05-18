<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Models\Signboard;
use Illuminate\Http\Request;
use App\Models\BusinessCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Models\TradeLicenseApplication;
use App\Services\TradeLicensePaymentService;
use App\Services\TradeLicenseApplicationService;
use App\Http\Requests\TradeLicenseApprovalRequest;
use App\Http\Requests\TradeLicensePaymentVerificationRequest;

class TradeLicenseApplicationController extends Controller {
    public function index() {
        $tradeLicenseApplications = TradeLicenseApplication::query()->with('payments')->where('status', '!=', Helpers::PENDING_FORM_FEE_PAYMENT);

        if (request()->user()->can('approve-pending-trade-license-assistant-approval-applications')) {
            $tradeLicenseApplications->whereIn('status', [
                Helpers::PENDING_FORM_FEE_VERIFICATION,
                Helpers::PENDING_ASSISTANT_APPROVAL
            ]);
        } elseif (request()->user()->can('approve-pending-trade-license-inspector-approval-applications')) {
            $tradeLicenseApplications->whereIn('status', [
                Helpers::PENDING_INSPECTOR_APPROVAL
            ]);
        } elseif (request()->user()->can('approve-pending-trade-license-superintendent-approval-applications')) {
            $tradeLicenseApplications->whereIn('status', [
                Helpers::PENDING_LICENSE_FEE_VERIFICATION,
                Helpers::PENDING_SUPT_APPROVAL
            ]);
        } elseif (request()->user()->can('approve-pending-revenue-officer-approval-applications')) {
            $tradeLicenseApplications->whereIn('status', [
                Helpers::PENDING_RO_APPROVAL
            ]);
        } elseif (request()->user()->can('approve-pending-chief-revenue-officer-approval-applications')) {
            $tradeLicenseApplications->whereIn('status', [
                Helpers::PENDING_CRO_APPROVAL
            ]);
        } elseif (request()->user()->can('approve-pending-chief-executive-officer-approval-applications')) {
            $tradeLicenseApplications->whereIn('status', [
                Helpers::PENDING_CEO_APPROVAL
            ]);
        }

        return view('admin.pages.tl-application.index', [
            'applications' => $tradeLicenseApplications->get()
        ]);
    }

    public function show(TradeLicenseApplication $trade_license_application) {
        return view('admin.pages.tl-application.show', [
            'application' => $trade_license_application
        ]);
    }
    
    public function inspect(TradeLicenseApplication $trade_license_application) {
        Gate::authorize('hasApprovalPermission', $trade_license_application);

        return view('admin.pages.tl-application.inspect', [
            'application' => $trade_license_application,
            'businessCategories' => BusinessCategory::all(),
            'signboards' => Signboard::all()
        ]);
    }

    public function approveAssistant(TradeLicenseApplication $trade_license_application, TradeLicenseApprovalRequest $request) {
        // Determine if the user has the appropriate role/permission to approve the application
        Gate::authorize('hasApprovalPermission', $trade_license_application);

        $tlService = new TradeLicenseApplicationService($trade_license_application);

        try {
            $isApproved = $request->validated()['isApproved'];
    
            $commonData = [];
            if(auth()->user()->can('update-business-category') || auth()->user()->can('update-sign-board-fee')){
                $commonData = [
                    'business_category_id' => $request->validated()['business_category_id'] ?? $trade_license_application->business_category,
                    'signboard_id' => $request->validated()['signboard_id'] ?? $trade_license_application->signboard,
                ];
            }
    
            if(!$isApproved){
                $corrections = $request->validated()['corrections'] ?? [];
    
                $trade_license_application->update([
                    'status' => Helpers::DENIED_STATES[$trade_license_application->status],
                    'corrections' => $corrections,
                    ...$commonData
                ]);
    
                return redirect()->route('admin.trade_license_applications')->with('warning', 'সহকারী অনুমোদন প্রত্যাখ্যাত করা হয়েছে।');
            }
    
            $trade_license_application->update([
                'status' => Helpers::APPROVED_STATES[$trade_license_application->status],
                ...$commonData
            ]);
    
            return redirect()->route('admin.trade_license_applications')->with('success', 'সহকারী অনুমোদন সফল হয়েছে।');
        }catch (\Exception $e){
            return redirect()->route('admin.trade_license_applications')->with('warning', 'সহকারী অনুমোদন সম্ভব নয়।');
        }
    }

    public function verifyFormFeePayment(TradeLicensePaymentVerificationRequest $request){
        $paymentStatus = TradeLicensePaymentService::verifyFormFeePayment($request->validated());

        return $paymentStatus === 'verified' ? redirect()->route('admin.trade_license_applications')->with('success', 'ফর্ম ফি পেমেন্ট নিশ্চিত করা হয়েছে।') : redirect()->route('admin.trade_license_applications')->with('warning', 'ফর্ম ফি পেমেন্ট প্রত্যাখ্যাত করা হয়েছে।');
    }

}
