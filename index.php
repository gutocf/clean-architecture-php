<?php

use App\Presentation\Controller\Api\UsersIndexController as ApiUsersIndexController;
use App\Presentation\Controller\Api\UsersViewController as ApiUsersViewController;
use App\Presentation\Controller\Web\UsersIndexController as WebUsersIndexController;
use App\Presentation\Controller\Web\UsersViewController as WebUsersViewController;
use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

define('DS', DIRECTORY_SEPARATOR);

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


$app->group('', function (RouteCollectorProxy $group) {
    $group->get('/', function (Request $request, Response $response, $args) {
        return $response->withHeader('Location', '/users');
    });
    $group->get('/users', WebUsersIndexController::class);
    $group->get('/users/{id:\d+}', WebUsersViewController::class);
});

$apiMiddleware = function (Request $request, RequestHandlerInterface $handler) {
    return $handler
        ->handle($request)
        ->withHeader('Content-Type', 'application/json');
};

$app->group('/api', function (RouteCollectorProxy $group) {
    $group->get('/users', ApiUsersIndexController::class);
    $group->get('/users/{id:\d+}', ApiUsersViewController::class);
})->add($apiMiddleware);

$app->addErrorMiddleware(false, true, true);

$app->run();
