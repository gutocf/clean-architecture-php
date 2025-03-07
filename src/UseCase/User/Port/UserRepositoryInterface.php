<?php

namespace App\UseCase\User\Port;

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
     * @param  int $start  Index of the first user to retrieve.
     * @param  int $offset Number of users to retrieve.
     * @return \App\Entity\User[]
     */
    public function findAll(int $start = 0, int $offset = 10): array;

    /**
     * Counts users.
     *
     * @return int
     */
    public function count(): int;

    /**
     * Creates an user.
     *
     * @param  User $user
     * @return \App\Entity\User $user
     */
    public function create(User $user): User;

    /**
     * Updates an user.
     *
     * @param  int              $id
     * @param  \App\Entity\User $user
     * @return \App\Entity\User $user
     */
    public function update(User $user): User;

    /**
     * Deletes an user.
     *
     * @param  \App\Entity\User $user
     * @return bool
     */
    public function delete(User $user): bool;
}
