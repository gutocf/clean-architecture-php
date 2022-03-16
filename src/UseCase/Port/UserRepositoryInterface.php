<?php

namespace App\UseCase\Port;

use App\Entity\User;

interface UserRepositoryInterface
{
    /**
     * Retrieves user data by its id.
     *
     * @return \App\Entity\User|null
     */
    public function findById(int $id): ?User;

    /**
     * Retrieves user data by its email.
     *
     * @return \App\Entity\User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     *  Retrieves all users data.
     *
     * @return \App\Entity\User[]
     */
    public function findAll(): array;

    /**
     * Updates user data.
     *
     * @return bool
     */
    public function update(User $user): bool;
}
