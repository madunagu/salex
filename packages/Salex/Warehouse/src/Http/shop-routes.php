<?php

Route::group([
        'prefix'     => 'warehouse',
        'middleware' => ['web', 'theme', 'locale', 'currency']
    ], function () {

        Route::get('/', 'Salex\Warehouse\Http\Controllers\Shop\WarehouseController@index')->defaults('_config', [
            'view' => 'warehouse::shop.index',
        ])->name('shop.warehouse.index');

});
