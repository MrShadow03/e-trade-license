<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TradeLicenseApplication;
use App\Services\TradeLicenseApplicationService;
use App\Http\Requests\TradeLicenseApprovalRequest;
use App\Services\UserService;

class TradeLicenseAmendmentApplicationController extends Controller {
    public function index() {

        $tradeLicenseApplications = TradeLicenseApplication::whereHas('amendmentApplications', function($query) {
            $query->whereIn('status', [
                Helpers::PENDING_AMENDMENT_FEE_VERIFICATION,
                Helpers::PENDING_AMENDMENT_APPROVAL,
            ]);
        })->get();
        
        return view('admin.pages.tl-application.amendment.index', [
            'applications' => $tradeLicenseApplications
        ]);
    }

    public function approveRelocation(TradeLicenseApplication $trade_license_application, TradeLicenseApprovalRequest $request) {
        $isApproved = $request->validated()['isApproved'];

        // if denied
        if(!$isApproved){
            $trade_license_application->getActiveAmendment()->update([
                'status' => Helpers::DENIED_AMENDMENT_APPROVAL,
            ]);
            return redirect()->route('admin.trade_license_applications.amendments')->with('warning', 'অনুমোদন প্রত্যাখ্যান করা হয়েছে।');
        }
        // Make an array of old data
        $oldData = [];

        foreach ($trade_license_application->getActiveAmendment()->data as $key => $value) {
            $oldData[$key]['old'] = $trade_license_application->{$key};
            $oldData[$key]['new'] = $value;
        }

        // update the application
        $trade_license_application->update($trade_license_application->getActiveAmendment()->data);

        $tlService = new TradeLicenseApplicationService($trade_license_application);
        $tlService->replaceWithAmendmentDocument(1);

        $trade_license_application->getActiveAmendment()->update([
            'status' => Helpers::AMENDMENT_APPROVED,
            'data' => $oldData,
        ]);

        return redirect()->route('admin.trade_license_applications.amendments')->with('info', 'অনুমোদন সফল হয়েছে।');
    }

    public function approveOwnershipTransfer(TradeLicenseApplication $trade_license_application, TradeLicenseApprovalRequest $request) {
        $isApproved = $request->validated()['isApproved'];
        $amendment = $trade_license_application->getActiveAmendment();
        $originalUser = $trade_license_application->user;

        // if denied
        if(!$isApproved){
            $amendment->update([
                'status' => Helpers::DENIED_AMENDMENT_APPROVAL,
            ]);
            return redirect()->route('admin.trade_license_applications.amendments')->with('warning', 'অনুমোদন প্রত্যাখ্যান করা হয়েছে।');
        }
        
        // check if the user exists
        $user = User::where('national_id_no', $amendment->data['national_id_no'])->first();
        
        if(!$user){
            $user = UserService::createUser($amendment->data);
        }

        if(!$user->father_name){
            $userService = new UserService();
            $userService->updateMissingInfoFromArray($user, $amendment->data);
        }

        // update image
        $imagePath = $amendment->getMedia('owner-image')->first()->getPath();

        //store old owner image to the amendment
        $amendment->addMedia($trade_license_application->getMedia('owner_image')->first()->getPath())->toMediaCollection('old-owner-image');
        $trade_license_application->addMedia($imagePath)->toMediaCollection('owner_image');

        // Make an array of old data
        $oldData = [];
        foreach ($amendment->data as $key => $value) {
            $oldData[$key]['old'] = $originalUser->{$key};
            $oldData[$key]['new'] = $value;
        }

        // update the application
        $trade_license_application->update([
            'user_id' => $user->id,
        ]);

        $tlService = new TradeLicenseApplicationService($trade_license_application);
        $tlService->replaceWithAmendmentDocument(2);
        $tlService->replaceWithAmendmentDocument(3);

        $amendment->update([
            'status' => Helpers::AMENDMENT_APPROVED,
            'data' => $oldData,
        ]);

        return redirect()->route('admin.trade_license_applications.amendments')->with('info', 'অনুমোদন সফল হয়েছে।');
    }
}
