<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Tools;

use RuntimeException;

/**
 * Performs a case-insensitive check of the current environment (ENV) variable.
 */
class EnvObserver
{
    /**
     * @param string $env
     *
     * @throws RuntimeException
     *
     * @return bool
     */
    private static function checkEnv(string $env): bool
    {
        $currentEnv = \getenv('ENV') ?: \getenv('env');

        if (!empty($currentEnv)) {
            return (bool) \preg_match("/($env)/i", $currentEnv);
        }

        throw new RuntimeException("ENV is not defined.", 500);
    }

    /**
     * Checks if env variable `ENV` contains "prod"
     *
     * @return bool
     */
    public static function isProd(): bool
    {
        return self::checkEnv("prod");
    }

    /**
     * Checks if env variable `ENV` contains "preprod"
     *
     * @return bool
     */
    public static function isPreprod(): bool
    {
        return self::checkEnv("preprod");
    }

    /**
     * Checks if env variable `ENV` contains "local"
     *
     * @return bool
     */
    public static function isLocal(): bool
    {
        return self::checkEnv("local");
    }

    /**
     * Checks if env variable `ENV` contains "dev"
     *
     * @return bool
     */
    public static function isDev(): bool
    {
        return self::checkEnv("dev");
    }
}
