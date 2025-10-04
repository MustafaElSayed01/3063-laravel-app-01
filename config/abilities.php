<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Resource Abilities
    |--------------------------------------------------------------------------
    |
    | Define which actions are allowed per resource. Not all resources need to
    | support all actions. Add or remove as your domain requires.
    |
    */
    'resources' => [

        'users' => [
            'viewAny',
            'view',
            'create',
            'update',
            'delete',
            'restore',
            'forceDelete',
        ],

        'posts' => [
            'viewAny',
            'view',
            'create',
            'update',
            'delete',
            'restore',
            'forceDelete',
        ],

        'comments' => [
            'viewAny',
            'view',
            'create',
            'update',
            'delete',
            'restore',
            'forceDelete',
        ],

        'replies' => [
            'viewAny',
            'view',
            'create',
            'update',
            'delete',
            'restore',
            'forceDelete',
        ],

        'reactions' => [
            'viewAny',
            'view',
            'create',
            'update',
            'delete',
            'restore',
            'forceDelete',
        ],

        'post-statuses' => [
            'viewAny',
            'view',
            'create',
            'update',
            'delete',
            'restore',
            'forceDelete',
        ],

        'reaction-types' => [
            'viewAny',
            'view',
            'create',
            'update',
            'delete',
            'restore',
            'forceDelete',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Role → Resource Map
    |--------------------------------------------------------------------------
    |
    | Define which resources each role can interact with.
    | Use '*' to give full access (super admin).
    |
    */
    'roles' => [

        'admin' => [
            '*',
        ],

        'manager' => [
            'users',
            'posts',
            'comments',
            'replies',
        ],

        'user' => [
            'posts',
            'comments',
            'replies',
            'reactions',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Token Type Abilities
    |--------------------------------------------------------------------------
    |
    | Differentiate between web and mobile tokens.
    | - web => full access for role abilities
    | - mobile => limited, view-only access
    |
    */

    'tokens' => [
        'web' => [
            'default' => ['viewAny', 'view', 'create', 'update', 'delete', 'restore', 'forceDelete'],
        ],
        'mobile' => [
            'default' => ['viewAny', 'view'],
        ],
    ],

];
