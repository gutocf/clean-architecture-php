<?php

namespace App\UseCase\User;

use App\UseCase\Port\UserData;
use App\UseCase\Port\UserRepositoryInterface;

class UpdateUser
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function update(UserData $data): bool
    {
        return $this->repository->update($data);
    }
}
