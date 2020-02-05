<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObjects;

class DateAndTime
{
    /**
     * @var string
     */
    protected $datetime;

    /**
     * Class constructor.
     *
     * @return void
     */
    private function __construct(string $datetime)
    {
        $this->datetime = $datetime;
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    protected static function isValid($datetime): void
    {
        if (null === $datetime) {
            throw new \InvalidArgumentException(
                sprintf(
                    '"%s" can not be empty',
                    get_called_class()
                )
            );
        }

        if (!\DateTime::createFromFormat('Y-m-d H:i:s', $datetime)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid date and time',
                    $datetime
                )
            );
        }
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public static function fromValue(?string $datetime): self
    {
        self::isValid($datetime);

        return new static($datetime);
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function toValue(): string
    {
        return $this->datetime;
    }
}
