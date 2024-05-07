<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Models\BusinessCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\TradeLicenseStoreRequest;
use App\Models\TradeLicenseApplication;
use App\Models\TradeLicenseRequiredDocument;
use App\Services\TradeLicenseApplicationService;
use App\Traits\ImageHandling;

class TradeLicenseApplicationController extends Controller
{
    use ImageHandling;

    public function index(){
        return view('user.pages.tl-application.index', [
            'applications' => TradeLicenseApplication::where('user_id', auth()->id())->latest()->get()
        ]);
    }

    public function create(){
        return view('user.pages.tl-application.create', [
            'businessCategories' => BusinessCategory::all(),
            'requiredDocuments' => TradeLicenseRequiredDocument::all(),
            'districts' => Helpers::DISTRICTS
        ]);
    }

    public function store(TradeLicenseStoreRequest $request){
        $tl = TradeLicenseApplication::create(collect($request->validated())->merge([
            'user_id' => auth()->id(),
            'nature_of_business' => Helpers::translateBusinessNature($request->nature_of_business_bn),
            'ca_division' => Helpers::translateDivisionToEnglish($request->ca_division_bn),
            'ca_district' => Helpers::translateDistrictToEnglish($request->ca_district_bn),
            'pa_division' => Helpers::translateDivisionToEnglish($request->pa_division_bn),
            'pa_district' => Helpers::translateDistrictToEnglish($request->pa_district_bn),
            'image' => $this->uploadImage('image', 'applications/trade_license/', false),
            'status' => TradeLicenseApplication::PENDING_FORM_FEE_PAYMENT,
        ])->all());

        $tlService = new TradeLicenseApplicationService($tl);
        $documentsHasUploaded = $tlService->uploadDocuments($request->documents);

        if(!$documentsHasUploaded){
            $tl->delete();
            return redirect()->route('user.trade_license_applications.create')->with('error', 'ডকুমেন্ট আপলোড করা যায়নি। আবেদন পুনরায় জমা দিন।');
        }

        return redirect()->route('user.trade_license_applications.create')->with('success', 'আবেদন সফলভাবে জমা দেয়া হয়েছে। ফরম ফি পরিশোধ করুন।');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
