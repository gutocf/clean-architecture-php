<?php

declare(strict_types=1);

use App\External\Persistence\CsvHandler;
use App\External\Persistence\CsvInterface;
use App\External\Persistence\DatabaseInterface;
use App\External\Persistence\MysqlDatabase;
use App\External\Repository\Csv\CsvUserRepository;
use App\External\Repository\Mysql\MysqlUserRepository;
use App\Presentation\Api\Controller\LoadUsersController as ApiLoadUsersController;
use App\Presentation\Web\Controller\LoadUsersController as WebLoadUsersController;
use App\UseCase\LoadUsersUseCase;
use App\UseCase\Port\UserRepositoryInterface;
use Twig\Environment;

use function DI\create;
use function DI\get;

return [
    DatabaseInterface::class => create(MysqlDatabase::class),
    UserRepositoryInterface::class => create(MysqlUserRepository::class)->constructor(get(DatabaseInterface::class)),

    CsvInterface::class => create(CsvHandler::class),
    // UserRepositoryInterface::class => create(CsvUserRepository::class)->constructor(get(CsvInterface::class)),

    LoadUsersUseCase::class => create()->constructor(get(UserRepositoryInterface::class)),

    Environment::class => function () {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT . 'templates');
        return new \Twig\Environment($loader, [
            'cache' => false,
            'cache' => ROOT . 'tmp' . DS . 'cache' . DS . 'views'
        ]);
    },

    ApiLoadUsersController::class => create()->constructor(get(LoadUsersUseCase::class)),

    WebLoadUsersController::class => create()->constructor(get(LoadUsersUseCase::class), get(Environment::class)),
];
