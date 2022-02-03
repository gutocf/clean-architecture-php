<?php

namespace App\UseCase;

use App\UseCase\Port\UserRepositoryInterface;

/**
 * @property \App\UseCase\Port\UserRepository $repository
 */
class UsersViewUseCase
{

    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id)
    {
        return $this->repository->findById($id);
    }
}
