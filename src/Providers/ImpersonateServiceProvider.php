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
                return "<?php if(!config('impersonate.gate') || \Illuminate\Support\Facades\Gate::allows(config('impersonate.gate'))): ?>";
            });

            Blade::directive('endImpersonate', function () {
                return "<?php endif; ?>";
            });

            Blade::directive('impersonateLogout', function () {
                return "<?php if(\Illuminate\Support\Facades\Cookie::has('impersonate_token')): ?>";
            });

            Blade::directive('endImpersonateLogout', function () {
                return "<?php endif; ?>";
            });
        }

        $this->mergeConfigFrom(__DIR__ . '/../../config/impersonate.php', 'impersonate');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/routes.php');
    }
}
