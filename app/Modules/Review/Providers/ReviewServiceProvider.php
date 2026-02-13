<?php

namespace App\Modules\Review\Providers;

use Illuminate\Support\ServiceProvider;

class ReviewServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations'); #migrations
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php'); #routes
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'review'); #views
        $this->loadJsonTranslationsFrom(__DIR__ . '/../resources/lang'); #translations
        $this->mergeConfigFrom(__DIR__ . '/../config/review.php', 'review'); #config

        $this->publishes([
            __DIR__ . '/../config/review.php' => config_path('review.php'),
        ], 'config'); #publish config file to the main config directory

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/review'),
        ], 'views'); #publish views to the main resources/views directory
    }
}
