<?php

namespace App\Libs\Countries;

use App\Libs\Countries\Countries;
use Illuminate\Support\ServiceProvider;

/**
 * CountryListServiceProvider
 */
class CountriesServiceProvider extends ServiceProvider {

    /**
     * Register everything.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCountries();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registerCountries()
    {
        $this->app->bind('countries', function($app)
        {
            return new Countries();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['countries'];
    }
}

