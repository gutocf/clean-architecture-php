<?php

use App\Main\Adapter\Http\ResponseEmitter;
use App\Presentation\Controller\Api\UsersIndexController as ApiUsersIndexController;
use App\Presentation\Controller\Api\UsersViewController as ApiUsersViewController;
use App\Presentation\Controller\ControllerInterface;
use App\Presentation\Controller\Web\UsersIndexController as WebUsersIndexController;
use App\Presentation\Controller\Web\UsersViewController as WebUsersViewController;
use DI\ContainerBuilder;
use Laminas\Diactoros\ServerRequestFactory;
use Psr\Http\Message\RequestInterface;

define('DS', DIRECTORY_SEPARATOR);

require_once __DIR__ . DS . 'config' . DS . 'bootstrap.php';
require_once __DIR__ . DS . 'vendor' . DS . 'autoload.php';
require_once __DIR__ . DS . 'config' . DS . 'database.php';

/**
 * @property \DI\Container $container
 */
class Application
{
    private RequestInterface $request;

    private ResponseEmitter $emitter;

    private function __construct()
    {
        $this->initContainer();
        $this->emitter = $this->container->get(ResponseEmitter::class);
        $this->request = ServerRequestFactory::fromGlobals();
    }

    private function initContainer()
    {
        $builder =  (new ContainerBuilder())
            ->useAutowiring(false)
            ->useAnnotations(false)
            ->addDefinitions(__DIR__ . DS . 'config' . DS . 'dependencies.php');

        $this->container = $builder->build();
    }

    private function getController(): ?ControllerInterface
    {

        $path = $this->request->getUri()->getPath();

        if (preg_match('/^\/users\/\d+\/?$/', $path)) {
            return $this->container->get(WebUsersViewController::class);
        }

        if (preg_match('/^\/users\/?$/', $path)) {
            return $this->container->get(WebUsersIndexController::class);
        }

        if (preg_match('/^\/api\/users\/\d+\/?$/', $path)) {
            return $this->container->get(ApiUsersViewController::class);
        }

        if (preg_match('/^\/api\/users\/?$/', $path)) {
            return $this->container->get(ApiUsersIndexController::class);
        }

        return null;
    }

    public static function run()
    {
        $application = new Application();
        $controller = $application->getController();
        $response = $controller->handle($application->request);
        $application->emitter->emit($response);
    }
}

Application::run();
