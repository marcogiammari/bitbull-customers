<?php

declare(strict_types=1);

namespace Services;

use Exception;

class CsvReader
{
    public static function getContentAsArray(string $path): array
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

        return $data;
    }
}
