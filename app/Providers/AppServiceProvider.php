<?php

namespace App\Providers;

use AnotherNamespace\ReCaptcha as CustomReCaptcha;
use ReCaptcha\ReCaptcha;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            $recaptcha = new ReCaptcha(config('services.recaptcha.secret'));

            $response = $recaptcha->verify($value, $_SERVER['REMOTE_ADDR']);

            return $response->isSuccess();
        });
    }
}
