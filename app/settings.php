<?php
return [
    'settings' => [
        'debug' => true,
        'displayErrorDetails' => true,
        'setLoggerDB' => false,
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
            'twig' => [
                'cache' => __DIR__ . '/../var/cache/twig',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],
        'db' => [
            "driver" => 'pgsql',
            "host" => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            "username" => $_ENV['DB_USERNAME'],
            "password" => $_ENV['DB_PSW'],
            'database' => $_ENV['DB_DATABASE'],
            'timezone' => 'Europe/Moscow',
            'charset' => 'utf8',
            'schema' => $_ENV['DB_SCHEMA'],
        ],
        'session' => [
            'name'=>'acs',
        ],
   ],
];

