<?php

Route::group([
        'prefix'        => 'admin/sms',
        'middleware'    => ['web', 'admin']
    ], function () {

        Route::get('dashboard', 'Salex\SMS\Http\Controllers\Admin\SMSController@dashboard')->defaults('_config', [
            'view' => 'sms::admin.dashboard.index',
        ])->name('admin.sms.dashboard');

        Route::get('list', 'Salex\SMS\Http\Controllers\Admin\SMSController@index')->defaults('_config', [
            'view' => 'sms::admin.index',
        ])->name('admin.sms.index');

});