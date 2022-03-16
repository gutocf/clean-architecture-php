<?php

namespace App\UseCase\User\Exception;

use Exception;

class InvalidPasswordException extends Exception
{

    public function __construct()
    {
        parent::__construct('Senha não informada', 400);
    }
}
