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

    public function replaceWithAmendmentDocument($requiredDocumentId){
        $amendment = $this->tlApplication->getActiveAmendment();
        $mediaCollectionName = $this->getMediaCollectionName($requiredDocumentId);
        $newDocument = $amendment->getMedia($mediaCollectionName)->first();

        if($newDocument){
            $targetDocument = $this->tlApplication->documents()->where('trade_license_required_document_id', $requiredDocumentId)->first();

            if($targetDocument){
                $amendment->addMedia(
                    $targetDocument->getMedia('document')->first()->getPath()
                )->toMediaCollection('old-'.$mediaCollectionName);

                $targetDocument->clearMediaCollection('document');
                $targetDocument->addMedia($newDocument->getPath())->toMediaCollection('document');
                $amendment->clearMediaCollection($mediaCollectionName);
            }else{
                $this->tlApplication->documents()->create([
                    'trade_license_required_document_id' => $requiredDocumentId,
                    'document_name' => TradeLicenseRequiredDocument::find($requiredDocumentId)->document_name,
                    'document_path' => $newDocument->getPath()
                ])->addMedia($newDocument->getPath())->toMediaCollection('document');
            }
        }
    }

    protected function getMediaCollectionName($requiredDocumentId): string {
        $names = [
            1 => 'house-ownership-document',
            2 => 'owner-national-id',
            3 => 'ownership-transfer-deed'
        ];

        return $names[$requiredDocumentId] ?? '';
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
                    
                //update the document
                $ext = $doc->getClientOriginalExtension();
                $name = TradeLicenseRequiredDocument::find($id)->document_name;
                $path = $doc->storeAs('documents', md5(time().$id).'.'.$ext, 'public');

                if($existingDocument){
                    $existingDocument->clearMediaCollection('document');
                    $existingDocument->addMedia(storage_path('app/public/' . $path))->toMediaCollection('document');
                    //update DB entries
                    $existingDocument->update([
                        'document_name' => $name,
                        'document_path' => $existingDocument->getFirstMedia('document')->getUrl()
                    ]);
                }else{
                    //create DB entries
                    $newDocument = TradeLicenseDocument::create([
                        'trade_license_application_id' => $this->tlApplication->id,
                        'trade_license_required_document_id' => $id,
                        'document_name' => $name,
                        'document_path' => $path
                    ]);

                    $newDocument->addMedia(storage_path('app/public/' . $path))->toMediaCollection('document');

                    //update the document path
                    $newDocument->update(['document_path' => $newDocument->getFirstMedia('document')->getUrl()]);
                }

                // clear the media collection

                

            } catch (\Exception $exc) {
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
        $requiredDocs = TradeLicenseRequiredDocument::where('is_required', true)->get();
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

    public function correctAndUpdate($validatedFields): void {
        $corrections = $this->tlApplication->corrections;

        //mark all provided documents as corrected
        if(array_key_exists('documents', $validatedFields)){
            foreach($validatedFields['documents'] as $id => $info){
                $corrections = array_diff_key($corrections, ['document-'.$id => '']);
            }

            $validatedFields = array_diff_key($validatedFields, ['documents' => '']);
        }
        
        //mark the image as corrected
        if(array_key_exists('image', $validatedFields)){
            $corrections = array_diff_key($corrections, ['image' => '']);
            $validatedFields = array_diff_key($validatedFields, ['image' => '']);
        }

        //mark the rest of the fields as corrected
        foreach($validatedFields as $field => $value){
            if($this->tlApplication->{$field} == $value){
                continue;
            }

            //update the field
            $this->tlApplication->update([$field => $value]);
            $corrections = array_diff_key($corrections, [$field => '']);
        }

        $this->tlApplication->update([
            'corrections' => $corrections
        ]);
    }

    public function hasAllFieldsCorrected(): bool {
        $corrections = $this->tlApplication->corrections;
        foreach($corrections as $field => $info){
            if($info['isCorrected'] == 0){
                return false;
            }
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
        [Helpers::PENDING_FORM_FEE_VERIFICATION, Helpers::DENIED_FORM_FEE_VERIFICATION, Helpers::FORM_FEE_REJECTED],
        [Helpers::DENIED_FORM_FEE_VERIFICATION, Helpers::PENDING_FORM_FEE_VERIFICATION, Helpers::FORM_FEE_RESUBMITTED],
        [Helpers::PENDING_FORM_FEE_VERIFICATION, Helpers::PENDING_ASSISTANT_APPROVAL, Helpers::FORM_FEE_VERIFIED],

        [Helpers::PENDING_ASSISTANT_APPROVAL, Helpers::DENIED_ASSISTANT_APPROVAL, Helpers::ASSISTANT_REJECTED],
        [Helpers::DENIED_ASSISTANT_APPROVAL, Helpers::PENDING_ASSISTANT_APPROVAL, Helpers::USER_CORRECTION],
        [Helpers::PENDING_ASSISTANT_APPROVAL, Helpers::PENDING_INSPECTOR_APPROVAL, Helpers::ASSISTANT_APPROVED],

        [Helpers::PENDING_INSPECTOR_APPROVAL, Helpers::DENIED_INSPECTOR_APPROVAL, Helpers::INSPECTOR_REJECTED],
        [Helpers::DENIED_INSPECTOR_APPROVAL, Helpers::PENDING_INSPECTOR_APPROVAL, Helpers::USER_CORRECTION],
        [Helpers::PENDING_INSPECTOR_APPROVAL, Helpers::PENDING_LICENSE_FEE_PAYMENT, Helpers::INSPECTOR_APPROVED],

        [Helpers::PENDING_LICENSE_FEE_PAYMENT, Helpers::PENDING_LICENSE_FEE_VERIFICATION, Helpers::LICENSE_FEE_SUBMITTED],
        [Helpers::PENDING_LICENSE_FEE_VERIFICATION, Helpers::DENIED_LICENSE_FEE_VERIFICATION, Helpers::LICENSE_FEE_REJECTED],
        [Helpers::DENIED_LICENSE_FEE_VERIFICATION, Helpers::PENDING_LICENSE_FEE_VERIFICATION, Helpers::LICENSE_FEE_RESUBMITTED],
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
        [Helpers::PENDING_CEO_APPROVAL, Helpers::ISSUED, Helpers::ISSUED],

        //! Renewal Activities
        [Helpers::EXPIRED, Helpers::PENDING_ASSISTANT_RENEWAL_APPROVAL, Helpers::RENEWAL_REQUESTED],
        [Helpers::EXPIRED, Helpers::PENDING_LICENSE_RENEWAL_FEE_VERIFICATION, Helpers::LICENSE_RENEWAL_FEE_SUBMITTED],

        [Helpers::PENDING_ASSISTANT_RENEWAL_APPROVAL, Helpers::DENIED_ASSISTANT_RENEWAL_APPROVAL, Helpers::ASSISTANT_RENEWAL_REJECTED],
        [Helpers::DENIED_ASSISTANT_RENEWAL_APPROVAL, Helpers::PENDING_ASSISTANT_RENEWAL_APPROVAL, Helpers::USER_CORRECTION],
        [Helpers::PENDING_ASSISTANT_RENEWAL_APPROVAL, Helpers::PENDING_INSPECTOR_RENEWAL_APPROVAL, Helpers::ASSISTANT_RENEWAL_APPROVED],

        [Helpers::PENDING_INSPECTOR_RENEWAL_APPROVAL, Helpers::DENIED_INSPECTOR_RENEWAL_APPROVAL, Helpers::INSPECTOR_RENEWAL_REJECTED],
        [Helpers::DENIED_INSPECTOR_RENEWAL_APPROVAL, Helpers::PENDING_INSPECTOR_RENEWAL_APPROVAL, Helpers::USER_CORRECTION],
        [Helpers::PENDING_INSPECTOR_RENEWAL_APPROVAL, Helpers::PENDING_LICENSE_RENEWAL_FEE_PAYMENT, Helpers::INSPECTOR_RENEWAL_APPROVED],

        [Helpers::PENDING_LICENSE_RENEWAL_FEE_PAYMENT, Helpers::PENDING_LICENSE_RENEWAL_FEE_VERIFICATION, Helpers::LICENSE_RENEWAL_FEE_SUBMITTED],
        [Helpers::PENDING_LICENSE_RENEWAL_FEE_VERIFICATION, Helpers::DENIED_LICENSE_RENEWAL_FEE_VERIFICATION, Helpers::LICENSE_RENEWAL_FEE_REJECTED],
        [Helpers::DENIED_LICENSE_RENEWAL_FEE_VERIFICATION, Helpers::PENDING_LICENSE_RENEWAL_FEE_VERIFICATION, Helpers::LICENSE_RENEWAL_FEE_RESUBMITTED],
        [Helpers::PENDING_LICENSE_RENEWAL_FEE_VERIFICATION, Helpers::PENDING_SUPT_RENEWAL_APPROVAL, Helpers::LICENSE_RENEWAL_FEE_VERIFIED],

        [Helpers::PENDING_SUPT_RENEWAL_APPROVAL, Helpers::DENIED_SUPT_RENEWAL_APPROVAL, Helpers::SUPT_RENEWAL_REJECTED],
        [Helpers::DENIED_SUPT_RENEWAL_APPROVAL, Helpers::PENDING_SUPT_RENEWAL_APPROVAL, Helpers::USER_CORRECTION],
        [Helpers::PENDING_SUPT_RENEWAL_APPROVAL, Helpers::PENDING_RO_RENEWAL_APPROVAL, Helpers::SUPT_RENEWAL_APPROVED],

        [Helpers::PENDING_RO_RENEWAL_APPROVAL, Helpers::DENIED_RO_RENEWAL_APPROVAL, Helpers::RO_RENEWAL_REJECTED],
        [Helpers::DENIED_RO_RENEWAL_APPROVAL, Helpers::PENDING_RO_RENEWAL_APPROVAL, Helpers::USER_CORRECTION],
        [Helpers::PENDING_RO_RENEWAL_APPROVAL, Helpers::ISSUED, Helpers::LICENSE_RENEWED],
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

    public function isValidTransition($nextStatus): bool {
        $currentStatus = $this->tlApplication->status;
        foreach ($this->statusMappings as $mapping) {
            [$current, $next] = $mapping;
            if ($current === $currentStatus && $next === $nextStatus) {
                return true;
            }
        }

        return false;
    }

    public static function getAccessibleApplicationStatuses(): array {
       $accessPermissions = [
            'verify-form-fee-payment' => Helpers::PENDING_FORM_FEE_VERIFICATION,
            'approve-pending-trade-license-assistant-approval-applications' => Helpers::PENDING_ASSISTANT_APPROVAL,
            'approve-pending-trade-license-inspector-approval-applications' => Helpers::PENDING_INSPECTOR_APPROVAL,
            'verify-license-fee-payment' => Helpers::PENDING_LICENSE_FEE_VERIFICATION,
            'approve-pending-trade-license-superintendent-approval-applications' => Helpers::PENDING_SUPT_APPROVAL,
            'approve-pending-revenue-officer-approval-applications' => Helpers::PENDING_RO_APPROVAL,
            'approve-pending-chief-revenue-officer-approval-applications' => Helpers::PENDING_CRO_APPROVAL,
            'approve-pending-chief-executive-officer-approval-applications' => Helpers::PENDING_CEO_APPROVAL,
            'approve-pending-trade-license-assistant-renewal-approval-applications' => Helpers::PENDING_ASSISTANT_RENEWAL_APPROVAL,
            'approve-pending-trade-license-inspector-renewal-approval-applications' => Helpers::PENDING_INSPECTOR_RENEWAL_APPROVAL,
            'verify-license-renewal-fee-payment' => Helpers::PENDING_LICENSE_RENEWAL_FEE_VERIFICATION,
            'approve-pending-trade-license-superintendent-renewal-approval-applications' => Helpers::PENDING_SUPT_RENEWAL_APPROVAL,
            'approve-pending-revenue-officer-renewal-approval-applications' => Helpers::PENDING_RO_RENEWAL_APPROVAL,
       ] ;

        $accessibleStatuses = [];
        foreach($accessPermissions as $permission => $status){
            if(auth()->user()->can($permission)){
                $accessibleStatuses[] = $status;
            }
        }
        
        return $accessibleStatuses;
    }
}

























?>