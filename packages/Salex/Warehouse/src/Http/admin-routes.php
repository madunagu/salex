<?php

Route::group([
        'prefix'        => 'admin/warehouse',
        'middleware'    => ['web', 'admin']
    ], function () {

        Route::get('', 'Salex\Warehouse\Http\Controllers\Admin\WarehouseController@index')->defaults('_config', [
            'view' => 'warehouse::admin.index',
        ])->name('admin.warehouse.index');

});