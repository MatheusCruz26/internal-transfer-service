<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Core\Http\HttpClient',
            'App\Core\Http\GuzzleClient'
        );
    }
}