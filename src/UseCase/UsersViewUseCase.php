<?php

namespace App\UseCase;

use App\UseCase\Port\UserRepositoryInterface;

/**
 * @property \App\UseCase\Port\UserRepository $repository
 */
class UsersViewUseCase
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function execute(int $id)
    {
        return $this->repository->findById($id);
    }
}
