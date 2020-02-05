<?php

declare(strict_types = 1);

namespace App\Domain\Shared\ValueObjects;

class Ipv4ValueObject
{
    /**
     * @var string
     */
    protected $value;

    /**
     * Class constructor.
     *
     * @return void
     */
    private function __construct(string $value)
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

        if (!filter_var($value, FILTER_VALIDATE_IP)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid ip address',
                    $value
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
}
