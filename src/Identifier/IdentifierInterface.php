<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Identifier;

interface IdentifierInterface
{
    public function getType(): string;

    public function getValue(): string;
}
