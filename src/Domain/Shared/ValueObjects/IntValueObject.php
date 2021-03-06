<?php

declare(strict_types = 1);

namespace App\Domain\Shared\ValueObjects;

class IntValueObject
{
    /**
     * @var integer
     */
    protected $value;

    /**
     * Class constructor.
     *
     * @return void
     */
    private function __construct(int $value)
    {
        $this->value = $value;
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    protected static function ensureIsValid($value): void
    {
        if (null === $value) {
            throw new \InvalidArgumentException(
                sprintf(
                    '"%s" can not be empty',
                    get_called_class()
                )
            );
        }

        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid',
                    $value
                )
            );
        }
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public static function fromValue(?int $value): self
    {
        self::ensureIsValid($value);

        return new static($value);
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function toValue(): int
    {
        return $this->value;
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function equalsTo(IntValueObject $other): bool
    {
        return $this->toValue() === $other->toValue();
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function isBiggerThan(IntValueObject $other): bool
    {
        return $this->toValue() > $other->toValue();
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function __toString()
    {
        return (string) $this->value;
    }
}
