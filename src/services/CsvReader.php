<?php

declare(strict_types=1);

namespace Service;

use Exception;

class CsvReader
{
    public static function getRandomVatFromCsv(string $path): string
    {
        $data = [];
        if (!file_exists($path)) {
            return  "File not found";
        }

        try {

            $vatFile = fopen($path, 'r');
            while (($line = fgetcsv($vatFile)) !== false) {

                $data[] = $line[0];
            }

            fclose($vatFile);
        } catch (Exception $e) {
            throw $e->getMessage();
        }

        return $data[rand(0, count($data) - 1)];
    }
}
