<?php

Route::group([
    'prefix'        => 'admin/marketplace',
    'middleware'    => ['web', 'admin','locale']
], function () {
    Route::get('', 'Salex\MarketPlace\Http\Controllers\Admin\MarketPlaceController@index')->defaults('_config', [
        'view' => 'marketplace::admin.index',
    ])->name('admin.marketplace.index');

    Route::get('/sellers', 'Salex\MarketPlace\Http\Controllers\Admin\MarketPlaceController@seller')->defaults('_config', [
        'view' => 'marketplace::admin.seller.index',
    ])->name('admin.sales.sellers.index');

    Route::get('/stores', 'Salex\MarketPlace\Http\Controllers\Admin\StoreController@index')->defaults('_config', [
        'view' => 'marketplace::admin.stores.index',
    ])->name('admin.sales.stores.index');

    Route::get('/stores/create', 'Salex\MarketPlace\Http\Controllers\Admin\StoreController@create')->defaults('_config', [
        'view' => 'marketplace::admin.stores.create',
    ])->name('admin.sales.stores.create');

    Route::get('/stores/{id}', 'Salex\MarketPlace\Http\Controllers\Admin\StoreController@edit')->defaults('_config', [
        'view' => 'marketplace::admin.stores.edit',
    ])->name('admin.sales.stores.edit');

    Route::post('/sellers/create', 'Salex\MarketPlace\Http\Controllers\Admin\StoreController@store')->defaults('_config', [
        'redirect' => 'admin.sales.stores.index',
    ])->name('admin.sales.stores.store');

    Route::post('/stores/{id}', 'Salex\MarketPlace\Http\Controllers\Admin\StoreController@update')->defaults('_config', [
        'redirect' => 'admin.sales.stores.index',
    ])->name('admin.sales.stores.update');

    // Route::post('sellers/{id}', 'Salex\MarketPlace\Http\Controllers\Admin\MarketPlaceController@delete')->defaults('_config', [
    //     'redirect' => 'admin.sales.sellers.index',
    // ])->name('admin.sales.sellers.delete');

    Route::post('/sellers/mass-update', 'Salex\MarketPlace\Http\Controllers\Admin\MarketPlaceController@massUpdate')->defaults('_config', [
        'redirect' => 'admin.sales.sellers.index',
    ])->name('admin.sales.sellers.mass-update');

    Route::post('/sellers/mass-destroy', 'Salex\MarketPlace\Http\Controllers\Admin\MarketPlaceController@massDestroy')->defaults('_config', [
        'redirect' => 'admin.sales.sellers.index',
    ])->name('admin.sales.sellers.mass-destroy');
});
