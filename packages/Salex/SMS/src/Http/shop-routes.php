<?php

Route::group([
        'prefix'     => 'sms',
        'middleware' => ['web', 'theme', 'locale', 'currency']
    ], function () {

        Route::get('/', 'Salex\SMS\Http\Controllers\Shop\SMSController@index')->defaults('_config', [
            'view' => 'sms::shop.index',
        ])->name('shop.sms.index');

});