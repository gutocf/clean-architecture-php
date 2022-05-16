<?php

namespace App\Util\Pagination;

class PageInfo
{
    public function __construct(public int $page, public int $perPage, public int $total)
    {
    }
}
