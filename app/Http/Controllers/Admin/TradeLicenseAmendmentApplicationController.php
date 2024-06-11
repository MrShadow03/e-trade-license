<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TradeLicenseApplication;
use App\Services\TradeLicenseApplicationService;

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
}
