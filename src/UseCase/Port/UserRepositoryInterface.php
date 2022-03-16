<?php

namespace App\UseCase\Port;

interface UserRepositoryInterface
{
    /**
     * Retrieves user data by its id.
     *
     * @return \App\UseCase\Port\UserData|null
     */
    public function findById(int $id): ?UserData;

    /**
     *  Retrieves all users data.
     *
     * @return \App\UseCase\Port\UserData[]
     */
    public function findAll(): array;

    /**
     * Updates user data.
     *
     * @return bool
     */
    public function update(UserData $data): bool;
}
