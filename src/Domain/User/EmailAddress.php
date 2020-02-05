<?php

declare(strict_types = 1);

namespace App\Domain\User;

use Assert\Assertion;

class EmailAddress
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

    public static function fromValue(string $value): self
    {
        $value = trim($value);

        Assertion::email($value);

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
