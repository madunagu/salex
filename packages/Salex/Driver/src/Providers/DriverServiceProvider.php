<?php

namespace Salex\Driver\Providers;


use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Salex\Driver\Contracts\Driver as DriverContract;
use Salex\Driver\Contracts\Vehicle as VehicleContract;
use Salex\Driver\Models\Driver;
use Salex\Driver\Models\Vehicle;
use Salex\Driver\Http\Middleware\RedirectIfNotDriver;
use Salex\Driver\Repositories\DriverRepository;
use Webkul\Core\Tree;

class DriverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->aliasMiddleware('driver', RedirectIfNotDriver::class);

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Http/admin-routes.php');

        $this->loadRoutesFrom(__DIR__ . '/../Http/shop-routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'driver');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('themes/default/assets'),
        ], 'public');

        /* view composers */
        $this->composeView();
        $this->app->register(ModuleServiceProvider::class);

        // $this->app->concord->registerModel(
        //     \Webkul\Customer\Contracts\CustomerAddress::class, \Salex\Driver\Models\CustomerAddress::class
        // );
        // $this->app->concord->registerModel(
        //   \Salex\Driver\Http\Requests\CustomerAddressRequest::class,  \Webkul\Customer\Http\Requests\CustomerAddressRequest::class, 
        // );

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'driver');

        // Event::listen('bagisto.admin.layout.head', function($viewRenderEventManager) {
        //     $viewRenderEventManager->addTemplate('driver::admin.layouts.style');
        // });
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

    /* Bind the the data to the views.
    *
    * @return void
    */
    protected function composeView()
    {
        view()->composer(['elegant::drivers.account.partials.sidemenu','succinct::drivers.account.partials.sidemenu'], function ($view) {
            $tree = Tree::create();

            foreach (config('menu.driver') as $item) {
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
            dirname(__DIR__) . '/Config/admin-menu.php',
            'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php',
            'acl'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php',
            'menu.driver'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php',
            'core'
        );

        // $this->app->bind(DriverContract::class, Driver::class);
        // $this->app->bind(VehicleContract::class, Vehicle::class);
    }
}
