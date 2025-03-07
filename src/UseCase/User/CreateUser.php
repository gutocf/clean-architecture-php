<?php

namespace App\UseCase\User;

use App\Entity\User;
use App\UseCase\User\Exception\EmailAlreadyInUseException;
use App\UseCase\User\Exception\InvalidEmailException;
use App\UseCase\User\Exception\InvalidNameException;
use App\UseCase\User\Exception\InvalidPasswordConfirmationException;
use App\UseCase\User\Exception\InvalidPasswordException;
use App\UseCase\User\Port\CreateUserParams;
use App\UseCase\User\Port\UserRepositoryInterface;

class CreateUser
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function create(CreateUserParams $data): User
    {
        if ($this->repository->findByEmail($data->email) !== null) {
            throw new EmailAlreadyInUseException();
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

        if ($data->password !== $data->password_confirm) {
            throw new InvalidPasswordConfirmationException();
        }

        $user = new User(
            id: null,
            name: $data->name,
            email: $data->email,
            password: $data->password
        );

        return $this->repository->create($user);
    }
}
