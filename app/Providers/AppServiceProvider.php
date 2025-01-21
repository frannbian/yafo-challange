<?php

namespace App\Providers;

use App\Integrations\Aleph\AlephProvider;
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
        AlephProvider::boot();
        //
    }
}
