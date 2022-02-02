<?php

namespace App\External\Persistence;

interface CsvInterface
{
    public function read(string $file);
    public function write(string $file, array $data);
}
