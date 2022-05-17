<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__ . DS);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require_once __DIR__ . DS . 'config' . DS . 'bootstrap.php';
require_once __DIR__ . DS . 'vendor' . DS . 'autoload.php';
require_once __DIR__ . DS . 'config' . DS . 'database.php';

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
