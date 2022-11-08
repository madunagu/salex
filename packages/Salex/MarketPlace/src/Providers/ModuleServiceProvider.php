<?php

namespace Salex\MarketPlace\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
      
        \Salex\MarketPlace\Models\Merchant::class,
        \Salex\MarketPlace\Models\Store::class,
        \Salex\MarketPlace\Models\Seller::class,
        \Salex\MarketPlace\Models\StoreCategory::class,
        \Salex\MarketPlace\Models\StoreImage::class,
        \Salex\MarketPlace\Models\StoreTranslation::class,
    ];
}