<?php

namespace App\UseCase\User\Exception;

use Exception;

class InvalidNameException extends Exception
{

    public function __construct()
    {
        parent::__construct('Invalid name', 400);
    }
}
