<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $latestTradeLicenseApplication = $this->tradeLicenseApplications->first();
        $imageUrl = $latestTradeLicenseApplication?->getFirstMediaUrl('owner_image');
        return [
            'id' => $this->id,
            'imageUrl' => $imageUrl,
            'ownerNameBn' => $this->name_bn,
            'ownerName' => $this->owner_name ?? null,
            'fatherNameBn' => $this->father_name_bn ?? null,
            'fatherName' => $this->father_name ?? null,
            'motherNameBn' => $this->mother_name_bn ?? null,
            'motherName' => $this->mother_name ?? null,
            'spouseNameBn' => $this->spouse_name_bn ?? null,
            'spouseName' => $this->spouse_name ?? null,
            'phone' => $this->phone,
            'nationalIdNo' => $this->national_id_no ?? null,
            'birthRegistrationNo' => $this->birth_registration_no ?? null,
            'passportNo' => $this->passport_no ?? null,
            'caHoldingNo' => $this->ca_holding_no ?? null,
            'caRoadNo' => $this->ca_road_no ?? null,
            'caPostCode' => $this->ca_post_code ?? null,
            'caVillageBn' => $this->ca_village_bn ?? null,
            'caVillage' => $this->ca_village ?? null,
            'caPostOfficeBn' => $this->ca_post_office_bn ?? null,
            'caPostOffice' => $this->ca_post_office ?? null,
            'caDivisionBn' => $this->ca_division_bn ?? null,
            'caDistrictBn' => $this->ca_district_bn ?? null,
            'caUpazillaBn' => $this->ca_upazilla_bn ?? null,
            'caUpazilla' => $this->ca_upazilla ?? null,
            'paHoldingNo' => $this->pa_holding_no ?? null,
            'paRoadNo' => $this->pa_road_no ?? null,
            'paPostCode' => $this->pa_post_code ?? null,
            'paVillageBn' => $this->pa_village_bn ?? null,
            'paVillage' => $this->pa_village ?? null,
            'paPostOfficeBn' => $this->pa_post_office_bn ?? null,
            'paPostOffice' => $this->pa_post_office ?? null,
            'paDivisionBn' => $this->pa_division_bn ?? null,
            'paDistrictBn' => $this->pa_district_bn ?? null,
            'paUpazillaBn' => $this->pa_upazilla_bn ?? null,
            'paUpazilla' => $this->pa_upazilla ?? null,
        ];
    }
}
