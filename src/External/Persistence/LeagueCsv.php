<?php

namespace App\External\Persistence;

use ArrayIterator;
use League\Csv\Reader;
use League\Csv\Writer;

class LeagueCsv implements CsvInterface
{

    public function read(string $filename): array
    {
        $path = $this->getPath($filename);
        $reader = Reader::createFromPath($path);

        return collection($reader->getRecords())->toArray();
    }

    public function write(string $filename, array $records)
    {
        $path = $this->getPath($filename);
        $csv = Writer::createFromPath($path, 'w+');
        $csv->insertAll(new ArrayIterator($records));

        return true;
    }

    private function getPath(string $file): string
    {
        return ROOT . 'data' . DS . $file . '.csv';
    }
}
