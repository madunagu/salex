<?php

use Illuminate\Support\Facades\Route;
use Salex\Binance\Http\Controllers\BinanceController;

Route::group(['middleware' => ['web'], 'prefix' => 'binance'], function () {
    Route::get('/create-order', [BinanceController::class, 'createOrder'])->name('binance.qrcode.create-order');

    Route::post('/capture-order', [BinanceController::class, 'captureOrder'])->name('binance.qrcode.capture-order');
});
