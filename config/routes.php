<?php

use App\Presentation\Controller\Rest\UsersAddController as RestUsersAddController;
use App\Presentation\Controller\Rest\UsersDeleteController as RestUsersDeleteController;
use App\Presentation\Controller\Rest\UsersEditController as RestUsersEditController;
use App\Presentation\Controller\Rest\UsersIndexController as RestUsersIndexController;
use App\Presentation\Controller\Rest\UsersViewController as RestUsersViewController;
use App\Presentation\Controller\Web\UsersAddController as WebUsersAddController;
use App\Presentation\Controller\Web\UsersDeleteController as WebUsersDeleteController;
use App\Presentation\Controller\Web\UsersEditController as WebUsersEditController;
use App\Presentation\Controller\Web\UsersIndexController as WebUsersIndexController;
use App\Presentation\Controller\Web\UsersViewController as WebUsersViewController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteCollectorProxy;

$app->group('', function (RouteCollectorProxy $group) {
    $group->get('/', function (ServerRequestInterface $request, ResponseInterface  $response, $args) {
        return $response
            ->withStatus(302)
            ->withHeader('Location', '/users');
    });
    $group->get('/users', WebUsersIndexController::class);
    $group->get('/users/{id:\d+}', WebUsersViewController::class);
    $group->get('/users/add', WebUsersAddController::class);
    $group->post('/users/add', WebUsersAddController::class);
    $group->get('/users/edit/{id:\d+}', WebUsersEditController::class);
    $group->post('/users/edit/{id:\d+}', WebUsersEditController::class);
    $group->get('/users/delete/{id:\d+}', WebUsersDeleteController::class);
});

$RestMiddleware = function (ServerRequestInterface $request, RequestHandlerInterface $handler) {
    return $handler
        ->handle($request)
        ->withHeader('Content-Type', 'application/json');
};

$app->group('/api', function (RouteCollectorProxy $group) {
    $group->get('/users', RestUsersIndexController::class);
    $group->post('/users/', RestUsersAddController::class);
    $group->get('/users/{id:\d+}', RestUsersViewController::class);
    $group->put('/users/{id:\d+}', RestUsersEditController::class);
    $group->delete('/users/{id:\d+}', RestUsersDeleteController::class);
})->add($RestMiddleware);
