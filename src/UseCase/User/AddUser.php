<?php

namespace App\UseCase\User;

use App\Entity\User;
use App\UseCase\Port\UserRepositoryInterface;
use App\UseCase\Port\User\AddUserData;
use App\UseCase\User\Exception\InvalidEmailException;
use App\UseCase\User\Exception\InvalidNameException;
use App\UseCase\User\Exception\InvalidPasswordException;
use App\UseCase\User\Exception\UserExistsException;

class AddUser
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function add(AddUserData $data): bool
    {
        $user = $this->repository->findByEmail($data->email);

        if ($user !== null) {
            throw new UserExistsException();
        }

        if (empty($data->name)) {
            throw new InvalidNameException();
        }

        if (empty($data->email)) {
            throw new InvalidEmailException();
        }

        if (empty($data->password)) {
            throw new InvalidPasswordException();
        }

        $user = new User(null, $data->name, $data->email, $data->password);

        return $this->repository->create($user);
    }
}
