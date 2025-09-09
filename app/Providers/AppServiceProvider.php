<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
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
        //strict mode
        Model::shouldBeStrict(!app()->isProduction());
        //lazy loading
        Model::preventLazyLoading(!app()->isProduction());
        //mass assignment
        Model::preventSilentlyDiscardingAttributes(!app()->isProduction());
        Paginator::useBootstrap();
    }
}
