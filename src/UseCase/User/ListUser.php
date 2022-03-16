<?php

namespace App\UseCase\User;

use App\UseCase\Port\UserRepositoryInterface;

class ListUser
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function list()
    {
        return $this->repository->findAll();
    }
}
