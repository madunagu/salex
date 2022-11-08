<?php

return [
    [
        'key'  => 'sms',
        'name' => 'sms::app.sms.sms',
        'sort' => 1,
    ], [
        'key'  => 'sms.sms77',
        'name' => 'sms::app.sms77.settings',
        'sort' => 1,
    ], [
        'key'    => 'sms.sms77.config',
        'name'   => 'sms::app.sms77.settings',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'sender_id',
                'title'         => 'sms::app.sms77.sender-id',
                'type'          => 'text',
                'info'          => 'sms::app.sms77.sender-id-tip',
                'validation'    => 'required|max:11',
                'channel_based' => true,
                'sort' => 1,
                'default_value' => config('app.sms.sms77.config.sender_id'),
            ], [
                'name'          => 'api_key',
                'title'         => 'sms::app.sms77.api-key',
                'type'          => 'text',
                'info'          => 'sms::app.sms77.api-key-tip',
                'validation'    => 'required',
                'channel_based' => true,
                'sort' => 2,
                'default_value' => config('app.sms.sms77.config.api_key'),
            ],
        ],
    ],
    [
        'key'  => 'sms.twilio',
        'name' => 'sms::app.twilio.settings',
        'sort' => 1,
    ],
    [
        'key'    => 'sms.twilio.config',
        'name'   => 'sms::app.twilio.settings',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'sid',
                'title'         => 'sms::app.twilio.sid',
                'type'          => 'text',
                'info'          => 'sms::app.twilio.sid-tip',
                'validation'    => 'required',
                'channel_based' => true,
                'sort' => 1,
                'default_value' => config('app.sms.twilio.config.sid'),
            ],   [
                'name'          => 'token',
                'title'         => 'sms::app.twilio.token',
                'type'          => 'text',
                'info'          => 'sms::app.twilio.token-tip',
                'validation'    => 'required',
                'channel_based' => true,
                'sort' => 2,
                'default_value' => config('app.sms.twilio.config.token'),
            ],   [
                'name'          => 'ms_id',
                'title'         => 'sms::app.twilio.ms-id',
                'type'          => 'text',
                'info'          => 'sms::app.twilio.ms-id-tip',
                'validation'    => 'required',
                'channel_based' => true,
                'sort' => 3,
                'default_value' => config('app.sms.twilio.config.ms_id'),
            ],
        ],
    ],  [
        'key'  => 'sms.general',
        'name' => 'admin::app.admin.emails.notification_label',
        'sort' => 1,
    ], [
        'key'    => 'sms.general.notifications',
        'name'   => 'admin::app.admin.emails.notification_label',
        'sort'   => 1,
        'fields' => [
            [
                'name'  => 'sms.general.notifications.new-order',
                'title' => 'sms::app.notifications.new-order',
                'type'  => 'boolean',
            ],
            [
                'name'  => 'sms.general.notifications.new-invoice',
                'title' => 'sms::app.notifications.new-invoice',
                'type'  => 'boolean',
            ],
            [
                'name'  => 'sms.general.notifications.new-shipment',
                'title' => 'sms::app.notifications.new-shipment',
                'type'  => 'boolean',
            ],
            [
                'name'  => 'sms.general.notifications.cancel-order',
                'title' => 'sms::app.notifications.cancel-order',
                'type'  => 'boolean',
            ],
        ],
    ]
];
