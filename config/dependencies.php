<?php

declare(strict_types=1);

use App\External\Persistence\CsvHandler;
use App\External\Persistence\CsvInterface;
use App\External\Persistence\DatabaseInterface;
use App\External\Persistence\MysqlDatabase;
use App\External\Repository\Csv\CsvUserRepository;
use App\External\Repository\Mysql\MysqlUserRepository;
use App\Main\Adapter\Http\ResponseEmitter;
use App\Presentation\Controller\Api\UsersIndexController as ApiUsersIndexController;
use App\Presentation\Controller\Api\UsersViewController as ApiUsersViewController;
use App\Presentation\Controller\Web\UsersIndexController as WebUsersIndexController;
use App\Presentation\Controller\Web\UsersViewController as WebUsersViewController;
use App\UseCase\Port\UserRepositoryInterface;
use App\UseCase\UsersIndexUseCase;
use App\UseCase\UsersViewUseCase;
use Twig\Environment;

use function DI\create;
use function DI\get;

return [
    ResponseEmitter::class => create(),
    DatabaseInterface::class => create(MysqlDatabase::class),
    UserRepositoryInterface::class => create(MysqlUserRepository::class)->constructor(get(DatabaseInterface::class)),

    CsvInterface::class => create(CsvHandler::class),
    UserRepositoryInterface::class => create(CsvUserRepository::class)->constructor(get(CsvInterface::class)),

    UsersIndexUseCase::class => create()->constructor(get(UserRepositoryInterface::class)),
    UsersViewUseCase::class => create()->constructor(get(UserRepositoryInterface::class)),

    Environment::class => function () {
        $loader = new \Twig\Loader\FilesystemLoader('templates', ROOT);
        return new \Twig\Environment($loader, [
            'cache' => ROOT . 'tmp' . DS . 'cache' . DS . 'views'
        ]);
    },

    ApiUsersIndexController::class => create()->constructor(get(UsersIndexUseCase::class)),
    ApiUsersViewController::class => create()->constructor(get(UsersViewUseCase::class)),

    WebUsersIndexController::class => create()->constructor(get(UsersIndexUseCase::class), get(Environment::class)),
    WebUsersViewController::class => create()->constructor(get(UsersViewUseCase::class), get(Environment::class)),
];
