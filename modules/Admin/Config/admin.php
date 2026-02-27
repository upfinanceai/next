<?php
return [
    'domain' => env("ADMIN_DOMAIN"),
    'permissions' => [
        'accounts'  => [
            'list',
            'create',
            'edit',
            'delete',
            'view',
            'suspend',
            'transfer',
            'exchange',
        ],
        'customers' => [
            'list',
            'view',
            'create',
            'edit',
            'delete',
        ],
    ],
];
