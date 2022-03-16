<?php

namespace App\External\Repository\Csv;

use App\External\Persistence\CsvInterface;
use App\UseCase\Port\UserData;
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

    public function findById(int $id): ?UserData
    {
        $users = $this->findAll();

        return collection($users)
            ->filter(function (UserData $userData) use ($id) {
                return $userData->id === $id;
            })
            ->first();
    }

    public function findAll(): array
    {
        $records = $this->csv->read('users');

        return collection($records)
            ->map(function ($record) {
                return new UserData(
                    intval($record[0]),
                    $record[1],
                    $record[2],
                    $record[3]
                );
            })
            ->toArray();
    }

    public function update(UserData $data): UserData
    {
        throw new RuntimeException('Not implemented yet.');
    }
}
