<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Facades\Health;

class HealthCheckProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Health::checks([
            DatabaseCheck::new(),
            DebugModeCheck::new(),
        ]);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
