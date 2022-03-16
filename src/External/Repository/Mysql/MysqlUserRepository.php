<?php

declare(strict_types=1);

namespace App\External\Repository\Mysql;

use App\Entity\User;
use App\External\Persistence\DatabaseInterface;
use App\UseCase\Port\UserRepositoryInterface;

/**
 * @property \App\External\Persistence\DatabaseInterface $database
 */
class MysqlUserRepository implements UserRepositoryInterface
{

    public function __construct(private DatabaseInterface $database)
    {
    }

    /**
     * @inheritdoc
     */
    public function findById(int $id): ?User
    {
        $records = $this->database->select('users', ['id', 'name', 'email', 'password'], ['id' => $id]);

        return collection($records)
            ->map(function ($record) {
                return new User(
                    intval($record->id),
                    $record->name,
                    $record->email,
                    $record->password
                );
            })
            ->first();
    }

    /**
     * @inheritdoc
     */
    public function findByEmail(string $email): ?User
    {
        $records = $this->database->select('users', ['id', 'name', 'email', 'password'], ['email' => $email]);

        return collection($records)
            ->map(function ($record) {
                return new User(
                    intval($record->id),
                    $record->name,
                    $record->email,
                    $record->password
                );
            })
            ->first();
    }

    /**
     * @inheritdoc
     */
    public function findAll(): array
    {
        $records = $this->database->select('users', ['id', 'name', 'email', 'password'], []);

        return collection($records)
            ->map(function ($record) {
                return new User(
                    intval($record->id),
                    $record->name,
                    $record->email,
                    $record->password
                );
            })
            ->toArray();
    }

    /**
     * @inheritdoc
     */
    public function update(User $user): bool
    {
        $data = [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
        ];
        $conditions = ['id' => $user->getId()];

        return $this->database->update('users', $data, $conditions);
    }
}
