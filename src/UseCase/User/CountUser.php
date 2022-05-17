<?php

namespace App\UseCase\User;

use App\UseCase\Port\UserRepositoryInterface;
use App\UseCase\Port\User\ListUserData;

class CountUser
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    /**
     * Counts users.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->repository->count();
    }
}
