<?php

namespace Salex\Succinct\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
// use Webkul\Velocity\Facades\Velocity as VelocityFacade;

class SuccinctServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        include __DIR__ . '/../Routes/admin-routes.php';

        include __DIR__ . '/../Routes/front-routes.php';

        $this->app->register(EventServiceProvider::class);

        // $this->loadGlobalVariables();

        $this->loadPublishableAssets();

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'succinct');
       
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php',
            'core'
        );

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'succinct');
    }

    /**
     * Register services.
     *
     * @return void
     */
    // public function register()
    // {
    //     $this->registerConfig();

    //     $this->registerFacades();
    // }

    /**
     * Register package config.
     *
     * @return void
     */
    // protected function registerConfig()
    // {
    //     $this->mergeConfigFrom(
    //         dirname(__DIR__) . '/Config/admin-menu.php',
    //         'menu.admin'
    //     );

    //     $this->mergeConfigFrom(
    //         dirname(__DIR__) . '/Config/acl.php',
    //         'acl'
    //     );
    // }

    // /**
    //  * Register Bouncer as a singleton.
    //  *
    //  * @return void
    //  */
    // protected function registerFacades()
    // {
    //     $loader = AliasLoader::getInstance();

    //     $loader->alias('velocity', VelocityFacade::class);
    // }

    /**
     * This method will load all publishables.
     *
     * @return boolean
     */
    private function loadPublishableAssets()
    {
        $this->publishes([
            __DIR__ . '/../../publishable/assets/' => public_path('themes/succinct/assets'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../Resources/views/shop' => resource_path('themes/succinct/views'),
        ]);

        $this->publishes([__DIR__ . '/../Resources/lang' => lang_path('vendor/succinct')]);

        return true;
    }

    /**
     * This method will provide global variables shared by view (blade files).
     *
     * @return boolean
     */
    // private function loadGlobalVariables()
    // {
    //     view()->composer('*', function ($view) {
    //         $velocityHelper = app(\Webkul\Velocity\Helpers\Helper::class);

    //         $view->with('showRecentlyViewed', true);
    //         $view->with('velocityHelper', $velocityHelper);
    //         $view->with('velocityMetaData', $velocityHelper->getVelocityMetaData());
    //     });

    //     return true;
    // }
}
