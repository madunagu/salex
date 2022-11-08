<?php

return [
    [
        'key'   => 'marketplace',
        'name'  => 'marketplace::app.marketplace',
        'route' => 'merchant.store.index',
        'sort'  => 1,
    ],     [
        'key'   => 'marketplace.profile',
        'name'  => 'marketplace::app.store.profile',
        'route' => 'merchant.profile.index',
        'sort'  => 1,
    ],  [
        'key'   => 'marketplace.store',
        'name'  => 'marketplace::app.store.store',
        'route' => 'merchant.store.index',
        'sort'  => 2,
    ],  [
        'key'   => 'marketplace.dashboard',
        'name'  => 'marketplace::app.store.dashboard',
        'route' => 'merchant.store.dashboard',
        'sort'  => 1,
    ],
    [
        'key'   => 'marketplace.products',
        'name'  => 'marketplace::app.products.products',
        'route' => 'merchant.products.index',
        'sort'  => 3,
    ],
    [
        'key'   => 'marketplace.orders',
        'name'  => 'marketplace::app.orders.sale-orders',
        'route' => 'merchant.sale_orders.index',
        'sort'  => 4,
    ],
    [
        'key'   => 'marketplace.inventory_sources',
        'name'  => 'marketplace::app.inventory-sources',
        'route' => 'merchant.inventory_sources.index',
        'sort'  => 5,
    ],
];
