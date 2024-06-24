<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Models\TradeLicenseApplication;

class TradeLicenseAmendmentController extends Controller{
    public function review(TradeLicenseApplication $tradeLicenseApplication){
        Gate::authorize('editRelocationApplication', $tradeLicenseApplication);
        
        return view('user.pages.tl-application.amendment.review', compact('tradeLicenseApplication'));
    }
}
