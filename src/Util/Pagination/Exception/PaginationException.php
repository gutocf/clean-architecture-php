<?php

declare(strict_types=1);

namespace App\Util\Pagination\Exception;

use Exception;

class PaginationException extends Exception
{

    public function __construct()
    {
        parent::__construct('Pagination error', 400);
    }
}
