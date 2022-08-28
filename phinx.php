<?php
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__));
$dotenv->safeLoad();

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
        ],
        'migration_base_class' => 'App\Migration\Migration',
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_environment' => 'development',
            'development' => [
                'adapter' => 'pgsql',
                'host' => $_ENV['DB_HOST'],
                'name' => $_ENV['DB_DATABASE'],
                'user' => $_ENV['DB_USERNAME'],
                'pass' => $_ENV['DB_PSW'],
                'port' => $_ENV['DB_PORT'],
                'schema' => $_ENV['DB_SCHEMA']??'public',
                'charset' => 'utf8',
            ],
        ],
        'version_order' => 'creation'
    ];
