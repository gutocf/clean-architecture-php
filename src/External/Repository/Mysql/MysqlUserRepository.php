<?php

declare(strict_types=1);

namespace App\External\Repository\Mysql;

use App\External\Persistence\DatabaseInterface;
use App\UseCase\Port\UserData;
use App\UseCase\Port\UserRepositoryInterface;
use RuntimeException;

/**
 * @property \App\External\Persistence\DatabaseInterface $database
 */
class MysqlUserRepository implements UserRepositoryInterface
{

    public function __construct(private DatabaseInterface $database)
    {
    }

    /**
     * Retrieves user data by its id.
     *
     * @return UserData
     */
    public function findById(int $id): ?UserData
    {
        $records = $this->database->select('users', ['id', 'name', 'email', 'password'], ['id' => $id]);

        return collection($records)
            ->map(function ($record) {
                return new UserData(
                    intval($record->id),
                    $record->name,
                    $record->email,
                    $record->password
                );
            })
            ->first();
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

    public function update(UserData $userData): bool
    {
        $data = [
            'name' => $userData->name,
            'email' => $userData->email,
            'password' => $userData->password,
        ];
        $conditions = ['id' => $userData->id];

        return $this->database->update('users', $data, $conditions);
    }
}
