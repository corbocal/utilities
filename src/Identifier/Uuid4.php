<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Identifier;

use Corbocal\Utilities\Identifier\AbstractIdentifier;
use Ramsey\Uuid\Uuid as RamseyUuid;

final class Uuid4 extends AbstractIdentifier
{
    protected string $type = "uuid-v4";
    protected string $regex = '/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i';

    public function __construct(string $forcedValue)
    {
        parent::__construct($forcedValue);
    }

    /**
     * Generate a new UUID v4 identifier.
     */
    public static function generate(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }
}
