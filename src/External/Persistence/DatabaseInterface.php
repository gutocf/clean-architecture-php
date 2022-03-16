<?php

namespace App\External\Persistence;

interface DatabaseInterface
{
    public function execute(string $query);
    public function select(string $table, array $fields, array $conditions): array;
    public function insert(string $table, array $data): bool;
    public function update(string $table, array $data, array $conditions): bool;
    public function delete(array $conditions):bool;
}
