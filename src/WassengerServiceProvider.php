<?php

namespace Alresia\LaravelWassenger;


use Illuminate\Support\ServiceProvider;

/**
 * @internal
 */
class WassengerServiceProvider extends ServiceProvider
{
   
    public const CONFIG = __DIR__.'/../config/wassenger.php';
    public const MIGRATIONS = __DIR__.'/../database/migrations';
    /**
     * Register the service provider.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register(): void
    {
        $this->mergeConfigFrom(static::CONFIG, 'wassenger');

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
            $this->publishesMigrations(static::MIGRATIONS);
            $this->publishes([static::CONFIG => $this->app->configPath('wassenger.php')], 'config');
        }
    }

    /**
     * Publishes migrations from the given path.
     *
     * @param  array|string  $paths
     * @param  string  $groups
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function publishesMigrations(array|string $paths, string $groups = 'migrations'): void
    {
        $prefix = now()->format('Y_m_d_His');

        $files = [];

        foreach ($this->app->make('files')->files($paths) as $file) {
            $filename = preg_replace('/^[\d|_]+/', '', $file->getFilename());

            $files[$file->getRealPath()] = $this->app->databasePath("migrations/{$prefix}_$filename");
        }

        $this->publishes($files, $groups);
    }

    
}
