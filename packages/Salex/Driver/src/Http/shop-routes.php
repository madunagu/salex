<?php

use Illuminate\Support\Facades\Route;
use Salex\Driver\Http\Controllers\Shop\ForgotPasswordController;
use Salex\Driver\Http\Controllers\Shop\RegistrationController;
use Salex\Driver\Http\Controllers\Shop\ResetPasswordController;
use Salex\Driver\Http\Controllers\Shop\SessionController;
use Salex\Driver\Http\Controllers\Shop\DriverController;
use Salex\Driver\Http\Controllers\Shop\VehicleController;
use Salex\Driver\Http\Controllers\Shop\ShipmentController;
use Salex\Driver\Http\Controllers\Shop\DriverShipmentController;
use Salex\Driver\Http\Controllers\Shop\DriverDashboardController;
use Salex\Driver\Http\Controllers\Shop\AddressController;

Route::group([
    'prefix'     => 'driver',
    'middleware' => ['web', 'theme', 'locale', 'currency']
], function () {

    // Route::get('/', 'Salex\Driver\Http\Controllers\Shop\DriverController@index')->defaults('_config', [
    //     'view' => 'elegant::shop.index',
    // ])->name('shop.driver.index');

    Route::get('/', function () {
        return redirect('/driver/login');
    });
    /**
     * Forgot password routes.
     */
    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->defaults('_config', [
        'view' => 'elegant::drivers.signup.forgot-password',
    ])->name('driver.forgot-password.create');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('driver.forgot-password.store');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->defaults('_config', [
        'view' => 'elegant::drivers.signup.reset-password',
    ])->name('driver.reset-password.create');

    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->defaults('_config', [
        'redirect' => 'driver.profile.index',
    ])->name('driver.reset-password.store');

    /**
     * Login routes.
     */
    Route::get('login', [SessionController::class, 'show'])->defaults('_config', [
        'view' => 'elegant::drivers.session.index',
    ])->name('driver.session.index');

    Route::post('login', [SessionController::class, 'create'])->defaults('_config', [
        'redirect' => 'driver.profile.index',
    ])->name('driver.session.create');

    /**
     * Registration routes.
     */
    Route::get('register', [RegistrationController::class, 'show'])->defaults('_config', [
        'view' => 'elegant::drivers.signup.index',
    ])->name('driver.register.index');

    Route::post('register', [RegistrationController::class, 'create'])->defaults('_config', [
        'redirect' => 'merchant.session.index',
    ])->name('driver.register.create');

    /**
     * Customer verification routes.
     */
    Route::get('/verify-account/{token}', [RegistrationController::class, 'verifyAccount'])->name('driver.verify');

    Route::get('/resend/verification/{email}', [RegistrationController::class, 'resendVerificationEmail'])->name('driver.resend.verification-email');
});



Route::group([
    'prefix'     => 'driver/account',
    'middleware' => ['web', 'theme', 'locale', 'currency', 'driver']
], function () {
    /**
     * Logout.
     */
    Route::delete('logout', [SessionController::class, 'destroy'])->defaults('_config', [
        'redirect' => 'driver.session.index',
    ])->name('driver.session.destroy');
    /**
     * Profile.
     */
    Route::get('profile', [DriverController::class, 'index'])->defaults('_config', [
        'view' => 'elegant::drivers.account.profile.index',
    ])->name('driver.profile.index');

    Route::get('profile/edit', [DriverController::class, 'edit'])->defaults('_config', [
        'view' => 'elegant::drivers.account.profile.edit',
    ])->name('driver.profile.edit');

    Route::post('profile/edit', [DriverController::class, 'update'])->defaults('_config', [
        'redirect' => 'driver.profile.index',
    ])->name('driver.profile.store');

    Route::post('profile/destroy', [DriverController::class, 'destroy'])->defaults('_config', [
        'redirect' => 'driver.profile.index',
    ])->name('driver.profile.destroy');


    Route::get('vehicles/index', [VehicleController::class, 'index'])->defaults('_config', [
        'view' => 'elegant::drivers.account.vehicles.index',
    ])->name('driver.vehicles.index');


    Route::get('vehicles/create', [VehicleController::class, 'create'])->defaults('_config', [
        'view' => 'elegant::drivers.account.vehicles.create',
    ])->name('driver.vehicles.create');


    Route::post('vehicles/create', [VehicleController::class, 'store'])->defaults('_config', [
        'redirect' => 'driver.vehicles.index',
    ])->name('driver.vehicles.store');

    Route::get('vehicles/{id}', [VehicleController::class, 'edit'])->defaults('_config', [
        'view' => 'elegant::drivers.account.vehicles.edit',
    ])->name('driver.vehicles.edit');

    Route::put('vehicles/{id}', [VehicleController::class, 'update'])->defaults('_config', [
        'redirect' => 'driver.vehicles.index',
    ])->name('driver.vehicles.update');

    Route::post('vehicles/{id}/delete', [VehicleController::class, 'destroy'])->defaults('_config', [
        'redirect' => 'driver.vehicles.index',
    ])->name('driver.vehicles.delete');

    Route::get('/dashboard', [DriverDashboardController::class, 'index'])->defaults('_config', [
        'view' => 'elegant::drivers.account.dashboard.index',
    ])->name('driver.dashboard.index');

    Route::get('shipments', [DriverShipmentController::class, 'index'])->defaults('_config', [
        'view' => 'elegant::drivers.account.shipments.index',
    ])->name('driver.shipments.index');

    Route::post('shipments/mass-update', [DriverShipmentController::class, 'massUpdate'])->defaults('_config', [
        'redirect' => 'driver.shipments.index',
    ])->name('driver.shipments.massupdate');

    Route::get('shipments/{id}', [DriverShipmentController::class, 'view'])->defaults('_config', [
        'view' => 'elegant::drivers.account.shipments.view',
    ])->name('driver.shipments.view');


    Route::post('shipments/{id}', [DriverShipmentController::class, 'destroy'])->defaults('_config', [
        'redirect' => 'driver.shipments.index',
    ])->name('driver.shipments.cancel');
});



// Route::group([
//     'prefix'     => 'account',
//     'middleware' => ['web', 'theme', 'locale', 'currency', 'customer']
// ], function () {
//     Route::post('addresses/create', [AddressController::class, 'store'])->defaults('_config', [
//         'view'     => 'shop::customers.account.address.address',
//         'redirect' => 'customer.address.index',
//     ])->name('customer.address.store');
// });
