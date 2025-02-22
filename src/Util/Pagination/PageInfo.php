<?php

namespace App\Util\Pagination;

use App\Util\Pagination\Exception\PaginationException;
use JsonSerializable;

class PageInfo implements JsonSerializable
{

    private const PER_PAGE_MAX = 50;

    public function __construct(
        private int $total,
        private int $page = 1,
        private int $perPage = 10
    ) {
        $this->perPage = min($this->perPage, self::PER_PAGE_MAX);

        if ($this->getCurrentPage() > $this->getLastPage()) {
            throw new PaginationException();
        }
    }

    public function getStart(): int
    {
        return ($this->page - 1) * $this->perPage;
    }

    public function getCurrentPage(): int
    {
        return $this->page;
    }


    public function getTotal(): int
    {
        return $this->total;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getLastPage(): int
    {
        return ceil($this->total / $this->perPage);
    }

    public function hasPreviousPage(): bool
    {
        return $this->page > 1;
    }

    public function hasNextPage(): bool
    {
        return $this->page < $this->getLastPage();
    }

    public function getPreviousPage(): ?int
    {
        if ($this->page === 1) {
            return null;
        }

        return $this->page - 1;
    }

    public function getNextPage(): ?int
    {
        if ($this->page === $this->getLastPage()) {
            return null;
        }

        return $this->page + 1;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'currentPage' => $this->getCurrentPage(),
            'lastPage' => $this->getLastPage(),
            'perPage' => $this->getPerPage(),
        ];
    }
}
