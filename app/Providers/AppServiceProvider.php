<?php

namespace App\Providers;

use Bouncer;
use Validator;
use App\Entities\Role;
use App\Entities\Ability;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
	Schema::defaultStringLength(191);
        Validator::extend('greater_than', function ($attribute, $value, $parameters, $validator) {
            $min_field = $parameters[0];
            $data = $validator->getData();
            $min_value = $data[$min_field];

            return $value > $min_value;
        });

        Validator::replacer('greater_than', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':field', str_replace('_', ' ', $parameters[0]), $message);
        });
        Bouncer::useAbilityModel(Ability::class);
        Bouncer::useRoleModel(Role::class);
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->register(BindingsProvider::class);
    }
}
