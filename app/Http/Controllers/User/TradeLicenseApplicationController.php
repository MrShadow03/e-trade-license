<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use App\Models\Signboard;
use Illuminate\Http\Request;
use App\Traits\ImageHandling;
use App\Models\BusinessCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\TradeLicenseApplication;
use App\Models\TradeLicenseRequiredDocument;
use App\Http\Requests\TradeLicenseStoreRequest;
use App\Http\Requests\TradeLicenseUpdateRequest;
use App\Services\TradeLicenseApplicationService;
use App\Http\Requests\TradeLicenseCorrectionRequest;

class TradeLicenseApplicationController extends Controller
{
    use ImageHandling;

    public function index(){
        return view('user.pages.tl-application.index', [
            'applications' => TradeLicenseApplication::where('user_id', auth()->id())->latest()->get(),
            'form_fee' => Helpers::TRADE_LICENSE_FORM_FEE,
        ]);
    }

    public function create(){
        return view('user.pages.tl-application.create', [
            'businessCategories' => BusinessCategory::all(),
            'requiredDocuments' => TradeLicenseRequiredDocument::all(),
            'districts' => Helpers::DISTRICTS,
            'signboards' => Signboard::all(),
            'latestApplication' => TradeLicenseApplication::where('user_id', auth()->id())->latest()->first() ?? null
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
            'fiscal_year' => date('Y').'-'.(date('Y')+1),
            'status' => Helpers::PENDING_FORM_FEE_PAYMENT,
        ])->all());

        
        $imagePath = Helpers::resizeImage();
        $tl->addMedia($imagePath)->toMediaCollection('owner_image');
        
        $tlService = new TradeLicenseApplicationService($tl);
        $documentsHasUploaded = $tlService->uploadDocuments($request->documents);
        if(!$documentsHasUploaded){
            $tl->delete();
            return redirect()->route('user.trade_license_applications.create')->with('error', 'ডকুমেন্ট আপলোড করা যায়নি। আবেদন পুনরায় জমা দিন।');
        }

        return redirect()->route('user.trade_license_applications')->with('success', 'আবেদন সফলভাবে জমা দেয়া হয়েছে। ফর্ম ফি পরিশোধ করুন।');
    }

    public function show(TradeLicenseApplication $tradeLicenseApplication, Request $request){
        Gate::authorize('view', $tradeLicenseApplication);

        $application = $tradeLicenseApplication->load([
            'documents.media', 
            'businessCategory' => function ($query) {
                $query->select('id','name_bn', 'fee');
            }, 
            'signboard' => function ($query) {
                $query->select('id', 'dimension', 'fee');
            }
        ]);

        return view('user.pages.tl-application.show', [
            'application' => $application
        ]);
    }

    public function edit(TradeLicenseApplication $tradeLicenseApplication){
        Gate::authorize('update', $tradeLicenseApplication);

        return view('user.pages.tl-application.edit', [
            'application' => $tradeLicenseApplication->load('documents'),
            'businessCategories' => BusinessCategory::all(),
            'requiredDocuments' => TradeLicenseRequiredDocument::all(),
            'districts' => Helpers::DISTRICTS,
            'signboards' => Signboard::all()
        ]);
    }

    public function update(TradeLicenseUpdateRequest $request, TradeLicenseApplication $tradeLicenseApplication){
        Gate::authorize('update', $tradeLicenseApplication);

        $tlService = new TradeLicenseApplicationService($tradeLicenseApplication);

        $tradeLicenseApplication->update(collect($request->validated())->merge([
            'nature_of_business' => Helpers::translateBusinessNature($request->nature_of_business_bn),
            'ca_division' => Helpers::translateDivisionToEnglish($request->ca_division_bn),
            'ca_district' => Helpers::translateDistrictToEnglish($request->ca_district_bn),
            'pa_division' => Helpers::translateDivisionToEnglish($request->pa_division_bn),
            'pa_district' => Helpers::translateDistrictToEnglish($request->pa_district_bn),
            'fiscal_year' => date('Y').'-'.(date('Y')+1),
        ])->all());

        $tlService->updateImage();

        if($request->has('documents')){
            $tlService->updateDocuments($request->documents);
        }

        return redirect()->route('user.trade_license_applications')->with('info', 'আবেদনটি সফলভাবে আপডেট করা হয়েছে।');
    }

    public function review(TradeLicenseApplication $tradeLicenseApplication){
        Gate::authorize('correct', $tradeLicenseApplication);

        return view('user.pages.tl-application.review', [
            'application' => $tradeLicenseApplication->load('documents'),
            'businessCategories' => BusinessCategory::all(),
            'requiredDocuments' => TradeLicenseRequiredDocument::all(),
            'districts' => Helpers::DISTRICTS,
            'signboards' => Signboard::all()
        ]);
    }

    public function correction(TradeLicenseApplication $tradeLicenseApplication, TradeLicenseCorrectionRequest $request) {
        Gate::authorize('correct', $tradeLicenseApplication);

        $tlService = new TradeLicenseApplicationService($tradeLicenseApplication);
        
        // update documents if there is any
        if($request->has('documents')){
            $tlService->updateDocuments($request->documents);
        }
        
        // update image if there is any
        if(array_key_exists('image', $tradeLicenseApplication->corrections)){
            $tlService->updateImage();
        }

        // mark as corrected
        $tlService->correctAndUpdate($request->validated());

        // if all fields are corrected, update status
        if($tlService->hasAllFieldsCorrected()){
            $tradeLicenseApplication->update([
                'status' => Helpers::CORRECTED_STATES[$tradeLicenseApplication->status] ?? $tradeLicenseApplication->status
            ]);

            return redirect()->route('user.trade_license_applications')->with('info', 'আবেদনটি যাচাইয়ের জন্য পাঠানো হয়েছে।');
        }

        return redirect()->route('user.trade_license_applications')->with('warning', 'আবেদনটির কিছু তথ্য সংশোধন করা হয়েছে।');
    }

    public function destroy(TradeLicenseApplication $tradeLicenseApplication){
        Gate::authorize('delete', $tradeLicenseApplication);

        if(!$tradeLicenseApplication->isDeletable()){
            return redirect()->route('user.trade_license_applications')->with('error', 'আবেদনটি ডিলিট করা যাবে না।');
        }

        $tlService = new TradeLicenseApplicationService($tradeLicenseApplication);
        $tlService->deleteDocuments();
        $tradeLicenseApplication->delete();

        return redirect()->route('user.trade_license_applications')->with('info', 'আবেদনটি ডিলিট করা হয়েছে।');
    }

    // Renewal
    public function renew(TradeLicenseApplication $tradeLicenseApplication){
        Gate::authorize('renew', $tradeLicenseApplication);

        $tradeLicenseApplication->update([
            'status' => Helpers::PENDING_FORM_FEE_PAYMENT,
            'fiscal_year' => date('Y').'-'.(date('Y')+1),
        ]);

        return redirect()->route('user.trade_license_applications')->with('info', 'আবেদনটি নতুন করে জমা দেয়া হয়েছে। ফর্ম ফি পরিশোধ করুন।');
    }
}
