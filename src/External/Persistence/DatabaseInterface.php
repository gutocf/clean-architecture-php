<?php

namespace App\External\Persistence;

interface DatabaseInterface
{
    public function execute(string $query);
    public function select(string $table, array $fields, array $conditions, int $start = 0, int $offset = 10): array;
    public function count(string $table): int;
    public function insert(string $table, array $data): bool;
    public function update(string $table, array $data, array $conditions): bool;
    public function delete(string $table, array $conditions): bool;
}
