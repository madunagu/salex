<?php

namespace Salex\Driver\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Salex\Driver\Models\Driver::class,
        \Salex\Driver\Models\Vehicle::class,
    ];
}