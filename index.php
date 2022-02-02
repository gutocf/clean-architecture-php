<?php

use DI\ContainerBuilder;
use App\Presentation\Api\Controller\LoadUsersController as ApiLoadUsersController;
use App\Presentation\Web\Controller\LoadUsersController as WebLoadUsersController;
use App\UseCase\LoadUsersUseCase;

use function DI\create;
use function DI\get;

define('DS', DIRECTORY_SEPARATOR);

require_once __DIR__ . DS . 'config' . DS . 'bootstrap.php';
require_once __DIR__ . DS . 'vendor' . DS . 'autoload.php';
require_once __DIR__ . DS . 'config' . DS . 'database.php';

/**
 * @property \DI\Container $container
 * @property \Symfony\Component\Routing\RouteCollection $router
 */
class Application
{
    private static $instance;

    private function __construct()
    {
        $builder =  (new ContainerBuilder())
            ->useAutowiring(false)
            ->useAnnotations(false)
            ->addDefinitions(__DIR__ . DS . 'config' . DS . 'dependencies.php');

        $this->container = $builder->build();
    }

    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function run()
    {
        switch ($_SERVER['REQUEST_URI']) {

            case '/users':
                $controller = $this->container->get(WebLoadUsersController::class);
                $controller->index();
                break;

            case '/api/users':
                $controller = $this->container->get(ApiLoadUsersController::class);
                $controller->index();
                break;
        }
    }
}

Application::getInstance()->run();
