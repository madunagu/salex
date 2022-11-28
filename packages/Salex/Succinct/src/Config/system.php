<?php

return [
    [
        'key'  => 'general',
        'name' => 'admin::app.admin.system.general',
        'sort' => 1,
    ], [
        'key'  => 'general.general',
        'name' => 'admin::app.admin.system.general',
        'sort' => 1,
    ], [
        'key'    => 'general.general.phone',
        'name'   => 'succinct::app.admin.system.general.support-phone',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'phone',
                'title'         => 'succinct::app.admin.system.general.support-phone',
                'type'          => 'text',
                'channel_based' => true,

                // 'info'          => 'sms::app.sms77.sender-id-tip',
                'validation'    => 'required|max:16',
                'sort' => 1,
                'default_value' => '(+503)7492-4277',
       
            ],
        ],

    ],
];
