<?php

Route::group([
        'prefix'        => 'admin/driver',
        'middleware'    => ['web', 'admin']
    ], function () {

        Route::get('/index', 'Salex\Driver\Http\Controllers\Admin\DriverController@index')->defaults('_config', [
            'view' => 'driver::admin.drivers.index',
        ])->name('admin.driver.index');

        Route::get('/dashboard',  'Salex\Driver\Http\Controllers\Admin\ShipmentDashboardController@index')->defaults('_config', [
            'view' => 'driver::admin.drivers.dashboard.index',
        ])->name('admin.driver.dashboard');

        Route::get('/create', 'Salex\Driver\Http\Controllers\Admin\DriverController@create')->defaults('_config', [
            'view' => 'driver::admin.drivers.create',
        ])->name('admin.driver.create');

        Route::post('/create', 'Salex\Driver\Http\Controllers\Admin\DriverController@store')->defaults('_config', [
            'redirect' => 'admin.driver.index',
        ])->name('admin.driver.store');

        Route::get('/edit/{id}', 'Salex\Driver\Http\Controllers\Admin\DriverController@edit')->defaults('_config', [
            'view' => 'driver::admin.drivers.edit',
        ])->name('admin.driver.edit');

        Route::get('/edit/{id}/shipments',  'Salex\Driver\Http\Controllers\Admin\DriverController@edit')->defaults('_config', [
            'view' => 'driver::admin.drivers.edit',
        ])->name('admin.driver.shipments.data');

        Route::post('/update/{id}', 'Salex\Driver\Http\Controllers\Admin\DriverController@update')->defaults('_config', [
            'redirect' => 'admin.driver.index',
        ])->name('admin.driver.update');

        Route::post('/mass-destroy', 'Salex\Driver\Http\Controllers\Admin\DriverController@massDestroy')->defaults('_config', [
            'redirect' => 'admin.driver.index',
        ])->name('admin.driver.mass-destroy');

        Route::post('/mass-update', 'Salex\Driver\Http\Controllers\Admin\DriverController@massUpdate')->defaults('_config', [
            'redirect' => 'admin.driver.index',
        ])->name('admin.driver.mass-update');

        Route::get('/{id}/vehicles/create', 'Salex\Driver\Http\Controllers\Admin\VehicleController@create')->defaults('_config', [
            'view' => 'driver::admin.drivers.vehicles.create',
        ])->name('admin.driver.vehicles.create');

        Route::post('/{id}/vehicles/create', 'Salex\Driver\Http\Controllers\Admin\VehicleController@store')->defaults('_config', [
            'redirect' => 'admin.driver.index',
        ])->name('admin.driver.vehicles.store');

        Route::get('/driver/vehicles/{id}', 'Salex\Driver\Http\Controllers\Admin\VehicleController@edit')->defaults('_config', [
            'view' => 'driver::admin.drivers.vehicles.edit',
        ])->name('admin.driver.vehicles.edit');

        Route::post('/driver/vehicles/{id}', 'Salex\Driver\Http\Controllers\Admin\VehicleController@update')->defaults('_config', [
            'redirect' => 'admin.driver.index',
        ])->name('admin.driver.vehicles.update');

        Route::post('/driver/vehicles/{id}/destroy', 'Salex\Driver\Http\Controllers\Admin\VehicleController@destroy')->defaults('_config', [
            'redirect' => 'admin.driver.index',
        ])->name('admin.driver.vehicles.delete');

        Route::post('/{id}/vehicles/mass-destroy', 'Salex\Driver\Http\Controllers\Admin\VehicleController@massDestroy')->defaults('_config', [
            'redirect' => 'admin.driver.index',
        ])->name('admin.driver.vehicles.mass-destroy');

        Route::get('/{id}/vehicles',  'Salex\Driver\Http\Controllers\Admin\VehicleController@index')->defaults('_config', [
            'view' => 'driver::admin.drivers.vehicles.index',
        ])->name('admin.driver.vehicles.index');
    
        Route::get('/shipments',  'Salex\Driver\Http\Controllers\Admin\ShipmentController@index')->defaults('_config', [
            'view' => 'driver::admin.shipments.index',
        ])->name('admin.shipments.index');

        Route::post('/shipments/mass-assign', 'Salex\Driver\Http\Controllers\Admin\ShipmentController@massAssign')->defaults('_config', [
            'redirect' => 'admin.shipments.index',
        ])->name('admin.shipments.mass-assign');
});