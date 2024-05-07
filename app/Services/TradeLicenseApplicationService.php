<?php
namespace App\Services;

use App\Models\TradeLicenseApplication;
use App\Models\TradeLicenseDocument;
use App\Models\TradeLicenseRequiredDocument;
use Illuminate\Support\Facades\Storage;

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
                TradeLicenseDocument::create([
                    'trade_license_application_id' => $this->tlApplication->id ?? 1, 
                    'trade_license_required_document_id' => $id,
                    'document_name' => $name,
                    'document_path' => $path
                ]);
            } catch (\Exception $exc) {
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

                //delete the old document from storage
                Storage::disk('public')->exists($existingDocument->document_path) ? Storage::disk('public')->delete($existingDocument->document_path) : null;

                //update the document
                $ext = $doc->getClientOriginalExtension();
                $name = TradeLicenseRequiredDocument::find($id)->document_name;
                $path = $doc->storeAs('documents', md5(time().$id).'.'.$ext, 'public');
                
                //update DB entries
                $existingDocument->update([
                    'document_name' => $name,
                    'document_path' => $path
                ]);
            } catch (\Exception $exc) {
                return false;
            }
        }
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
}

























?>