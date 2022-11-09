<?php

use Illuminate\Support\Facades\Route;
use Salex\Bitpay\Http\Controllers\BitpayController;

Route::group(['middleware' => ['web'], 'prefix' => 'bitpay'], function () {
    Route::get('/create-order', [BitpayController::class, 'createOrder'])->name('binance.qrcode.create-order');

    Route::post('/capture-order', [BitpayController::class, 'captureOrder'])->name('binance.qrcode.capture-order');
});
