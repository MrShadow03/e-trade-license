<?php

namespace App\Http\Controllers;

use Milon\Barcode\DNS2D;
use Illuminate\Http\Request;
use App\Models\TradeLicenseApplication;
use Illuminate\Support\Facades\Validator;

class TradeLicenseController extends Controller{
    
    public function show($uuid){

        Validator::make(['uuid' => $uuid], [
            'uuid' => 'required|exists:trade_license_applications,uuid',
        ])->validate();

        $application = TradeLicenseApplication::where('uuid', $uuid)->firstOrFail();    
        $url = request()->fullUrl();
        $qrcode = new DNS2D();
        $qrcodeHTML = $qrcode->getBarcodeHTML($url, 'QRCODE', 3, 3);

        return view('pages.trade-license', [
            'application' => $application,
            'uuid' => $uuid,
            'qrcode' => $qrcodeHTML,
        ]);
    }
}
