<?php

namespace D2my\Impersonate\Providers;

use Illuminate\Support\ServiceProvider;

class ImpersonateServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            if (config('impersonate.migrate', false)) {
                $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
            }

            $this->publishes([
                __DIR__ . '/../../config/impersonate.php' => config_path('impersonate.php'),
            ], 'impersonate-config');

            $this->publishes([
                __DIR__ . '/../../src/Http/Middleware/Impersonate.php' => app_path('Http/Middleware/Impersonate/Impersonate.php'),
            ], 'impersonate-middleware');

            $this->publishes([
                __DIR__ . '/../../config/impersonate.php' => config_path('impersonate.php'),
                __DIR__ . '/../../src/Http/Middleware/Impersonate.php' => app_path('Http/Middleware/Impersonate/Impersonate.php'),
            ], 'impersonate');
        }

        $this->loadRoutesFrom(__DIR__ . '/../../routes/routes.php');
    }
}
