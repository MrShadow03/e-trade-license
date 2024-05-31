<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\TradeLicenseExpiringJob;
use App\Models\TradeLicenseApplication;

class CheckExpiredApplications extends Command {
    protected $signature = 'app:check-expired-applications';
    protected $description = 'Check for expired applications and dispatch jobs';

    public function __construct() {
        parent::__construct();
    }

    public function handle() {
        // if there are issued trade license applications with the expiry date in the past
        TradeLicenseApplication::where('status', 'issued')->where('expiry_date', '<', now())->exists() && dispatch(new TradeLicenseExpiringJob());
    }
}
