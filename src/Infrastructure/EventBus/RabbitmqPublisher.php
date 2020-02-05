<?php

namespace App\Infrastructure\EventBus;

use Ddd\Domain\DomainEvent;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitmqPublisher implements EventProducer
{
    /**
     * @var connection
     */
    protected $connection;

    /**
     * @var exchangeName
     */
    protected $exchangeName;

    /**
     * @var channel
     */
    protected $channel;

    /**
     * @param AMQPStreamConnection $connection
     * @param string $exchangeType
     * @param bool $passive
     * @param bool $durable
     * @param bool $auto_delete
     */
    public function __construct(
        AMQPStreamConnection $connection,
        string $exchangeName,
        string $exchangeType,
        bool $passive = false,
        bool $durable = true,
        bool $auto_delete = false,
        bool $exclusive = false
    ) {
        $this->connection = $connection;

        $this->exchangeName = $exchangeName;

        $this->channel = $this->connection->channel();

        $this->channel->exchange_declare(
            $exchangeName,
            $exchangeType,
            $passive,
            $durable,
            $auto_delete
        );

        $this->channel->queue_declare(
            $exchangeName,
            $passive,
            $durable,
            $exclusive,
            $auto_delete
        );
    }

    public function publish(DomainEvent $domainEvent)
    {
        $eventHeaders = [
            "event_name" => substr(strrchr(get_class($domainEvent), '\\'), 1)
        ];
        
        $eventBody = get_object_vars($domainEvent);

        $event = [
            "event_header" => $eventHeaders,
            "event_body" => $eventBody
        ];

        $this->channel->basic_publish(
            new AMQPMessage(json_encode($event)),
            $this->exchangeName
        );
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
