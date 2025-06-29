<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Tools;

/**
 * Recovers and resolves env variables references from a string
 */
class EnvProcessor
{
    private const string PATTERN = '/[\'\"]?%env\(([a-zA-Z_\d]*)\)%[\'\"]?/';

    private function __construct()
    {
    }

    public static function resolve(string $value): ?string
    {
        $var = null;
        $match = \preg_match(self::PATTERN, $value);
        if ($match === 1) {
            $varName = \preg_replace(self::PATTERN, '$1', $value);
            if (!empty($varName)) {
                $var = \getenv($varName);
            }
        } else {
            $var = $value;
        }

        return $var ?: null;
    }
}
