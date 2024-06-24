<?php

namespace App\Observers;

use App\Helpers\Helpers;
use App\Models\AmendmentApplication;

class AmendmentApplicationObserver
{
    /**
     * Handle the AmendmentApplication "created" event.
     */
    public function created(AmendmentApplication $amendmentApplication): void {
        $tlApplication = $amendmentApplication->tradeLicenseApplication;
        $amendmentType = $amendmentApplication->type;
        $activity = $amendmentType === Helpers::AMENDMENT_TYPE_RELOCATION ? Helpers::RELOCATION_AMENDMENT_CREATED : Helpers::OWNERSHIP_TRANSFER_AMENDMENT_CREATED;
        
        $tlApplication->tlActivities()->create([
            'activity' => $activity
        ]);
    }
    
    /**
     * Handle the AmendmentApplication "updated" event.
     */
    public function updated(AmendmentApplication $amendmentApplication): void {
        $tlApplication = $amendmentApplication->tradeLicenseApplication;

        if ($amendmentApplication->getOriginal('status') != $amendmentApplication->status) {
            $activity = Helpers::getAmendmentActivity($amendmentApplication->getOriginal('status'), $amendmentApplication->status);
    
            $message = request()->has('message') ? request()->get('message') : null;
            $payment_amount = request()->has('payment_amount') ? request()->get('payment_amount') : null;
    
            $tlApplication->tlActivities()->create([
                'activity' => $activity,
                'message' => $message,
                'payment_amount' => $payment_amount,
            ]);
        }
    }

    /**
     * Handle the AmendmentApplication "deleted" event.
     */
    public function deleted(AmendmentApplication $amendmentApplication): void
    {
        //
    }

    /**
     * Handle the AmendmentApplication "restored" event.
     */
    public function restored(AmendmentApplication $amendmentApplication): void
    {
        //
    }

    /**
     * Handle the AmendmentApplication "force deleted" event.
     */
    public function forceDeleted(AmendmentApplication $amendmentApplication): void
    {
        //
    }
}
