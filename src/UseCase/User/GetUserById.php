<?php

namespace App\UseCase\User;

use App\Entity\User;
use App\UseCase\User\Port\UserRepositoryInterface;
use App\UseCase\User\Exception\UserNotFoundException;

class GetUserById
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function get(int $id): User
    {
        $user = $this->repository->findById($id);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
