<?php

namespace App\UseCase;

use App\UseCase\Port\UserRepositoryInterface;

/**
 * @property \App\UseCase\Port\UserRepository $repository
 */
class UsersIndexUseCase
{

    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute()
    {
        return $this->repository->findAll();
    }
}
