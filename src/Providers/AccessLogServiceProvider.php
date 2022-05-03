<?php

namespace Gpxcat\LaravelAccessLog\Providers;

use Illuminate\Support\ServiceProvider;

class AccessLogServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
