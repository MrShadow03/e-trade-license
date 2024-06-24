<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Gate;
use App\Models\TradeLicenseApplication;
use App\Http\Requests\OwnershipTransferRequest;
use App\Http\Requests\OwnershipTransferUpdateRequest;

class TradeLicenseOwnershipController extends Controller{
    public function index(TradeLicenseApplication $trade_license_application) {
        Gate::authorize('requestUpdate', $trade_license_application);

        return view('user.pages.tl-application.change-ownership.index', [
            'application' => $trade_license_application,
            'districts' => Helpers::DISTRICTS,
        ]);
    }

    public function store(OwnershipTransferRequest $request, TradeLicenseApplication $trade_license_application) {
        Gate::authorize('requestUpdate', $trade_license_application);
        $userExists = User::where('national_id_no', $request->national_id_no)->first();

        $data = $request->validated();
        unset($data['image']);
        unset($data['owners-nid']);
        unset($data['ownership-transfer-deed']);

        $newAmendment = $trade_license_application->amendmentApplications()->create([
            'type' => Helpers::AMENDMENT_TYPE_TRANSFER_OWNERSHIP,
            'data' => $data,
            'status' => Helpers::PENDING_AMENDMENT_FEE_PAYMENT,
        ]);

        $newAmendment->addMedia(Helpers::resizeImage())->toMediaCollection('owner-image');
        $newAmendment->addMediaFromRequest('owners-nid')->toMediaCollection('owner-national-id');
        $newAmendment->addMediaFromRequest('ownership-transfer-deed')->toMediaCollection('ownership-transfer-deed');

        return redirect()->route('user.trade_license_applications', $trade_license_application)->with('success', 'আবেদনটি সফলভাবে জমা দেয়া হয়েছে');
    }

    public function edit(TradeLicenseApplication $trade_license_application) {
        Gate::authorize('editOwnershipTransferApplication', $trade_license_application);

        return view('user.pages.tl-application.change-ownership.edit', [
            'application' => $trade_license_application,
            'amendment' => $trade_license_application->getActiveAmendment(),
            'districts' => Helpers::DISTRICTS,
        ]);
    }

    public function update(OwnershipTransferUpdateRequest $request, TradeLicenseApplication $trade_license_application) {
        Gate::authorize('editOwnershipTransferApplication', $trade_license_application);

        $data = $request->validated();
        unset($data['image']);
        unset($data['owners-nid']);
        unset($data['ownership-transfer-deed']);

        $trade_license_application->getActiveAmendment()->update([
            'data' => $data,
        ]);

        if ($request->hasFile('image')) {
            $trade_license_application->getActiveAmendment()->addMedia(Helpers::resizeImage())->toMediaCollection('owner-image');
        }

        if ($request->hasFile('owners-nid')) {
            $trade_license_application->getActiveAmendment()->addMediaFromRequest('owners-nid')->toMediaCollection('owner-national-id');
        }

        if ($request->hasFile('ownership-transfer-deed')) {
            $trade_license_application->getActiveAmendment()->addMediaFromRequest('ownership-transfer-deed')->toMediaCollection('ownership-transfer-deed');
        }

        if($trade_license_application->getActiveAmendment()->status === Helpers::DENIED_AMENDMENT_APPROVAL) {
            $trade_license_application->getActiveAmendment()->update([
                'status' => Helpers::PENDING_AMENDMENT_APPROVAL
            ]);
        }

        return redirect()->route('user.trade_license_applications', $trade_license_application)->with('success', 'আবেদনটি সফলভাবে আপডেট হয়েছে');
    }
}
