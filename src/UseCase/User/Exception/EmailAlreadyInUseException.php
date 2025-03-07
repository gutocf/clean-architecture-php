<?php

namespace App\UseCase\User\Exception;

use Exception;

class EmailAlreadyInUseException extends Exception
{

    public function __construct()
    {
        parent::__construct('Email address is already in use', 400);
    }
}
