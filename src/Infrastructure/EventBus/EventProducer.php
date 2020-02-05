<?php

namespace App\Infrastructure\EventBus;

use Ddd\Domain\DomainEvent;

interface EventProducer
{
    public function publish(DomainEvent $domainEvent);
}
