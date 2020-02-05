<?php

namespace App\Infrastructure\EventBus;

use Ddd\Domain\DomainEventSubscriber;

class DomainEventListener
{
    /**
     * @var DomainEventSubscriber[]
     */
    private $subscribers;

    /**
     * @var DomainEventPublisher
     */
    private static $instance = null;

    private $id = 0;
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public static function instance()
    {
        if (null === static::$instance) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    private function __construct()
    {
        $this->subscribers = [];
    }

    public function __clone()
    {
        throw new \BadMethodCallException('Clone is not supported');
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function subscribe(DomainEventSubscriber $eventListener)
    {
        $id = $this->id;
        $this->subscribers[$id] = $eventListener;
        $this->id++;

        return $id;
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function unsubscribe()
    {
        unset($this->subscribers);
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function publish($domainEvent)
    {
        try {
            foreach ($this->subscribers as $subscriber) {
                if ($subscriber->isSubscribedTo($domainEvent)) {
                    $subscriber->handle($domainEvent);
                }
            }
        } catch (\Exception $e) {
            echo $e->getTraceAsString();
        }
    }
}
