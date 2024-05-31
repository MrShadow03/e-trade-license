<?php

namespace App\Jobs;

use App\Helpers\Helpers;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Models\TradeLicenseApplication;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        TradeLicenseApplication::where('status', Helpers::ISSUED)->where('expiry_date', '<', now())->update([
            'status' => Helpers::EXPIRED,
            'issued_at' => null,
            'expiry_date' => null,
        ]);
    }
}
