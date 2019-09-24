<?php 

namespace Betitoglez\Geoip;

use Betitoglez\Geoip\Exceptions\DriverNotFound;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class GeoipServiceProvider extends ServiceProvider implements DeferrableProvider
{


    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Publishes/config/geoip.php' => config_path('geoip.php')
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Geoip', function ($app) {

            switch (config('geoip.adapter','ip-api')){
                case 'geoip':
                    throw new DriverNotFound('Geo Ip Extension is not installed');
                    break;
                case 'ip-api':
                    return new IpApi();
                    break;
                default:
                    throw new DriverNotFound('Driver not implemented');
            }

        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('Geoip');
    }
}
