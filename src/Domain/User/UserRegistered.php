<?php

namespace App\Domain\User;

use Ddd\Domain\DomainEvent;
use Ddd\Domain\Event\PublishableDomainEvent;

class UserRegistered implements DomainEvent, PublishableDomainEvent
{
   /**
     * @var NameOfUser
     */
    protected $nameofuser;

    /**
     * @var EmailAddress
     */
    protected $email;

    /**
     * @var \DateTimeImmutable
     */
    private $occurredOn;

    public function __construct(NameOfUser $nameofuser, EmailAddress $email)
    {
        $this->nameofuser = $nameofuser;
        $this->email = $email;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function nameOfUser()
    {
        return $this->nameofuser;
    }

    public function email()
    {
        return $this->email;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn()
    {
        return $this->occurredOn;
    }
}
