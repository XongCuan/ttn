<?php

return [
    'auth.guards.admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
    'auth.providers.admins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],
    'auth.passwords.admins' => [
        'provider' => 'admins',
        'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
        'expire' => 60,
        'throttle' => 60,
    ]
];