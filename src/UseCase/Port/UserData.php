<?php

namespace App\UseCase\Port;

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
