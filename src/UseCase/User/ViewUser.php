<?php

namespace App\UseCase\User;

use App\UseCase\Port\UserData;
use App\UseCase\Port\UserRepositoryInterface;

class ViewUser
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    /**
     * Finds a user by its ID.
     *
     * @return \App\UseCase\Port\UserData|null
     */
    public function view(int $id): ?UserData
    {
        return $this->repository->findById($id);
    }
}
