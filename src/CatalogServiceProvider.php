<?php

namespace Dekmabot\Catalog;

use Dekmabot\Catalog\app\ViewComposers\CatalogComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        
        $this->loadRoutesFrom(__DIR__ . '/routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/public.php');
        
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'dekmabot_catalog');
        
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'catalog');
        
        $this->publishes([
            __DIR__ . '/config/pagemanager.php' => config_path('backpack/pagemanager.php'),
        ]);
        $this->publishes([
            __DIR__ . '/resources/lang' => resource_path('lang/vendor/catalog'),
        ], 'lang');
        
        View::composer('*', CatalogComposer::class);
    }
    
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
