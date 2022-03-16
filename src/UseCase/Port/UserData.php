<?php

namespace App\UseCase\Port;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 */
class UserData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $password
    ) {
    }
}
