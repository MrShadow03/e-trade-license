<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\TradeLicenseApplication;
use App\Http\Requests\LocationChangeRequest;

class TradeLicenseLocationController extends Controller {
    
    public function index(TradeLicenseApplication $trade_license_application) {
        Gate::authorize('requestUpdate', $trade_license_application);

        return view('user.pages.tl-application.change-location.index', [
            'application' => $trade_license_application
        ]);
    }

    public function store(LocationChangeRequest $request, TradeLicenseApplication $trade_license_application) {
        Gate::authorize('requestUpdate', $trade_license_application);

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
