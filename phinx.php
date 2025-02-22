<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__ . DS);

use josegonzalez\Dotenv\Loader;

require_once __DIR__ . DS . 'vendor' . DS . 'autoload.php';
require_once __DIR__ . DS . 'config' . DS . 'bootstrap.php';

$config_file = __DIR__ . DS . 'config' . DS . '.env';
if (file_exists($config_file)) {
    (new Loader($config_file))
        ->parse()
        ->toEnv();
}

return
    [
        'paths' => [
            'migrations' => __DIR__ . '/db/migrations',
            'seeds' => __DIR__ . '/db/seeds'
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_environment' => 'environment',
            'environment' => [
                'dsn' => env('DATABASE_URL'),
            ],
            'version_order' => 'creation'
        ]
    ];
