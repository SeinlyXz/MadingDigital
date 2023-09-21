<?php

namespace App\Providers;

// use Facade URL
use Illuminate\Support\Facades\URL;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Leave this blank if you still in development
        // Uncomment this if you want to force https in production
        // if(env( key: 'APP_ENV') !== 'local')
        //     URL::forceScheme(scheme: 'https');
    }
}
