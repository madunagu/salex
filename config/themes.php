<?php

return [
    'default' => 'succinct',

    'themes' => [
        'default' => [
            'views_path' => 'resources/themes/default/views',
            'assets_path' => 'public/themes/default/assets',
            'name' => 'Default'
        ],

        // 'bliss' => [
        //     'views_path' => 'resources/themes/bliss/views',
        //     'assets_path' => 'public/themes/bliss/assets',
        //     'name' => 'Bliss',
        //     'parent' => 'default'
        // ]

        'succinct' => [
            'views_path' => 'resources/themes/succinct/views',
            'assets_path' => 'public/themes/succinct/assets',
            'name' => 'Succinct',
            'parent' => 'velocity'
        ],

        'elegant' => [
            'views_path' => 'resources/themes/elegant/views',
            'assets_path' => 'public/themes/elegant/assets',
            'name' => 'Elegant',
            'parent' => 'default'
        ],

        'velocity' => [
            'views_path' => 'resources/themes/velocity/views',
            'assets_path' => 'public/themes/velocity/assets',
            'name' => 'Velocity',
            'parent' => 'default'
        ],
    ],

    'admin-default' => 'default',

    'admin-themes' => [
        'default' => [
            'views_path' => 'resources/admin-themes/default/views',
            'assets_path' => 'public/admin-themes/default/assets',
            'name' => 'Default'
        ]
    ]
];
