<?php

declare(strict_types=1);

use App\External\Persistence\CsvHandler;
use App\External\Persistence\CsvInterface;
use App\External\Persistence\DatabaseInterface;
use App\External\Persistence\MysqlDatabase;
use App\External\Repository\Csv\CsvUserRepository;
use App\External\Repository\Mysql\MysqlUserRepository;
use App\Main\Adapter\Http\ResponseEmitter;
use App\Presentation\Controller\Api\LoadUsersController as ApiLoadUsersController;
use App\Presentation\Controller\Web\LoadUsersController as WebLoadUsersController;
use App\UseCase\LoadUsersUseCase;
use App\UseCase\Port\UserRepositoryInterface;
use Twig\Environment;

use function DI\create;
use function DI\get;

return [
    ResponseEmitter::class => create(),
    DatabaseInterface::class => create(MysqlDatabase::class),
    UserRepositoryInterface::class => create(MysqlUserRepository::class)->constructor(get(DatabaseInterface::class)),

    CsvInterface::class => create(CsvHandler::class),
    // UserRepositoryInterface::class => create(CsvUserRepository::class)->constructor(get(CsvInterface::class)),

    LoadUsersUseCase::class => create()->constructor(get(UserRepositoryInterface::class)),

    Environment::class => function () {
        $loader = new \Twig\Loader\FilesystemLoader('templates', ROOT);
        return new \Twig\Environment($loader, [
            'cache' => false,
            // 'cache' => ROOT . 'tmp' . DS . 'cache' . DS . 'views'
        ]);
    },

    ApiLoadUsersController::class => create()->constructor(get(LoadUsersUseCase::class)),

    WebLoadUsersController::class => create()->constructor(get(LoadUsersUseCase::class), get(Environment::class)),
];
