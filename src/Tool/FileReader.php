<?php

namespace App\Tool;

class FileReader
{
    /**
     * @var string
     */
    private $file;

    /**
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->file = $filePath;
    }

    /**
     * @return \Generator
     */
    public function getFileLines(): \Generator
    {
        $file = fopen($this->file, 'r');
        fgetcsv($file);
        while (($row = fgetcsv($file)) !== false) {
            yield $row;
        }

        fclose($file);
    }
}