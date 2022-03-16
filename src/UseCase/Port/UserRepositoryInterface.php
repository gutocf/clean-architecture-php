<?php

namespace App\UseCase\Port;

use App\Entity\User;

interface UserRepositoryInterface
{
    /**
     * Finds an user by its email.
     *
     * @return \App\Entity\User|null
     */
    public function findById(int $id): ?User;

    /**
     * Finds an user by its email.
     *
     * @return \App\Entity\User|null
     */
    public function findByEmail(?string $email): ?User;

    /**
     *  Retrieves all users.
     *
     * @return \App\Entity\User[]
     */
    public function findAll(): array;

    /**
     * Creates an user
     *
     * @return bool
     */
    public function create(User $user): bool;

    /**
     * Updates an user.
     *
     * @return bool
     */
    public function update(User $user): bool;
}
