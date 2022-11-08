<?php

return [
    'defaults' => [
        'guard'     => 'customer',
        'passwords' => 'customers',
    ],

    'guards' => [
        'customer' => [
            'driver'   => 'session',
            'provider' => 'customers',
        ],

        'admin' => [
            'driver'   => 'session',
            'provider' => 'admins',
        ],

        'merchant' => [
            'driver'   => 'session',
            'provider' => 'merchants',
        ],

        'driver' => [
            'driver'   => 'session',
            'provider' => 'logistics',
        ],

        'api' => [
            'driver'   => 'jwt',
            'provider' => 'customers',
        ],

        'admin-api' => [
            'driver'   => 'jwt',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'customers' => [
            'driver' => 'eloquent',
            'model'  => Webkul\Customer\Models\Customer::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model'  => Webkul\User\Models\Admin::class,
        ],

        'logistics' => [
            'driver' => 'eloquent',
            'model'  => Salex\Driver\Models\Driver::class,
        ],

        'merchants' => [
            'driver' => 'eloquent',
            'model'  => Salex\MarketPlace\Models\Merchant::class,
        ],
    ],

    'passwords' => [
        'customers' => [
            'provider' => 'customers',
            'table'    => 'customer_password_resets',
            'expire'   => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table'    => 'admin_password_resets',
            'expire'   => 60,
            'throttle' => 60,
        ],

        'drivers' => [
            'provider' => 'logistics',
            'table'    => 'driver_password_resets',
            'expire'   => 60,
            'throttle' => 60,
        ],

        'merchants' => [
            'provider' => 'merchants',
            'table'    => 'merchant_password_resets',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],
];
