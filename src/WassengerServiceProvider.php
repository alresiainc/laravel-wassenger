<?php

namespace Alresia\LaravelWassenger;


use Alresia\LaravelWassenger\Wassenger;
use Illuminate\Support\ServiceProvider;

/**
 * @internal
 */
class WassengerServiceProvider extends ServiceProvider
{
   
    public const CONFIG = __DIR__.'/../config/wassenger.php';
    
    /**
     * Register the service provider.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register(): void
    {
        $this->mergeConfigFrom(self::CONFIG, 'wassenger');

    }

    /**
     * Boot the service provider.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            
            $this->publishes([self::CONFIG => $this->app->configPath('wassenger.php')], 'config');
        }
    }

    
}
