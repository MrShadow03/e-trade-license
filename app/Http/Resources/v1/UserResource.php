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
            'ownerNameBn' => $this->name,
            'ownerName' => $latestTradeLicenseApplication->owner_name ?? null,
            'fatherNameBn' => $latestTradeLicenseApplication->father_name_bn ?? null,
            'fatherName' => $latestTradeLicenseApplication->father_name ?? null,
            'motherNameBn' => $latestTradeLicenseApplication->mother_name_bn ?? null,
            'motherName' => $latestTradeLicenseApplication->mother_name ?? null,
            'spouseNameBn' => $latestTradeLicenseApplication->spouse_name_bn ?? null,
            'spouseName' => $latestTradeLicenseApplication->spouse_name ?? null,
            'nationalIdNo' => $latestTradeLicenseApplication->national_id_no ?? null,
            'birthRegistrationNo' => $latestTradeLicenseApplication->birth_registration_no ?? null,
            'passportNo' => $latestTradeLicenseApplication->passport_no ?? null,
            'caHoldingNo' => $latestTradeLicenseApplication->ca_holding_no ?? null,
            'caRoadNo' => $latestTradeLicenseApplication->ca_road_no ?? null,
            'caPostCode' => $latestTradeLicenseApplication->ca_post_code ?? null,
            'caVillageBn' => $latestTradeLicenseApplication->ca_village_bn ?? null,
            'caVillage' => $latestTradeLicenseApplication->ca_village ?? null,
            'caPostOfficeBn' => $latestTradeLicenseApplication->ca_post_office_bn ?? null,
            'caPostOffice' => $latestTradeLicenseApplication->ca_post_office ?? null,
            'caDivisionBn' => $latestTradeLicenseApplication->ca_division_bn ?? null,
            'caDistrictBn' => $latestTradeLicenseApplication->ca_district_bn ?? null,
            'caUpazillaBn' => $latestTradeLicenseApplication->ca_upazilla_bn ?? null,
            'caUpazilla' => $latestTradeLicenseApplication->ca_upazilla ?? null,
            'paHoldingNo' => $latestTradeLicenseApplication->pa_holding_no ?? null,
            'paRoadNo' => $latestTradeLicenseApplication->pa_road_no ?? null,
            'paPostCode' => $latestTradeLicenseApplication->pa_post_code ?? null,
            'paVillageBn' => $latestTradeLicenseApplication->pa_village_bn ?? null,
            'paVillage' => $latestTradeLicenseApplication->pa_village ?? null,
            'paPostOfficeBn' => $latestTradeLicenseApplication->pa_post_office_bn ?? null,
            'paPostOffice' => $latestTradeLicenseApplication->pa_post_office ?? null,
            'paDivisionBn' => $latestTradeLicenseApplication->pa_division_bn ?? null,
            'paDistrictBn' => $latestTradeLicenseApplication->pa_district_bn ?? null,
            'paUpazillaBn' => $latestTradeLicenseApplication->pa_upazilla_bn ?? null,
            'paUpazilla' => $latestTradeLicenseApplication->pa_upazilla ?? null,
        ];
    }
}
