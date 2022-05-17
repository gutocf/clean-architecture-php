<?php

namespace App\UseCase\User\Exception;

use Exception;

class UserNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('User not found', 400);
    }
}
