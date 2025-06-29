<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Identifier;

/**
 * Unique identifier for an entity/aggregate root.
 */
abstract class AbstractIdentifier implements IdentifierInterface
{
    protected string $value;
    protected string $type;
    protected string $regex;

    public function __construct(string $forcedValue)
    {
        if (preg_match($this->regex, (string) $forcedValue) !== 1) {
            $classname = substr(static::class, strripos(static::class, '\\') + 1);
            throw new \UnexpectedValueException(
                "$classname.php : The value `$forcedValue` is not of the correct format.",
                500
            );
        }
        $this->value = $forcedValue;
    }

    abstract public static function generate(): self;

    public function getValue(): string
    {
        return $this->value;
    }

    public function getType(): string
    {
        return $this->value;
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'type' => $this->type,
        ];
    }

    public function __tostring(): string
    {
        return (string) json_encode($this->toArray());
    }
}
