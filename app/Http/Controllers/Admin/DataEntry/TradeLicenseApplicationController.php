<?php

namespace App\Http\Controllers\Admin\DataEntry;

use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TradeLicenseApplication;
use App\Models\BusinessCategory;
use App\Models\Signboard;

class TradeLicenseApplicationController extends Controller {
    public function create() {
        $trade_license_application = TradeLicenseApplication::latest()->first() ?? new TradeLicenseApplication();
        return view('admin.pages.data-entry.tl-application.create', [
            'application' => $trade_license_application,
            'districts' => Helpers::DISTRICTS,
            'businessCategories' => BusinessCategory::all(),
            'signboards' => Signboard::all()
        ]);
    }
}
