<?php

namespace Salex\MarketPlace\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Routing\Router;
use Salex\MarketPlace\Http\Middleware\RedirectIfNotMerchant;
use Webkul\Core\Tree;

class MarketPlaceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->aliasMiddleware('merchant', RedirectIfNotMerchant::class);

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Http/admin-routes.php');

        $this->loadRoutesFrom(__DIR__ . '/../Http/shop-routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'marketplace');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('themes/default/assets'),
        ], 'public');
                /* view composers */
        $this->composeView();

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'marketplace');

        $this->app->register(ModuleServiceProvider::class);

        Event::listen('bagisto.admin.layout.head', function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('marketplace::admin.layouts.style');
        });




    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }


    /**
     * Bind the the data to the views.
     *
     * @return void
     */
    protected function composeView()
    {
        view()->composer(['elegant::merchants.account.products.create'], function ($view) {
            $items = array();

            foreach (config('product_types') as $item) {
                $item['children'] = [];

                array_push($items, $item);
            }

            $types = core()->sortItems($items);

            $view->with('productTypes', $types);
        });

        view()->composer('elegant::merchants.account.partials.sidemenu', function ($view) {
            $tree = Tree::create();

            foreach (config('menu.merchant') as $item) {
                $tree->add($item, 'menu');
            }
            $tree->items = core()->sortItems($tree->items);

            $view->with('menu', $tree);
        });
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php', 'menu.merchant'
        );


        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php', 'acl'
        );
    }
}