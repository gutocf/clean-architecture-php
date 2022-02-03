<?php

namespace App\UseCase\Port;

interface UserRepositoryInterface
{
    /**
     * Retrieves user data by its id.
     *
     * @return UserData
     */
    public function findById(int $id): ?UserData;

    /**
     *  Retrieves all users data.
     *
     * @return UserData[]
     */
    public function findAll(): array;
}
