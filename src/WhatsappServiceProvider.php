<?php

namespace RocketsLab\LaravelWhatsapp;

use Illuminate\Support\ServiceProvider;
use RocketsLab\LaravelWhatsapp\Commands\ServerInstallCommand;
use RocketsLab\LaravelWhatsapp\Commands\WACommand;

class WhatsappServiceProvider extends ServiceProvider
{
    public function register()
    {

        $this->app->singleton(Whatsapp::class, function ($app) {
            $config = $app['config']['laravel_whatsapp'];
            return new Whatsapp($config['protocol'], $config['host'], $config['port']);
        });

        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel_whatsapp.php', 'laravel_whatsapp'
        );

    }

    public function boot()
    {
        $this->registerCommands();

        $this->publishesConfig();

    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                WACommand::class,
                ServerInstallCommand::class,
            ]);
        }
    }

    protected function publishesConfig()
    {
        $this->publishes([
            __DIR__.'/../config/laravel_whatsapp.php' => config_path('laravel_whatsapp.php'),
        ]);
    }
}
