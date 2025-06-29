<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Enums\Traits;

trait EnumUtilsTrait
{
    /**
     * Returns all cases names from the enum as strings
     *
     * @return string[]
     */
    public static function allNames(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Returns all cases values from the enum as strings
     *
     * @return int[]|string[]
     */
    public static function allValues(): array
    {
        return array_column(self::cases(), 'values');
    }
}
