<?php

namespace Phalconvee\Paga;

use Illuminate\Support\ServiceProvider;

class PagaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/paga.php' => config_path('paga.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/paga.php', 'paga');

        // Register the main class to use with the facade
        $this->app->singleton('paga', function () {
            return new Paga;
        });
    }
}
