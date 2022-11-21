<?php

namespace App\UseCase\User;

use App\Entity\User;
use App\UseCase\Port\UserRepositoryInterface;
use App\UseCase\Port\User\UpdateUserData;
use App\UseCase\User\Exception\InvalidEmailException;
use App\UseCase\User\Exception\InvalidNameException;
use App\UseCase\User\Exception\UserNotFoundException;

class UpdateUser
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function update(UpdateUserData $data): bool
    {
        $user = $this->repository->findById($data->id);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        if (empty($data->name)) {
            throw new InvalidNameException();
        }

        if (empty($data->email)) {
            throw new InvalidEmailException();
        }

        $user->setName($data->name);
        $user->setEmail($data->email);

        return $this->repository->update($user);
    }

    public function get(int $id): ?User
    {
        return $this->repository->findById($id);
    }
}
