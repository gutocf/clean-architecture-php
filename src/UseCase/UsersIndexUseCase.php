<?php

namespace App\UseCase;

use App\UseCase\Port\UserRepositoryInterface;

/**
 * @property \App\UseCase\Port\UserRepository $repository
 */
class UsersIndexUseCase
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function execute()
    {
        return $this->repository->findAll();
    }
}
