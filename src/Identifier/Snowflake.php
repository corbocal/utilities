<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Identifier;

use BradieTilley\Snowflake\Snowflake as BradieTilleySnowflake;
use Corbocal\Utilities\Identifier\AbstractIdentifier;

class Snowflake extends AbstractIdentifier
{
    protected string $type = "snowflake";
    protected string $regex = '/^\d{19}$/i';

    public function __construct(string $forcedValue)
    {
        parent::__construct($forcedValue);
    }

    public static function generate(): self
    {
        self::initializeSnowflake();
        return new self(BradieTilleySnowflake::id());
    }

    private static function initializeSnowflake(): void
    {
        $cluster = 1;
        $worker = 1;
        BradieTilleySnowflake::configure(
            '2016-12-16 00:00:00',
            $cluster,
            $worker
        );
    }
}
