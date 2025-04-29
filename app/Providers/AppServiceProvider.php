<?php

namespace App\Providers;

use App\AppValues\RoleNamesValues;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $abilty) {
            return $user->hasRole(RoleNamesValues::ADMIN->value) ? true : null;
        });
    }
}
