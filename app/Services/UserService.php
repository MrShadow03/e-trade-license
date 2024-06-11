<?php
namespace App\Services;

use App\Helpers\Helpers;

class UserService {
    protected $attributes;
    
    public function __construct()
    {
        $this->attributes = [
            'name' => request()->name,
            'father_name' => request()->father_name,
            'father_name_bn' => request()->father_name_bn,
            'mother_name' => request()->mother_name,
            'mother_name_bn' => request()->mother_name_bn,
            'spouse_name' => request()->spouse_name,
            'spouse_name_bn' => request()->spouse_name_bn,
            'birth_registration_no' => request()->birth_registration_no,
            'passport_no' => request()->passport_no,
            'ca_holding_no' => request()->ca_holding_no,
            'ca_road_no' => request()->ca_road_no,
            'ca_post_code' => request()->ca_post_code,
            'ca_village_bn' => request()->ca_village_bn,
            'ca_village' => request()->ca_village,
            'ca_post_office_bn' => request()->ca_post_office_bn,
            'ca_post_office' => request()->ca_post_office,
            'ca_division_bn' => request()->ca_division_bn,
            'ca_district_bn' => request()->ca_district_bn,
            'ca_upazilla_bn' => request()->ca_upazilla_bn,
            'ca_upazilla' => request()->ca_upazilla,
            'pa_holding_no' => request()->pa_holding_no,
            'pa_road_no' => request()->pa_road_no,
            'pa_post_code' => request()->pa_post_code,
            'pa_village_bn' => request()->pa_village_bn,
            'pa_village' => request()->pa_village,
            'pa_post_office_bn' => request()->pa_post_office_bn,
            'pa_post_office' => request()->pa_post_office,
            'pa_division_bn' => request()->pa_division_bn,
            'pa_district_bn' => request()->pa_district_bn,
            'pa_upazilla_bn' => request()->pa_upazilla_bn,
            'pa_upazilla' => request()->pa_upazilla,
        ];
    }

    public function updateMissingInfo(){
        $user = auth()->user();
        
        $missingInfo = [];

        $missingInfo['ca_division'] = Helpers::translateDivisionToEnglish(request()->ca_division_bn);
        $missingInfo['ca_district'] = Helpers::translateDistrictToEnglish(request()->ca_district_bn);
        $missingInfo['pa_division'] = Helpers::translateDivisionToEnglish(request()->pa_division_bn);
        $missingInfo['pa_district'] = Helpers::translateDistrictToEnglish(request()->pa_district_bn);

        foreach($this->attributes as $key => $value){
            if(!$user->$key){
                $missingInfo[$key] = $value;
            }
        }

        $user->update($missingInfo);
    }
}