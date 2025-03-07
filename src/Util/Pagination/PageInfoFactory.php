<?php

namespace App\Util\Pagination;

use Psr\Http\Message\ServerRequestInterface;

abstract class PageInfoFactory
{
    /**
     * Creates a PageInfo object from a ServerRequestInterface object and total number of items.
     *
     * @param  ServerRequestInterface $request The request object.
     * @param  int                    $total   The total number of items
     * @return PageInfo
     */
    public static function create(ServerRequestInterface $request, int $total): PageInfo
    {
        $queryParams = $request->getQueryParams();
        $page = intval($queryParams['page'] ?? 1);
        $perPage = intval($queryParams['perPage'] ?? 10);

        return new PageInfo($total, $page, $perPage);
    }
}
