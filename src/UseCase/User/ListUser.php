<?php

namespace App\UseCase\User;

use App\Entity\User;
use App\UseCase\Port\User\ListUserData;
use App\UseCase\Port\UserRepositoryInterface;

class ListUser
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    /**
     * Retrieves all users data.
     *
     * @return ListUserData[]
     */
    public function list(): array
    {
        $users = $this->repository->findAll();

        return collection($users)
            ->map(function (User $user) {
                return new ListUserData(
                    $user->getId(),
                    $user->getName(),
                    $user->getEmail(),
                );
            })->toArray();
    }
}
