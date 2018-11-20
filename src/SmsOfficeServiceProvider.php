<?php

namespace Lotuashvili\LaravelSmsOffice;

use Illuminate\Support\ServiceProvider;

class SmsOfficeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/smsoffice.php' => config_path('smsoffice.php'),
        ], 'config');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
