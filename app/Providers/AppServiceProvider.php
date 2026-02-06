<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
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
        // App::setLocale('ar');

        JsonResource::withoutWrapping(); // this is reomving the data object (data:{})

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
