<?php

namespace App\Providers;

use Klaviyo\Klaviyo;
use Illuminate\Support\ServiceProvider;

class KlaviyoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(klaviyo::class, function () {
            return new Klaviyo(
                config('services.klaviyo.secret'),
                config('services.klaviyo.public')
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
