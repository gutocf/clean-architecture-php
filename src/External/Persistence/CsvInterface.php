<?php

namespace App\External\Persistence;

interface CsvInterface
{
    /**
     * Reads a CSV file and returns all records.
     *
     * @param  string $filename Name of the file to read.
     * @return array
     */
    public function read(string $filename): array;

    /**
     * Counts the number of records in a CSV file.
     *
     * @param  string $filename Name of the file to read.
     * @return int
     */
    public function count(string $filename): int;

    /**
     * Writes a CSV file. Overrides the existing file.
     *
     * @param  string $filename Name of the file to write.
     * @param  array  $records  Records to write.
     * @return bool
     */
    public function write(string $filename, array $records);
}
