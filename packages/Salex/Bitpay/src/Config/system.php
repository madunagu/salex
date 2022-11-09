<?php

return [
    [
        'key'    => 'sales.paymentmethods.bitpay',
        'name'   => 'Bitpay',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'title',
                'title'         => 'admin::app.admin.system.title',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ],[
                'name'          => 'token',
                'title'         => 'bitpay::app.token',
                'type'          => 'text',
                'channel_based' => false,
                'default_value' => config('app.bitpay.token'),
                'locale_based'  => false,
            ],[
                'name'          => 'merchant_email',
                'title'         => 'bitpay::app.merchant_email',
                'type'          => 'text',
                'channel_based' => true,
                'locale_based'  => false,
            ],  [
                'name'          => 'description',
                'title'         => 'admin::app.admin.system.description',
                'type'          => 'textarea',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'          => 'active',
                'title'         => 'admin::app.admin.system.status',
                'type'          => 'boolean',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ]
        ]
    ]
];