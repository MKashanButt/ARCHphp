<?php

return [
    'default' => env('DB_DRIVER', 'sqlite'),

    'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', '127.0.0.1'),
            'port'      => env('DB_PORT', '3306'),
            'database'  => env('DB_NAME', 'archphp'),
            'username'  => env('DB_USER', 'root'),
            'password'  => env('DB_PASS', ''),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ],
        'sqlite' => [
            'driver'   => 'sqlite',
            'database' => env('DB_NAME', 'database/database.sqlite'),
            'prefix'   => '',
        ],
    ]
];
