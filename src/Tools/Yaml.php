<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Tools;

use Symfony\Component\Yaml\Yaml as SymfonyYaml;

class Yaml
{
    /**
     * Parses a YAML file as an array
     *
     * @param string $file full/path/to/file
     *
     * @return array<mixed>
     */
    public static function parse(string $file): array
    {
        /** @var array<mixed> */
        $result = yaml_parse_file($file) ?? [];
        if (!empty($result)) {
            array_walk_recursive($result, function (&$value, $key) {
                if (is_string($value)) {
                    $value = EnvProcessor::resolve(strval($value));
                }
            });
        }

        return $result;
    }
}
