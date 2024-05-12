<?php

namespace App\Observers;

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
        if ($tradeLicenseApplication->getOriginal('status') === $tradeLicenseApplication->status) {
            return;
        }

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
