<?php

namespace App\External\Persistence;

use League\Csv\Reader;

class CsvHandler implements CsvInterface
{
    public function read(string $file)
    {
        $csv = Reader::createFromPath(ROOT . 'data' . DS . $file . '.csv');

        return $csv->getRecords();
    }

    public function write(string $file, array $data)
    {
    }
}
