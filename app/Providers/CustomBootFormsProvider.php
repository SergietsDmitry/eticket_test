<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libs\CustomBootForms\CustomFormBuilder;
use App\Libs\CustomBootForms\CustomBasicFormBuilder;
use App\Libs\CustomBootForms\CustomHorizontalFormBuilder;
use App\Libs\CustomBootForms\CustomBootForm;

class CustomBootFormsProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->registerFormBuilder();
        $this->registerBasicFormBuilder();
        $this->registerHorizontalFormBuilder();
        $this->registerBootForm();
   }
   
   protected function registerFormBuilder()
   {
       $this->app['adamwathan.form'] = $this->app->singleton(CustomFormBuilder::class, function ($app) {
            $formBuilder = new CustomFormBuilder;
            $formBuilder->setErrorStore($app['adamwathan.form.errorstore']);
            $formBuilder->setOldInputProvider($app['adamwathan.form.oldinput']);
            $formBuilder->setToken($app['session.store']->getToken());

            return $formBuilder;
        });
   }
   
   protected function registerBasicFormBuilder()
   {
        $this->app['bootform.basic'] = $this->app->singleton(CustomBasicFormBuilder::class, function ($app) {
            return new CustomBasicFormBuilder($app['adamwathan.form']);
        });
   }
   
   protected function registerHorizontalFormBuilder()
   {
        $this->app['bootform.horizontal'] = $this->app->singleton(CustomHorizontalFormBuilder::class, function ($app) {
            return new CustomHorizontalFormBuilder($app['adamwathan.form']);
        });
   }
   
   protected function registerBootForm()
   {
        $this->app['bootform'] = $this->app->singleton(CustomBootForm::class, function ($app) {
            return new CustomBootForm($app['bootform.basic'], $app['bootform.horizontal']);
        });
   }
}