<?php

namespace App\Domain;

use Ddd\Domain\DomainEvent;
use Ddd\Domain\DomainEventPublisher;

class Aggregate
{
    public function recordThat(DomainEvent $domainEvent)
    {
        DomainEventPublisher::instance()->publish($domainEvent);
    }
}
