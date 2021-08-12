<?php

return [
    'librarian' => [
        'App\\Models\\Author' => [
            'view',
            'view-not-approved',
            'create',
            'update',
            'delete',
            'approve'
        ],
        'App\\Models\\Book' => [
            'view',
            'view-not-approved',
            'create',
            'update',
            'delete',
            'approve',
            'filter',
        ],
        'App\\Models\\Cathegory' => [
            'view',
            'view-not-approved',
            'create',
            'update',
            'delete',
            'approve'
        ],
        'App\\Models\\Publisher' => [
            'view',
            'view-not-approved',
            'create',
            'update',
            'delete',
            'approve'
        ],
        'App\\Models\\Tag' => [
            'view',
            'view-not-approved',
            'create',
            'update',
            'delete',
            'approve'
        ],
        'App\\Models\\User' => [
            'view',
            'update',
            'delete',
            'ban',
            'unban'
        ]
    ],
    'reader' => [
        'App\\Models\\Author' => [
            'view',
            'create',
        ],
        'App\\Models\\Book' => [
            'view',
            'create',
            'filter'
        ],
        'App\\Models\\Publisher' => [
            'view',
            'create',
        ],
        'App\\Models\\Cathegory' => [
            'view',
            'create',
        ],
        'App\\Models\\Tag' => [
            'view',
            'create',
        ],
        'App\\Models\\User' => [
            'view',
        ]
    ],
    'banned' => [
        'App\\Models\\Author' => [
            'view',
        ],
        'App\\Models\\Book' => [
            'view',
            'filter'
        ],
        'App\\Models\\Publisher' => [
            'view',
        ],
        'App\\Models\\Cathegory' => [
            'view',
        ],
        'App\\Models\\Tag' => [
            'view',
        ],
    ],
];