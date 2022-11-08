<?php

namespace Salex\Elegant\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class ElegantServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'elegant');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('themes/elegant/assets'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../Resources/views' => resource_path('themes/elegant/views'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'elegant');

        // Event::listen('bagisto.admin.layout.head', function($viewRenderEventManager) {
        //     $viewRenderEventManager->addTemplate('elegant::admin.layouts.style');
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

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
    }
}