<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
// This is Use For Admin And Employee
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
// This is Use For Patient
        'patient' => [
            'driver' => 'session',
            'provider' => 'patients',
        ],
    ],

    'providers' => [
// this is Default User Table Name (admin,employee)
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
// This is Patient Table Name
        'patients' => [
            'driver' => 'eloquent',
            'model' => App\Models\Patient::class,
        ],
    ],

    // This is Use For Reset Password
    'passwords' => [

        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'patients' => [
            'provider' => 'patients',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
