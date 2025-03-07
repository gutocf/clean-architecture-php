<?php

namespace App\UseCase\User\Port;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $password_confirm
 */
class CreateUserParams
{
    public function __construct(
        public ?string $name = null,
        public ?string $email = null,
        public ?string $password = null,
        public ?string $password_confirm = null,
    ) {
    }
}
