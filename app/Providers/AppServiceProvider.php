<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
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
        Validator::extend('filter', function ($attribute, $value) {
            if ($value == 'god') {
                return false;
            }
            return true;
        }, 'Invalid god word is not allowed.');

        Paginator::useBootstrap();
        // Paginator::useTailwind();
        // Paginator::defaultView('vendor.pagination.tailwind');
    }
}
