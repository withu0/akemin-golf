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
    public function boot(): void
    {
        // Baseline {locale} default so route('home') etc. work even outside
        // the localised group (e.g. admin pages). SetLocale overrides this
        // per-request for public, locale-prefixed routes.
        URL::defaults(['locale' => config('app.locale')]);
    }
}
