<?php

namespace App\UseCase\User\Exception;

use Exception;

class InvalidPasswordConfirmationException extends Exception
{

    public function __construct()
    {
        parent::__construct('Invalid password confirmation', 400);
    }
}
