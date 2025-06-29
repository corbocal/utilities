<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Tools;

use Symfony\Component\Yaml\Yaml as SymfonyYaml;

class Yaml
{
    private static function getContent(string $pathTofile): string
    {
        $content = file_get_contents($pathTofile);
        if ($content === false) {
            throw new \InvalidArgumentException(
                "Unable to read file $pathTofile.",
                500
            );
        }

        return $content;
    }

    /**
     * Parses a YAML file as an array
     *
     * @param string $file /path/to/file
     *
     * @return array<mixed>
     */
    public static function parse(string $file): array
    {
        /** @var array<mixed> */
        $result = SymfonyYaml::parse(self::getContent($file)) ?? [];
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
