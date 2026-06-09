<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        // Custom, framework-agnostic pagination (we do not ship Tailwind).
        Paginator::defaultView('pagination.beyond');
        Paginator::defaultSimpleView('pagination.beyond');
    }
}
