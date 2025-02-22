<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__ . DS);

use Cake\Datasource\ConnectionManager;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use josegonzalez\Dotenv\Loader;

require_once __DIR__ . DS . 'vendor' . DS . 'autoload.php';
require_once __DIR__ . DS . 'config' . DS . 'bootstrap.php';

$config_file = __DIR__ . DS . 'config' . DS . '.env';
if (file_exists($config_file)) {
    (new Loader($config_file))
        ->parse()
        ->toEnv();
}

ConnectionManager::setConfig('default', [
    'url' => env('DATABASE_URL'),
]);

$builder =  (new ContainerBuilder())
    ->useAutowiring(false)
    ->useAnnotations(false)
    ->addDefinitions(__DIR__ . DS . 'config' . DS . 'dependencies.php');

$container = $builder->build();

AppFactory::setContainer($container);

$app = AppFactory::create();

require_once __DIR__ . DS . 'config' . DS . 'routes.php';

$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->run();
