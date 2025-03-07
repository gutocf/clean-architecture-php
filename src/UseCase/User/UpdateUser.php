<?php

namespace App\UseCase\User;

use App\Entity\User;
use App\UseCase\User\Exception\InvalidEmailException;
use App\UseCase\User\Exception\InvalidNameException;
use App\UseCase\User\Exception\UserExistsException;
use App\UseCase\User\Exception\UserNotFoundException;
use App\UseCase\User\Port\UpdateUserParams;
use App\UseCase\User\UserRepositoryInterface;

class UpdateUser
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function update(UpdateUserParams $data): User
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

        $user_email = $this->repository->findByEmail($data->email);

        if($user_email !== null && $user->getId() !== $user_email->getId()) {
            throw new UserExistsException();
        }

        $user->setName($data->name);
        $user->setEmail($data->email);

        $this->repository->update($user);

        return $user;
    }

    public function get(int $id): ?User
    {
        return $this->repository->findById($id);
    }
}
