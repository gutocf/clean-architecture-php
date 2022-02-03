<?php

use App\Main\Adapter\Http\ResponseEmitter;
use App\Presentation\Controller\Api\LoadUsersController as ApiLoadUsersController;
use App\Presentation\Controller\ControllerInterface;
use App\Presentation\Controller\Web\LoadUsersController as WebLoadUsersController;
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
        switch ($this->request->getUri()->getPath()) {

            case '/users':
                return $this->container->get(WebLoadUsersController::class);

            case '/api/users':
                return $this->container->get(ApiLoadUsersController::class);
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
