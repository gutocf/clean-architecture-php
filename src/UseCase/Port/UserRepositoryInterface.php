<?php

namespace App\UseCase\Port;

interface UserRepositoryInterface
{
    /**
     * @return UserData[]
     */
    public function findAll(): array;
}
