<?php

namespace Nisimpo\Requisition;

use Illuminate\Support\ServiceProvider;

class RequisitionServiceProvider extends ServiceProvider
{
    /**
     * Register the package services.
     *
     * @return void
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        /*$this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'requisitions');*/
    }
}
