<?php

namespace App\Providers;

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
    public function boot()
    {
        if(env('APP_ENV') == 'production'):
            $this->app['request']->server->set('HTTPS', 'on');
            URL::forceScheme('https');
            URL::forceRootUrl(env('APP_URL'));
        endif;
    }
}
