<?php

namespace App\External\Repository\Csv;

use App\Entity\User;
use App\External\Persistence\CsvInterface;
use App\UseCase\Port\UserRepositoryInterface;
use RuntimeException;

/**
 * @property \App\External\Persistence\CsVInterface $csv
 */
class CsvUserRepository implements UserRepositoryInterface
{
    public function __construct(private CsvInterface $csv)
    {
    }

    /**
     * @inheritdoc
     */
    public function findById(int $id): ?User
    {
        $users = $this->findAll();

        return collection($users)
            ->filter(function (User $user) use ($id) {
                return $user->getId() === $id;
            })
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

        $users = $this->findAll();

        return collection($users)
            ->filter(function (User $user) use ($email) {
                return $user->getEmail() === $email;
            })
            ->first();
    }

    /**
     * @inheritdoc
     */
    public function findAll(): array
    {
        $records = $this->csv->read('users');

        return collection($records)
            ->map(function ($record) {
                return new User(
                    intval($record[0]),
                    $record[1],
                    $record[2],
                    $record[3]
                );
            })
            ->toArray();
    }

    /**
     * @inheritdoc
     */
    public function create(User $user): bool
    {
        $records = $this->csv->read('users');

        $id = collection($records)
            ->map(function ($record) {
                return ['id' => intval($record[0])];
            })
            ->sortBy('id', SORT_ASC)
            ->extract('id')
            ->last();

        $records[] = [
            ++$id,
            $user->getName(),
            $user->getEmail(),
            $user->getPassword()
        ];

        return $this->csv->write('users', $records);
    }

    /**
     * @inheritdoc
     */
    public function update(User $user): bool
    {
        $records = $this->csv->read('users');
        $records = collection($records)
            ->map(function ($record) use ($user) {
                if (intval($record[0]) === $user->getId()) {
                    $record[1] = $user->getName();
                    $record[2] = $user->getEmail();
                    $record[3] = $user->getPassword();
                }

                return $record;
            })
            ->toArray();

        return $this->csv->write('users', $records);
    }

    /**
     * @inheritdoc
     */
    public function delete(User $user): bool
    {
        $records = collection($this->csv->read('users'))
            ->filter(function (array $data) use ($user) {
                return intval($data[0]) !== $user->getId();
            })
            ->toArray();

        return $this->csv->write('users', $records);
    }
}
