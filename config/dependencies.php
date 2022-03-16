<?php

declare(strict_types=1);

use App\External\Persistence\LeagueCsv;
use App\External\Persistence\CsvInterface;
use App\External\Persistence\DatabaseInterface;
use App\External\Persistence\MysqlDatabase;
use App\External\Repository\Csv\CsvUserRepository;
use App\External\Repository\Mysql\MysqlUserRepository;
use App\Presentation\Controller\Rest\UsersIndexController as RestUsersIndexController;
use App\Presentation\Controller\Rest\UsersViewController as RestUsersViewController;
use App\Presentation\Controller\Rest\UsersAddController as RestUsersAddController;
use App\Presentation\Controller\Rest\UsersEditController as RestUsersEditController;
use App\Presentation\Controller\Web\UsersIndexController as WebUsersIndexController;
use App\Presentation\Controller\Web\UsersViewController as WebUsersViewController;
use App\Presentation\Controller\Web\UsersAddController as WebUsersAddController;
use App\Presentation\Controller\Web\UsersEditController as WebUsersEditController;
use App\UseCase\Port\UserRepositoryInterface;
use App\UseCase\User\AddUser;
use App\UseCase\User\ListUser;
use App\UseCase\User\ViewUser;
use App\UseCase\User\UpdateUser;
use Twig\Environment;

use function DI\create;
use function DI\get;

return [
    DatabaseInterface::class => create(MysqlDatabase::class),
    CsvInterface::class => create(LeagueCsv::class),
    UserRepositoryInterface::class => create(MysqlUserRepository::class)->constructor(get(DatabaseInterface::class)),
    //UserRepositoryInterface::class => create(CsvUserRepository::class)->constructor(get(CsvInterface::class)),

    ListUser::class => create()->constructor(get(UserRepositoryInterface::class)),
    ViewUser::class => create()->constructor(get(UserRepositoryInterface::class)),
    AddUser::class => create()->constructor(get(UserRepositoryInterface::class)),
    UpdateUser::class => create()->constructor(get(UserRepositoryInterface::class)),

    Environment::class => function () {
        $loader = new \Twig\Loader\FilesystemLoader('templates', ROOT);
        return new \Twig\Environment($loader, [
            // 'cache' => ROOT . 'tmp' . DS . 'cache' . DS . 'views'
        ]);
    },

    RestUsersIndexController::class => create()->constructor(get(ListUser::class)),
    RestUsersViewController::class => create()->constructor(get(ViewUser::class)),
    RestUsersAddController::class => create()->constructor(get(AddUser::class), get(Environment::class)),
    RestUsersEditController::class => create()->constructor(get(UpdateUser::class), get(Environment::class)),

    WebUsersIndexController::class => create()->constructor(get(ListUser::class), get(Environment::class)),
    WebUsersViewController::class => create()->constructor(get(ViewUser::class), get(Environment::class)),
    WebUsersAddController::class => create()->constructor(get(AddUser::class), get(Environment::class)),
    WebUsersEditController::class => create()->constructor(get(UpdateUser::class), get(Environment::class)),
];
