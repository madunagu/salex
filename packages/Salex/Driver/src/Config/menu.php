<?php

return [
    [
        'key'   => 'driver',
        'name'  => 'driver::app.menu.driver',
        'route' => 'driver.profile.index',
        'sort'  => 1,
    ],     [
        'key'   => 'driver.profile',
        'name'  => 'driver::app.menu.profile',
        'route' => 'driver.profile.index',
        'sort'  => 1,
    ],  [
        'key'   => 'driver.dashboard',
        'name'  => 'driver::app.menu.dashboard',
        'route' => 'driver.dashboard.index',
        'sort'  => 2,
    ],
    [
        'key'   => 'driver.vehicles',
        'name'  => 'driver::app.menu.vehicles',
        'route' => 'driver.vehicles.index',
        'sort'  => 3,
    ],
    [
        'key'   => 'driver.orders',
        'name'  => 'driver::app.menu.shipments',
        'route' => 'driver.shipments.index',
        'sort'  => 4,
    ],
];
