<?php

namespace D2my\Impersonate\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ImpersonateServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

            $this->publishes([
                __DIR__ . '/../../config/impersonate.php' => config_path('impersonate.php'),
            ], 'impersonate');
        } else {
            Blade::directive('impersonate', function () {
                return "<?php if(cookie()->has('impersonate_token')): ?>";
            });

            Blade::directive('endimpersonate', function () {
                return "<?php endif; ?>";
            });
        }

        $this->mergeConfigFrom(__DIR__ . '/../../config/impersonate.php', 'impersonate');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/routes.php');
    }
}
