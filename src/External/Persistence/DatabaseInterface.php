<?php

namespace App\External\Persistence;

interface DatabaseInterface
{
    public function execute(string $query);
    public function select(string $table, array $fields, array $conditions);
    public function insert(string $table, array $data);
    public function update(string $table, array $data, array $conditions);
    public function delete(array $conditions);
}
