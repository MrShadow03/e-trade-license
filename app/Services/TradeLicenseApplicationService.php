<?php
namespace App\Services;

use Carbon\Carbon;
use App\Helpers\Helpers;
use App\Models\TradeLicenseDocument;
use App\Models\TradeLicenseApplication;
use Illuminate\Support\Facades\Storage;
use App\Models\TradeLicenseRequiredDocument;

class TradeLicenseApplicationService {
    
    public $tlApplication;

    public function __construct(TradeLicenseApplication $tlApplication){
        $this->tlApplication = $tlApplication;
    }

    public function uploadDocuments(array $documents): bool {
        foreach($documents as $id => $doc){
            try {
                $ext = $doc->getClientOriginalExtension();
                $name = TradeLicenseRequiredDocument::find($id)->document_name;
                $path = $doc->storeAs('documents', md5(time().$id).'.'.$ext, 'public');
                
                //create DB entries
                $newDocument = TradeLicenseDocument::create([
                    'trade_license_application_id' => $this->tlApplication->id ?? 1, 
                    'trade_license_required_document_id' => $id,
                    'document_name' => $name,
                    'document_path' => $path
                ]);

                $newDocument->addMedia(storage_path('app/public/' . $path))->toMediaCollection('document');

                //update the document path
                $newDocument->update(['document_path' => $newDocument->getFirstMedia('document')->getUrl()]);

            } catch (\Exception $exc) {
                dd($exc->getMessage());
                return false;
            }
        }
        return true;
    }

    public function getDocuments(): array {
        $docs = TradeLicenseDocument::where('trade_license_application_id', $this->tlApplication->id)->get();
        return $docs->toArray();
    }

    public function updateDocuments(array $documents): bool {
        foreach($documents as $id => $doc){
            try {
                //find the document
                $existingDocument = TradeLicenseDocument::where('trade_license_application_id', $this->tlApplication->id)
                    ->where('trade_license_required_document_id', $id)
                    ->first();
                
                if(!$existingDocument){
                    return false;
                }

                // clear the media collection
                $existingDocument->clearMediaCollection('document');

                //update the document
                $ext = $doc->getClientOriginalExtension();
                $name = TradeLicenseRequiredDocument::find($id)->document_name;
                $path = $doc->storeAs('documents', md5(time().$id).'.'.$ext, 'public');
                
                $existingDocument->addMedia(storage_path('app/public/' . $path))->toMediaCollection('document');

                //update DB entries
                $existingDocument->update([
                    'document_name' => $name,
                    'document_path' => $existingDocument->getFirstMedia('document')->getUrl()
                ]);
            } catch (\Exception $exc) {
                dd($exc->getMessage());
                return false;
            }
        }

        return true;
    }

    public function deleteDocuments(): bool {
        $docs = TradeLicenseDocument::where('trade_license_application_id', $this->tlApplication->id)->get();
        foreach($docs as $doc){
            Storage::disk('public')->exists($doc->document_path) ? Storage::disk('public')->delete($doc->document_path) : null;
            $doc->delete();
        }
        return true;
    }

    public function getMissingDocuments(): array {
        $requiredDocs = TradeLicenseRequiredDocument::all();
        $uploadedDocs = TradeLicenseDocument::where('trade_license_application_id', $this->tlApplication->id)->get();
        $missingDocs = [];
        foreach($requiredDocs as $doc){
            $found = false;
            foreach($uploadedDocs as $udoc){
                if($doc->id == $udoc->trade_license_required_document_id){
                    $found = true;
                    break;
                }
            }
            if(!$found){
                $missingDocs[] = $doc->toArray();
            }
        }
        return $missingDocs;
    }

    public function hasAllDocuments(): bool {
        return count($this->missingDocuments()) == 0;
    }

    public function updateImage() {
        
        if(request()->hasFile('image')){
            $this->tlApplication->clearMediaCollection('owner_image');
            $path = Helpers::resizeImage();
            $this->tlApplication->addMedia($path)->toMediaCollection('owner_image');
        }
        
        return true;
    }

    public function hasUpdatedData(array $requestData): bool {
        try{
            $requestData = collect($requestData)->except(['application_id'])->sortKeys()->toArray();
            $existingData = collect($this->tlApplication->toArray())->only(array_keys($requestData))->sortKeys()->toArray();
    
            $existingData['business_starting_date'] = Carbon::parse($this->tlApplication->business_starting_date)->format('Y-m-d');
            $existingData['business_category_id'] = (string) $this->tlApplication->business_category_id;
            $existingData['signboard_id'] = (string) $this->tlApplication->signboard_id;
    
            $requestHash = hash('sha256', serialize($requestData));
            $existingHash = hash('sha256', serialize($existingData));
        } catch (\Exception $exc) {
            return true;
        }

        return $requestHash != $existingHash;
    }

    protected $statusMappings = [
        [null, Helpers::PENDING_FORM_FEE_PAYMENT, Helpers::FORM_CREATED],
        [Helpers::PENDING_FORM_FEE_PAYMENT, Helpers::PENDING_FORM_FEE_VERIFICATION, Helpers::FORM_FEE_SUBMITTED],
        [Helpers::PENDING_FORM_FEE_VERIFICATION, Helpers::PENDING_FORM_FEE_PAYMENT, Helpers::FORM_FEE_REJECTED],
        [Helpers::PENDING_FORM_FEE_VERIFICATION, Helpers::PENDING_ASSISTANT_APPROVAL, Helpers::FORM_FEE_VERIFIED],
        [Helpers::PENDING_ASSISTANT_APPROVAL, Helpers::DENIED_ASSISTANT_APPROVAL, Helpers::ASSISTANT_REJECTED],
        [Helpers::DENIED_ASSISTANT_APPROVAL, Helpers::PENDING_ASSISTANT_APPROVAL, Helpers::USER_CORRECTION],
        [Helpers::PENDING_ASSISTANT_APPROVAL, Helpers::PENDING_INSPECTOR_APPROVAL, Helpers::ASSISTANT_APPROVED],
        [Helpers::PENDING_INSPECTOR_APPROVAL, Helpers::DENIED_INSPECTOR_APPROVAL, Helpers::INSPECTOR_REJECTED],
        [Helpers::PENDING_INSPECTOR_APPROVAL, Helpers::PENDING_LICENSE_FEE_PAYMENT, Helpers::INSPECTOR_APPROVED],
        [Helpers::PENDING_LICENSE_FEE_PAYMENT, Helpers::PENDING_LICENSE_FEE_VERIFICATION, Helpers::LICENSE_FEE_SUBMITTED],
        [Helpers::PENDING_LICENSE_FEE_VERIFICATION, Helpers::PENDING_LICENSE_FEE_PAYMENT, Helpers::LICENSE_FEE_REJECTED],
        [Helpers::PENDING_LICENSE_FEE_VERIFICATION, Helpers::PENDING_SUPT_APPROVAL, Helpers::LICENSE_FEE_VERIFIED],
        [Helpers::PENDING_SUPT_APPROVAL, Helpers::DENIED_SUPT_APPROVAL, Helpers::SUPT_REJECTED],
        [Helpers::DENIED_SUPT_APPROVAL, Helpers::PENDING_SUPT_APPROVAL, Helpers::USER_CORRECTION],
        [Helpers::PENDING_SUPT_APPROVAL, Helpers::PENDING_RO_APPROVAL, Helpers::SUPT_APPROVED],
        [Helpers::PENDING_RO_APPROVAL, Helpers::DENIED_RO_APPROVAL, Helpers::RO_REJECTED],
        [Helpers::DENIED_RO_APPROVAL, Helpers::PENDING_RO_APPROVAL, Helpers::USER_CORRECTION],
        [Helpers::PENDING_RO_APPROVAL, Helpers::PENDING_CRO_APPROVAL, Helpers::RO_APPROVED],
        [Helpers::PENDING_CRO_APPROVAL, Helpers::DENIED_CRO_APPROVAL, Helpers::CRO_REJECTED],
        [Helpers::DENIED_CRO_APPROVAL, Helpers::PENDING_CRO_APPROVAL, Helpers::USER_CORRECTION],
        [Helpers::PENDING_CRO_APPROVAL, Helpers::PENDING_CEO_APPROVAL, Helpers::CRO_APPROVED],
        [Helpers::PENDING_CEO_APPROVAL, Helpers::DENIED_CEO_APPROVAL, Helpers::CEO_REJECTED],
        [Helpers::DENIED_CEO_APPROVAL, Helpers::PENDING_CEO_APPROVAL, Helpers::USER_CORRECTION],
        [Helpers::PENDING_CEO_APPROVAL, Helpers::ISSUED, Helpers::ISSUED]
    ];

    public function determineActivity($prevStatus = null): string {
        $currentStatus = $this->tlApplication->status;
        foreach ($this->statusMappings as $mapping) {
            [$prev, $current, $activity] = $mapping;
            if ($prev === $prevStatus && $current === $currentStatus) {
                return $activity;
            }
        }

        return Helpers::UNKNOWN_ACTIVITY;
    }

    public function isTransitionValid($prevStatus = null): bool {
        $currentStatus = $this->tlApplication->status;
        foreach ($this->statusMappings as $mapping) {
            [$prev, $current] = $mapping;
            if ($prev === $prevStatus && $current === $currentStatus) {
                return true;
            }
        }

        return false;
    }
}

























?>