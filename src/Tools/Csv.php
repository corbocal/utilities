<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Tools;

class Csv
{
    private function __construct()
    {
    }

    /**
     * Converts a .csv file into an associative array.\
     * __Works only if the .csv first row contains the column's label/name.__ \
     * Each row becomes an associative array indexed by the column's label/name.
     * @param string $path The path to the desired .csv file.
     * @param string $separator The .csv field delimiter. *Default:* `;` (semicolon).
     * @return array<array<string,string|null>>
     */
    public static function fileContentToArray(string $path, string $separator = ";"): array
    {
        $result = [];

        if (\is_file($path)) {
            $dataFromFile = \file($path);
            if ($dataFromFile !== false) {
                $data = \array_map(
                    fn($v) => \str_getcsv($v, $separator),
                    $dataFromFile
                );

                foreach ($data as $data_row) {
                    $row = [];
                    for ($i = 0; $i < \count($data[0]); $i++) {
                        $row[$data[0][$i]] = $data_row[$i];
                    }
                    $result[] = $row;
                }
                \array_shift($result);
            }
        }

        return $result;
    }
}
