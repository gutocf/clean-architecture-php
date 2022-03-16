<?php

namespace App\UseCase\Port\User;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 */
class AddUserData
{
    public function __construct(
        public ?string $name,
        public ?string $email,
        public ?string $password
    ) {
    }
}
