<?php

namespace App\UseCase\User;

use App\UseCase\User\Exception\UserNotFoundException;
use App\UseCase\User\UserRepositoryInterface;

class DeleteUser
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    /**
     * @inheritdoc
     */
    public function delete(int $id): bool
    {
        $user = $this->repository->findById($id);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $this->repository->delete($user);
    }
}
