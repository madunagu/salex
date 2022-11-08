<?php

namespace Salex\Succinct\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen([
            'bagisto.admin.catalog.category.edit_form_accordian.description_images.controls.after',
            'bagisto.admin.catalog.category.create_form_accordian.description_images.controls.after',
        ], function($viewRenderEventManager) {
                $viewRenderEventManager->addTemplate(
                    'succinct::admin.catelog.categories.category-icon'
                );
            }
        );

        Event::listen([
            'bagisto.admin.settings.slider.edit.after',
            'bagisto.admin.settings.slider.create.after',
        ], function($viewRenderEventManager) {
                $viewRenderEventManager->addTemplate(
                    'succinct::admin.settings.sliders.velocity-slider'
                );
            }
        );

        // Event::listen('bagisto.admin.layout.head', function($viewRenderEventManager) {
        //     $viewRenderEventManager->addTemplate('succinct::admin.layouts.style');
        // });

    }
}
