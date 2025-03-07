<?php

namespace App\UseCase\User;

use App\Entity\User;
use App\UseCase\User\UserRepositoryInterface;
use App\UseCase\User\Exception\UserNotFoundException;

class ViewUser
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    /**
     * Finds a user by its ID.
     *
     * @throws UserNotFoundException
     * @return \App\Entity\User
     */
    public function view(int $id): User
    {
        $user = $this->repository->findById($id);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
