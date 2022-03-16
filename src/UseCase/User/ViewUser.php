<?php

namespace App\UseCase\User;

use App\UseCase\Port\User\ViewUserData;
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
     * @return \App\UseCase\Port\User\ViewUserData|null
     */
    public function view(int $id): ?ViewUserData
    {
        $user = $this->repository->findById($id);

        if (!$user) {
            return null;
        }

        return new ViewUserData(
            $user->getId(),
            $user->getName(),
            $user->getEmail(),
        );
    }
}
