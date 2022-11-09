<?php

use Illuminate\Support\Facades\Route;
use Salex\Bitpay\Http\Controllers\BitpayController;


Route::group(['middleware' => ['web']], function () {
    Route::prefix('bitpay')->group(function () {
        Route::get('/redirect', [BitpayController::class, 'redirect'])->name('bitpay.redirect');

        Route::get('/success', [BitpayController::class, 'success'])->name('bitpay.success');

        Route::get('/cancel', [BitpayController::class, 'cancel'])->name('bitpay.cancel');
    });

    // Route::prefix('paypal/smart-button')->group(function () {
    //     Route::get('/create-order', [SmartButtonController::class, 'createOrder'])->name('paypal.smart-button.create-order');

    //     Route::post('/capture-order', [SmartButtonController::class, 'captureOrder'])->name('paypal.smart-button.capture-order');
    // });
});

Route::post('bitpay/ipn', [BitpayController::class, 'ipn'])
    ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
    ->name('bitpay.ipn');
