<?php

namespace App\Providers;

use App\Models\Config as ConfigModel;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use NumberFormatter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // include __DIR__ . '/../helpers.php';

        // $this->app->bind('currency', function ($app) {
        //     return new NumberFormatter(App::currentLocale(), NumberFormatter::CURRENCY);
        // });

        # it is a best practises using a singleton designPattern (because using the same Object for this function-> (NumberFormatter) )
        $this->app->singleton('currency', function ($app) {
            return new NumberFormatter(App::currentLocale(), NumberFormatter::CURRENCY);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // App::setLocale('ar');

        # read the caching data (it is to fast in database)
        $configs = Cache::get('configs');
        if (!$configs) {
            $configs = ConfigModel::all();
            Cache::put('configs', $configs);
        }
        $configs->each(function ($config) {
            Config::set($config->name, $config->value);
        });

        # read the currency data from database (ConfigModel)
        // ConfigModel::all()->each(function ($config) {
        //     Config::set($config->name, $config->value);
        // });



        JsonResource::withoutWrapping(); // this is reomving the data object (data:{})

        if (App::environment('production')) {
            Config::set('app.debug', false);
        }

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
