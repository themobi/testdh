<?php

declare(strict_types = 1);

namespace App\Domain\User;

use Assert\Assertion;

class Password
{
    const MAX_LENGTH = 16;

    const MIN_LENGTH = 6;

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

    public static function fromValue(string $value): self
    {
        $value = trim($value);

        Assertion::minLength($value, self::MIN_LENGTH);

        Assertion::lessOrEqualThan($value, self::MAX_LENGTH);

        return new static($value);
    }

    public function toValue(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
