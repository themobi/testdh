<?php

declare(strict_types = 1);

namespace App\Domain\Shared\ValueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    protected $value;

    protected function __construct(string $value)
    {
        $this->value = $value;
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    protected static function ensureIsValid($id): void
    {
        if (null === $id) {
            throw new \InvalidArgumentException(
                sprintf(
                    '"%s" can not be empty',
                    get_called_class()
                )
            );
        }

        if (!RamseyUuid::isValid($id)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '<%s> does not allow the value <%s>.',
                    static::class,
                    is_scalar($id) ? $id : gettype($id)
                )
            );
        }
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public static function fromValue(?string $value): self
    {
        self::ensureIsValid($value);

        return new static($value);
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function toValue(): string
    {
        return $this->value;
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function __toString()
    {
        return $this->value;
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public static function random(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public static function generate(): self
    {
        $value = RamseyUuid::uuid4()->toString();

        self::ensureIsValid($value);

        return new static($value);
    }
}
