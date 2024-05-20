<?php

namespace App\Observers;

use App\Helpers\Helpers;
use App\Models\TradeLicenseApplication;
use App\Services\TradeLicenseApplicationService;

class TradeLicenseApplicationObserver
{
    /**
     * Handle the TradeLicenseApplication "created" event.
     */
    public function created(TradeLicenseApplication $tradeLicenseApplication): void
    {
        $tlService = new TradeLicenseApplicationService($tradeLicenseApplication);
        $activity = $tlService->determineActivity();

        $tradeLicenseApplication->tlActivities()->create([
            'activity' => $activity
        ]);
    }

    /**
     * Handle the TradeLicenseApplication "updated" event.
     */
    public function updated(TradeLicenseApplication $tradeLicenseApplication): void
    {
        if($tradeLicenseApplication->ca_division_bn != $tradeLicenseApplication->getOriginal('ca_division_bn')) {
            $tradeLicenseApplication->ca_division = Helpers::translateDivisionToEnglish($tradeLicenseApplication->ca_division_bn);
            $tradeLicenseApplication->saveQuietly();
        }
        
        if($tradeLicenseApplication->ca_district_bn != $tradeLicenseApplication->getOriginal('ca_district_bn')) {
            $tradeLicenseApplication->ca_district = Helpers::translateDistrictToEnglish($tradeLicenseApplication->ca_district_bn);
            $tradeLicenseApplication->saveQuietly();
        }
        
        if($tradeLicenseApplication->pa_division_bn != $tradeLicenseApplication->getOriginal('pa_division_bn')) {
            $tradeLicenseApplication->pa_division = Helpers::translateDivisionToEnglish($tradeLicenseApplication->pa_division_bn);
            $tradeLicenseApplication->saveQuietly();
        }
        
        if($tradeLicenseApplication->pa_district_bn != $tradeLicenseApplication->getOriginal('pa_district_bn')) {
            $tradeLicenseApplication->pa_district = Helpers::translateDistrictToEnglish($tradeLicenseApplication->pa_district_bn);
            $tradeLicenseApplication->saveQuietly();
        }

        if ($tradeLicenseApplication->getOriginal('status') != $tradeLicenseApplication->status) {
            $tlService = new TradeLicenseApplicationService($tradeLicenseApplication);
            $activity = $tlService->determineActivity($tradeLicenseApplication->getOriginal('status'));
    
            $message = request()->has('message') ? request()->get('message') : null;
            $payment_amount = request()->has('payment_amount') ? request()->get('payment_amount') : null;
    
            $tradeLicenseApplication->tlActivities()->create([
                'activity' => $activity,
                'message' => $message,
                'payment_amount' => $payment_amount,
            ]);
        }

    }

    /**
     * Handle the TradeLicenseApplication "deleted" event.
     */
    public function deleted(TradeLicenseApplication $tradeLicenseApplication): void{
        //
    }

    /**
     * Handle the TradeLicenseApplication "restored" event.
     */
    public function restored(TradeLicenseApplication $tradeLicenseApplication): void
    {
        //  eeee
    }

    /**
     * Handle the TradeLicenseApplication "force deleted" event.
     */
    public function forceDeleted(TradeLicenseApplication $tradeLicenseApplication): void
    {
        //
    }
}
