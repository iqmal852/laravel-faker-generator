<?php

namespace Iqmal\LaravelFakerGenerator;

use Illuminate\Support\ServiceProvider;

class LaravelFakerGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
         $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-faker-generator');
         $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');

        if ($this->app->runningInConsole()) {

            //Publishing Config
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-faker-generator.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-faker-generator'),
            ], 'views');

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-faker-generator'),
            ], 'assets');

            // Publishing seeder
            if (!class_exists('FakerSeeder')) {
                $this->publishes([
                    __DIR__ . '/../databases/seeds/faker/FakerSeeder.php' => database_path('seeds/faker/FakerSeeder.php')
                ], 'seeder');
            }

        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-faker-generator');

        // Register the main class to use with the facade
        $this->app->bind('laravel-faker-generator', function () {
            return new LaravelFakerGenerator;
        });
    }
}
