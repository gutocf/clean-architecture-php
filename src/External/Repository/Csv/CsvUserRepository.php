<?php

namespace App\External\Repository\Csv;

use App\Entity\User;
use App\External\Persistence\CsvInterface;
use App\UseCase\User\UserRepositoryInterface;

/**
 * @property \App\External\Persistence\CsVInterface $csv
 */
class CsvUserRepository implements UserRepositoryInterface
{
    private const FILENAME = 'users';

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
            ->filter(
                function (User $user) use ($id) {
                    return $user->getId() === $id;
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

        $users = $this->findAll();

        return collection($users)
            ->filter(
                function (User $user) use ($email) {
                    return $user->getEmail() === $email;
                }
            )
            ->first();
    }

    /**
     * @inheritdoc
     */
    public function findAll(int $start = 0, int $offset = 10): array
    {
        $records = $this->csv->read(self::FILENAME);

        return collection($records)
            ->skip($start)
            ->take($offset)
            ->map(
                function ($record) {
                    return new User(
                        intval($record[0]),
                        $record[1],
                        $record[2],
                        $record[3]
                    );
                }
            )
            ->toArray();
    }

    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return $this->csv->count(self::FILENAME);
    }

    /**
     * @inheritdoc
     */
    public function create(User $user): User
    {
        $records = $this->csv->read(self::FILENAME);

        $id = collection($records)
            ->map(
                function ($record) {
                    return ['id' => intval($record[0])];
                }
            )
            ->sortBy('id', SORT_ASC)
            ->extract('id')
            ->last();

        $user->setId(++$id);

        $records[] = [
            $user->getId(),
            $user->getName(),
            $user->getEmail(),
            $user->getPassword()
        ];

        $this->csv->write(self::FILENAME, $records);

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function update(User $user): User
    {
        $records = $this->csv->read(self::FILENAME);
        $records = collection($records)
            ->map(
                function ($record) use ($user) {
                    if (intval($record[0]) === $user->getId()) {
                        $record[1] = $user->getName();
                        $record[2] = $user->getEmail();
                        $record[3] = $user->getPassword();
                    }

                    return $record;
                }
            )
            ->toArray();

        $this->csv->write(self::FILENAME, $records);

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function delete(User $user): bool
    {
        $records = collection($this->csv->read(self::FILENAME))
            ->filter(
                function (array $data) use ($user) {
                    return intval($data[0]) !== $user->getId();
                }
            )
            ->toArray();

        return $this->csv->write(self::FILENAME, $records);
    }
}
