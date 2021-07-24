<?php

return [
    'librarian' => [
        'App\\Models\\Author' => [
            'view',
            'view-any',
            'create',
            'update',
            'delete',
            'approve',
            'view-not-approved',
            'update-any',
            'delete-any'
        ],
        'App\\Models\\Book' => [
            'view',
            'view-any',
            'create',
            'update',
            'delete',
            'approve',
            'filter',
            'view-not-approved',
            'update-any',
            'delete-any'
        ],
        'App\\Models\\Cathegory' => [
            'view',
            'view-any',
            'create',
            'update',
            'delete',
            'approve',
            'view-not-approved',
            'update-any',
            'delete-any'
        ],
        'App\\Models\\Publisher' => [
            'view',
            'view-any',
            'create',
            'update',
            'delete',
            'approve',
            'view-not-approved',
            'update-any',
            'delete-any'
        ],
        'App\\Models\\Tag' => [
            'view',
            'view-any',
            'create',
            'update',
            'delete',
            'approve',
            'view-not-approved',
            'update-any',
            'delete-any'
        ],
    ],
    'reader' => [
        'App\\Models\\Author' => [
            'view',
            'view-any',
            'create',
        ],
        'App\\Models\\Book' => [
            'view',
            'view-any',
            'create',
            'update',
            'delete',
            'approve',
            'filter'
        ],
        'App\\Models\\Publisher' => [
            'view',
            'view-any',
            'create',
        ],
        'App\\Models\\Cathegory' => [
            'view',
            'view-any',
            'create',
        ],
        'App\\Models\\Tag' => [
            'view',
            'view-any',
            'create',
        ],
    ]
];