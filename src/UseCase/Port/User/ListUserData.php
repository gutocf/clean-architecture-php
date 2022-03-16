<?php

namespace App\UseCase\Port\User;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 */
class ListUserData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
    ) {
    }
}
