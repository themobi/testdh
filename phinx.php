<?php

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__ . '/.env');

return [
    'paths' => [
        'migrations' => __DIR__ . '/resources/migrations',
        'seeds' => __DIR__ . '/resources/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'default',
        'default' => [
            'adapter' => getenv('DB_CONNECTION'),
            'host' => getenv('DB_HOST'),
            'name' => getenv('DB_DATABASE'),
            'user' => getenv('DB_USER'),
            'pass' => getenv('DB_PASSWORD'),
            'port' => getenv('DB_PORT'),
        ],

        /**
        // add more environments here

        // 'production' => [
        //     etc...
        // ]

        // */
    ],
];
