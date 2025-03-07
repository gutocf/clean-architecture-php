<?php

namespace App\UseCase\User;

use App\UseCase\User\Port\UserRepositoryInterface;

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
