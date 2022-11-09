<?php

namespace Salex\Bitpay\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Webkul\Theme\ViewRenderEventManager;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Event::listen('bagisto.shop.layout.body.after', static function (ViewRenderEventManager $viewRenderEventManager) {
        //     $viewRenderEventManager->addTemplate('binance::checkout.onepage.qr-scan');
        // });

        Event::listen('sales.invoice.save.after', 'Salex\Bitpay\Listeners\Transaction@saveTransaction');
    }
}
