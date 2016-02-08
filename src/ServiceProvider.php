<?php
namespace Rolice\LaravelCurrency;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/laravel-currency' => config_path('laravel-currency')], 'config');
        $this->publishes([__DIR__ . '/../database/migrations/' => database_path('migrations')], 'migrations');

        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-currency/laravel-currency.php', 'laravel-currency');
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-currency/repository/yahoo-finance.php', 'yahoo-finance');

        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/Http/routes.php';
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Currency', Config::get('laravel-currency.laravel-currency.repository'));
    }

}