<?php

namespace Media365\Transmitter;

use Illuminate\Support\ServiceProvider;

class TransmitterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/transmitter.php', 'transmitter');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/transmitter.php' => config_path('transmitter.php'),
        ], 'config');

        $this->app->singleton("Transmitter", config('transmitter.driver'));
    }
}
