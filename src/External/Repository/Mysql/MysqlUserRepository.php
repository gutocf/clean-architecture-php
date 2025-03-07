<?php

declare(strict_types=1);

namespace App\External\Repository\Mysql;

use App\Entity\User;
use App\External\Persistence\DatabaseInterface;
use App\UseCase\User\UserRepositoryInterface;

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
            ->map(
                function ($record) {
                    return new User(
                        intval($record->id),
                        $record->name,
                        $record->email,
                        $record->password
                    );
                }
            )
            ->first();
    }

    /**
     * @inheritdoc
     */
    public function findByEmail(?string $email): ?User
    {
        if (!$email) {
            return null;
        }

        $records = $this->database->select('users', ['id', 'name', 'email', 'password'], ['email' => $email]);

        return collection($records)
            ->map(
                function ($record) {
                    return new User(
                        intval($record->id),
                        $record->name,
                        $record->email,
                        $record->password
                    );
                }
            )
            ->first();
    }

    /**
     * @inheritdoc
     */
    public function findAll(int $start = 0, int $offset = 10): array
    {
        $records = $this->database->select('users', ['id', 'name', 'email', 'password'], [], $start, $offset);

        return collection($records)
            ->map(
                function ($record) {
                    return new User(
                        intval($record->id),
                        $record->name,
                        $record->email,
                        $record->password
                    );
                }
            )
            ->toArray();
    }

    /**
     * @inheritdoc
     */
    public function create(User $user): User
    {
        $this->database->insert(
            'users', [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
            ]
        );

        $records = $this->database->execute('SELECT LAST_INSERT_ID() AS id');
        $user->setId(intval($records[0]->id));

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return $this->database->count('users');
    }

    /**
     * @inheritdoc
     */
    public function update(User $user): User
    {
        $data = [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
        ];
        $conditions = ['id' => $user->getId()];
        $this->database->update('users', $data, $conditions);

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function delete(User $user): bool
    {
        $conditions = ['id' => $user->getId()];

        return $this->database->delete('users', $conditions);
    }
}
