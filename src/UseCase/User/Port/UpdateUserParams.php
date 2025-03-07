<?php

namespace App\UseCase\User\Port;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 */
class UpdateUserParams
{
    public function __construct(
        public int $id,
        public ?string $name,
        public ?string $email,
    ) {
    }
}
