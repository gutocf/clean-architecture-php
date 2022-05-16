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
        public ?string $name = null,
        public ?string $email = null,
        public ?string $password = null
    ) {
    }
}
