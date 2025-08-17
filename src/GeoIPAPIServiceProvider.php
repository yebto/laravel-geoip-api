<?php
namespace Yebto\GeoIPAPI;

use Illuminate\Support\ServiceProvider;

class GeoIPAPIServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/geoipapi.php', 'geoipapi');

        $this->app->singleton('geoipapi', fn () => new GeoIPAPI());
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/geoipapi.php' => config_path('geoipapi.php'),
        ], 'geoipapi-config');
    }
}
