<?php

namespace App\UseCase\User\Exception;

use Exception;

class InvalidEmailException extends Exception
{

    public function __construct()
    {
        parent::__construct('E-mail não informado ou inválido', 400);
    }
}
