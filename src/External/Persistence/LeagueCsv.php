<?php

namespace App\External\Persistence;

use ArrayIterator;
use League\Csv\Reader;
use League\Csv\Writer;

class LeagueCsv implements CsvInterface
{

    /**
     * @inheritdoc
     */
    public function read(string $filename): array
    {
        $path = $this->getPath($filename);
        $reader = Reader::createFromPath($path);

        return collection($reader->getRecords())->toArray();
    }

    /**
     * @inheritdoc
     */
    public function count(string $filename): int
    {
        $path = $this->getPath($filename);
        $reader = Reader::createFromPath($path);

        return $reader->count();
    }

    /**
     * @inheritdoc
     */
    public function write(string $filename, array $records)
    {
        $path = $this->getPath($filename);
        $csv = Writer::createFromPath($path, 'w+');
        $csv->insertAll(new ArrayIterator($records));

        return true;
    }

    /**
     * Gets the path to the CSV file.
     *
     * @param string $filename Name of the file.
     * @return string
     */
    private function getPath(string $filename): string
    {
        return ROOT . 'data' . DS . $filename . '.csv';
    }
}
