<?php

namespace App\Libs\Cities;

use Illuminate\Support\ServiceProvider;

/**
 * CountryListServiceProvider
 *
 */

class CitiesServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
    * Bootstrap the application.
    *
    * @return void
    */
    public function boot()
    {
    }

    /**
     * Register everything.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCities();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registerCities()
    {
        $this->app->bind('cities', function($app)
        {
            return new Cities();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('cities');
    }
}
