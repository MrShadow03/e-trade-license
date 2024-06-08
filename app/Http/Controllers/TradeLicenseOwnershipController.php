<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\TradeLicenseApplication;
use App\Http\Requests\OwnershipTransferRequest;

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

        dd($request->validated());
        $data = [
            'address_of_business_organization_bn' => $request->address_of_business_organization_bn,
            'address_of_business_organization' => $request->address_of_business_organization,
            'zone_bn' => $request->zone_bn,
            'ward_no' => $request->ward_no,
        ];

        $trade_license_application->amendmentApplications()->create([
            'type' => 'relocation',
            'data' => $data,
            'status' => 'pending',
        ])->addMediaFromRequest('document')->toMediaCollection('house-ownership-document');

        return redirect()->route('user.trade_license_applications', $trade_license_application)->with('success', 'আবেদনটি সফলভাবে জমা দেয়া হয়েছে');
    }
}
