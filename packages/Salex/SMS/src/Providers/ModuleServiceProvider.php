<?php

namespace Salex\SMS\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Salex\SMS\Models\SMS::class,
    ];
}