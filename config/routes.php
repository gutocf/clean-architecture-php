<?php

use App\Presentation\Controller\Rest\UsersIndexController as RestUsersIndexController;
use App\Presentation\Controller\Rest\UsersViewController as RestUsersViewController;
use App\Presentation\Controller\Rest\UsersEditController as RestUsersEditController;
use App\Presentation\Controller\Web\UsersEditController as WebUsersEditController;
use App\Presentation\Controller\Web\UsersIndexController as WebUsersIndexController;
use App\Presentation\Controller\Web\UsersViewController as WebUsersViewController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;

use Slim\Routing\RouteCollectorProxy;

$app->group('', function (RouteCollectorProxy $group) {
    $group->get('/', function (Request $request, Response $response, $args) {
        return $response->withHeader('Location', '/users');
    });
    $group->get('/users', WebUsersIndexController::class);
    $group->get('/users/{id:\d+}', WebUsersViewController::class);
    $group->get('/users/edit/{id:\d+}', WebUsersEditController::class);
    $group->post('/users/edit/{id:\d+}', WebUsersEditController::class);
});

$RestMiddleware = function (Request $request, RequestHandlerInterface $handler) {
    return $handler
        ->handle($request)
        ->withHeader('Content-Type', 'application/json');
};

$app->group('/api', function (RouteCollectorProxy $group) {
    $group->get('/users', RestUsersIndexController::class);
    $group->get('/users/{id:\d+}', RestUsersViewController::class);
    $group->put('/users/{id:\d+}', RestUsersEditController::class);
})->add($RestMiddleware);
