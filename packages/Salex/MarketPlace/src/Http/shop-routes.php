<?php

use Salex\MarketPlace\Http\Controllers\Shop\SaleController;
use Salex\MarketPlace\Http\Controllers\Shop\StoreController;
use Salex\MarketPlace\Http\Controllers\Shop\StoreDashboardController;
use Illuminate\Support\Facades\Route;
use Salex\MarketPlace\Http\Controllers\Shop\ForgotPasswordController;
use Salex\MarketPlace\Http\Controllers\Shop\MerchantController;
use Salex\MarketPlace\Http\Controllers\Shop\RegistrationController;
use Salex\MarketPlace\Http\Controllers\Shop\ResetPasswordController;
use Salex\MarketPlace\Http\Controllers\Shop\SessionController;
use Salex\MarketPlace\Http\Controllers\Shop\InventorySourceController;
use Salex\Marketplace\Http\Controllers\Shop\ShopController;

Route::group([
    'prefix'     => 'merchant',
    'middleware' => ['web', 'theme', 'currency']
], function () {

    Route::get('/', function () {
        return redirect('/merchant/login');
    });

    /**
     * Forgot password routes.
     */
    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->defaults('_config', [
        'view' => 'elegant::merchants.signup.forgot-password',
    ])->name('merchant.forgot-password.create');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('merchant.forgot-password.store');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->defaults('_config', [
        'view' => 'elegant::merchants.signup.reset-password',
    ])->name('merchant.reset-password.create');

    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->defaults('_config', [
        'redirect' => 'customer.profile.index',
    ])->name('merchant.reset-password.store');

    /**
     * Login routes.
     */
    Route::get('login', [SessionController::class, 'show'])->defaults('_config', [
        'view' => 'elegant::merchants.session.index',
    ])->name('merchant.session.index');

    Route::post('login', [SessionController::class, 'create'])->defaults('_config', [
        'redirect' => 'merchant.store.index',
    ])->name('merchant.session.create');

    /**
     * Registration routes.
     */
    Route::get('register', [RegistrationController::class, 'show'])->defaults('_config', [
        'view' => 'elegant::merchants.signup.index',
    ])->name('merchant.register.index');

    Route::post('register', [RegistrationController::class, 'create'])->defaults('_config', [
        'redirect' => 'merchant.session.index',
    ])->name('merchant.register.create');

    /**
     * Customer verification routes.
     */
    Route::get('/verify-account/{token}', [RegistrationController::class, 'verifyAccount'])->name('merchant.verify');

    Route::get('/resend/verification/{email}', [RegistrationController::class, 'resendVerificationEmail'])->name('merchant.resend.verification-email');
});

Route::group([
    'prefix'     => 'merchant/account',
    'middleware' => ['web', 'theme', 'locale', 'currency', 'merchant']
], function () {

    /**
     * Logout.
     */
    Route::delete('logout', [SessionController::class, 'destroy'])->defaults('_config', [
        'redirect' => 'merchant.session.index',
    ])->name('merchant.session.destroy');
    /**
     * Profile.
     */
    Route::get('profile', [MerchantController::class, 'index'])->defaults('_config', [
        'view' => 'elegant::merchants.account.profile.index',
    ])->name('merchant.profile.index');

    Route::get('profile/edit', [MerchantController::class, 'edit'])->defaults('_config', [
        'view' => 'elegant::merchants.account.profile.edit',
    ])->name('merchant.profile.edit');

    Route::post('profile/edit', [MerchantController::class, 'update'])->defaults('_config', [
        'redirect' => 'merchant.profile.index',
    ])->name('merchant.profile.store');

    Route::post('profile/destroy', [MerchantController::class, 'destroy'])->defaults('_config', [
        'redirect' => 'merchant.profile.index',
    ])->name('merchant.profile.destroy');

    Route::get('store/create', [StoreController::class, 'create'])->defaults('_config', [
        'view' => 'elegant::merchants.account.store.create',
    ])->name('merchant.store.create');

    Route::post('store/create', [StoreController::class, 'store'])->defaults('_config', [
        'redirect' => 'merchant.store.index',
    ])->name('merchant.store.store');
});


Route::group([
    'prefix'     => 'merchant/account',
    'middleware' => ['web', 'theme', 'locale', 'currency', 'merchant', 'has-store']
], function () {


    Route::get('store/index', [StoreController::class, 'index'])->defaults('_config', [
        'view' => 'elegant::merchants.account.store.index',
    ])->name('merchant.store.index');

    Route::get('store/dashboard', [StoreDashboardController::class, 'index'])->defaults('_config', [
        'view' => 'elegant::merchants.account.dashboard.index',
    ])->name('merchant.store.dashboard');

    Route::get('store/update', [StoreController::class, 'update'])->defaults('_config', [
        'view' => 'elegant::merchants.account.store.edit',
    ])->name('merchant.store.update');

    Route::put('store/update', [StoreController::class, 'edit'])->defaults('_config', [
        'redirect' => 'merchant.store.index',
    ])->name('merchant.store.edit');

    Route::get('products', [SaleController::class, 'products'])->defaults('_config', [
        'view' => 'elegant::merchants.account.products.index',
    ])->name('merchant.products.index');

    Route::get('products/create', [SaleController::class, 'create_product'])->defaults('_config', [
        'view' => 'elegant::merchants.account.products.create',
    ])->name('merchant.products.create');

    Route::post('products/create', [SaleController::class, 'store_product'])->defaults('_config', [
        'redirect' => 'merchant.products.update',
    ])->name('merchant.products.store');

    Route::get('products/update/{id}', [SaleController::class, 'update_product'])->defaults('_config', [
        'view' => 'elegant::merchants.account.products.edit',
    ])->name('merchant.products.update');

    Route::put('products/update/{id}', [SaleController::class, 'update'])->defaults('_config', [
        'redirect' => 'merchant.products.index',
    ])->name('merchant.products.edit');

    Route::get('products/copy/{id}', [SaleController::class, 'copy'])->defaults('_config', [
        'view' => 'elegant::merchants.account.products.edit',
    ])->name('merchant.products.copy');


    Route::post('products/mass-update', [SaleController::class, 'massUpdate'])->defaults('_config', [
        'redirect' => 'merchant.products.index',
    ])->name('merchant.products.massupdate');


    Route::post('products/mass-delete', [SaleController::class, 'massDestroy'])->defaults('_config', [
        'redirect' => 'merchant.products.index',
    ])->name('merchant.products.massdelete');


    Route::post('products/delete/{id}', [SaleController::class, 'destroy_product'])->defaults('_config', [
        'redirect' => 'merchant.products.index',
    ])->name('merchant.products.delete');


    Route::get('store/sale-orders', [SaleController::class, 'orders'])->defaults('_config', [
        'view' => 'elegant::merchants.account.sale_orders.index',
    ])->name('merchant.sale_orders.index');

    Route::get('store/sale-orders/{id}', [SaleController::class, 'viewOrder'])->defaults('_config', [
        'view' => 'elegant::merchants.account.sale_orders.view',
    ])->name('merchant.sale_orders.view');




    /**
     * Inventory sources routes.
     */
    Route::get('/inventory_sources', [InventorySourceController::class, 'index'])->defaults('_config', [
        'view' => 'elegant::merchants.account.inventory_sources.index',
    ])->name('merchant.inventory_sources.index');

    Route::get('/inventory_sources/create', [InventorySourceController::class, 'create'])->defaults('_config', [
        'view' => 'elegant::merchants.account.inventory_sources.create',
    ])->name('merchant.inventory_sources.create');

    Route::post('/inventory_sources/create', [InventorySourceController::class, 'store'])->defaults('_config', [
        'redirect' => 'merchant.inventory_sources.index',
    ])->name('merchant.inventory_sources.store');

    Route::get('/inventory_sources/edit/{id}', [InventorySourceController::class, 'edit'])->defaults('_config', [
        'view' => 'elegant::merchants.account.inventory_sources.edit',
    ])->name('merchant.inventory_sources.edit');

    Route::post('/inventory_sources/edit/{id}', [InventorySourceController::class, 'update'])->defaults('_config', [
        'redirect' => 'merchant.inventory_sources.index',
    ])->name('merchant.inventory_sources.update');

    Route::post('/inventory_sources/delete/{id}', [InventorySourceController::class, 'destroy'])->name('merchant.inventory_sources.delete');
});




Route::group([
    'prefix'     => 'store',
    'middleware' => ['web', 'theme', 'currency']
], function () {

    Route::get('/{url}', [StoreController::class, 'view'])->defaults('_config', [
        'view' => 'succinct::shop.store.view',
    ])->name('shop.store.view');

    Route::get('/products/{storeId}', [StoreController::class, 'getStoreProducts'])
        ->name('shop.store.products');
});
