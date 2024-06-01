<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Models\Signboard;
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
        $accessibleApplicationStatuses = TradeLicenseApplicationService::getAccessibleApplicationStatuses();
        $tradeLicenseApplications = TradeLicenseApplication::query()->with('payments')->whereIn('status', $accessibleApplicationStatuses);
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

    public function approve(TradeLicenseApplication $trade_license_application, TradeLicenseApprovalRequest $request) {
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
                return redirect()->route('admin.trade_license_applications')->with('warning', 'অনুমোদন প্রত্যাখ্যান করা হয়েছে।');
            }

            if(auth()->user()->can('issue-trade-license')){
                $this->issueTradeLicense($trade_license_application, $request);
                return redirect()->route('admin.trade_license_applications')->with('info', 'ট্রেড লাইসেন্স ইস্যু সফল হয়েছে।');
            }
            
            $trade_license_application->update([
                'status' => Helpers::APPROVED_STATES[$trade_license_application->status],
                ...$commonData
            ]);
    
            return redirect()->route('admin.trade_license_applications')->with('info', 'অনুমোদন সফল হয়েছে।');
        }catch (\Exception $e){
            return redirect()->route('admin.trade_license_applications')->with('warning', 'অনুমোদন সম্ভব নয়।');
        }
    }

    public function issueTradeLicense(TradeLicenseApplication $trade_license_application){
        // Generate 32 character long url-safe random string
        do {
            $uuid = Helpers::generateUuid('tl');
            $uuidExists = TradeLicenseApplication::where('uuid', $uuid)->exists();
        } while ($uuidExists);
        
        // Generate Trade License Number
        $tradeLicenseNo = TradeLicenseApplication::max('trade_license_no') ? TradeLicenseApplication::max('trade_license_no') + 1 : 20500;

        // Determine Expiry Date - 30th June of the next year
        $expiryDate = now()->month >= 7 ? date('Y-m-d', strtotime('30th June next year')) : date('Y-m-d', strtotime('30th June'));

        // Determine the status of the application - issued
        $trade_license_application->update([
            'status' => Helpers::ISSUED,
            'trade_license_no' => $tradeLicenseNo,
            'uuid' => $uuid,
            'expiry_date' => $expiryDate,
            'issued_at' => now(),
        ]);
    }

    public function verifyFormFeePayment(TradeLicensePaymentVerificationRequest $request){
        $paymentStatus = TradeLicensePaymentService::verifyPayment($request->validated());
        return $paymentStatus === 'verified' ? redirect()->route('admin.trade_license_applications')->with('info', 'ফর্ম ফি পেমেন্ট নিশ্চিত করা হয়েছে।') : redirect()->route('admin.trade_license_applications')->with('warning', 'ফর্ম ফি পেমেন্ট প্রত্যাখ্যাত করা হয়েছে।');
    }
    
    public function verifyLicenseFeePayment(TradeLicensePaymentVerificationRequest $request){
        $paymentStatus = TradeLicensePaymentService::verifyPayment($request->validated(), Helpers::LICENSE_FEE);
        return $paymentStatus === 'verified' ? redirect()->route('admin.trade_license_applications')->with('info', 'লাইসেন্স ফি পেমেন্ট নিশ্চিত করা হয়েছে।') : redirect()->route('admin.trade_license_applications')->with('warning', 'লাইসেন্স ফি পেমেন্ট প্রত্যাখ্যাত করা হয়েছে।');
    }

    public function verifyLicenseRenewalFeePayment(TradeLicensePaymentVerificationRequest $request){
        $paymentStatus = TradeLicensePaymentService::verifyPayment($request->validated(), Helpers::LICENSE_RENEWAL_FEE);
        return $paymentStatus === 'verified' ? redirect()->route('admin.trade_license_applications')->with('info', 'লাইসেন্স নবায়ন ফি নিশ্চিত করা হয়েছে।') : redirect()->route('admin.trade_license_applications')->with('warning', 'লাইসেন্স নবায়ন ফি পেমেন্ট প্রত্যাখ্যাত করা হয়েছে।');
    }

}
