<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('script_tags_free', function ($attribute, $value, $parameters, $validator) {
            $originalValue = $value;
            $value = strip_tags($value);

            if (strlen($originalValue) == strlen($value)) {
                return true;
            } else {
                return false;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Contracts\Admin\UsersRepositoryInterface',
            'App\Repositories\Admin\UsersRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\Admin\EmployeesRepositoryInterface',
            'App\Repositories\Admin\EmployeesRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\Admin\BranchRepositoryInterface',
            'App\Repositories\Admin\BranchRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\UserDeviceTokenRepositoryInterface',
            'App\Repositories\UserDeviceTokensRepository'
        );
    }
}
