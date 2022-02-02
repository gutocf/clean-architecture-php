<?php

declare(strict_types=1);

namespace App\External\Repository\Mysql;

use App\External\Persistence\DatabaseInterface;
use App\UseCase\Port\UserData;
use App\UseCase\Port\UserRepositoryInterface;

/**
 * @property \App\External\Persistence\DatabaseInterface $database
 */
class MysqlUserRepository implements UserRepositoryInterface
{

    public function __construct(DatabaseInterface $database)
    {
        $this->database =  $database;
    }

    /**
     * Retrieves all users data.
     *
     * @inheritdoc
     */
    public function findAll(): array
    {
        $records = $this->database->select('users', ['id', 'name', 'email', 'password'], []);

        return collection($records)
            ->map(function ($record) {
                return new UserData(
                    intval($record->id),
                    $record->name,
                    $record->email,
                    $record->password
                );
            })
            ->toArray();
    }
}
