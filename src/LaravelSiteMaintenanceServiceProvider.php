<?php

namespace GrimReapper\LaravelSiteMaintenance;

use Illuminate\Support\ServiceProvider;

class LaravelSiteMaintenanceServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/maintenance.php','grimreapper'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->registerConfig();
        $this->registerViews();
        $this->registerTranslations();
        $this->registerAssets();
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../config/maintenance.php' => config_path('maintenance.php'),
        ], 'config');
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/grimreapper');

        $sourcePath = __DIR__.'/resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'grimreapper.views');

        $this->loadViewsFrom(__DIR__.'/resources/views', 'grimreapper');
    }

    public function registerTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/resources/lang','grimreapper');
    }

    protected function registerAssets()
    {
        if($this->app->runningInConsole()){
            $path = 'vendor/grimreapper/js';
            $this->publishes([
                __DIR__.'/resources/assets/js' => public_path($path)
            ], 'grimreapper');
        }
    }
}
