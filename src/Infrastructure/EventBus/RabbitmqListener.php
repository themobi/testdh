<?php

namespace App\Infrastructure\EventBus;

use Ddd\Domain\DomainEvent;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use App\Infrastructure\EventBus\DomainEventListener;

class RabbitmqListener
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
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function listen()
    {
        /**
         * don't dispatch a new message to a worker until it has processed and
         * acknowledged the previous one. Instead, it will dispatch it to the
         * next worker that is not still busy.
         * # global=true to mean that the QoS settings should apply per-channel
         */
        $this->channel->basic_qos(
            null,   #prefetch size - prefetch window size in octets, null meaning "no specific limit"
            1,      #prefetch count - prefetch window in terms of whole messages
            null    #global - global=null to mean that the QoS settings should apply per-consumer,
        );

        /**
         * indicate interest in consuming messages from a particular queue. When they do
         * so, we say that they register a consumer or, simply put, subscribe to a queue.
         * Each consumer (subscription) has an identifier called a consumer tag
         */
        $this->channel->basic_consume(
            $this->exchangeName,          #queue
            '', #consumer tag - Identifier for the consumer, valid within the current channel. just string
            false, #no local - TRUE: the server will not send messages to the connection that published them
            false, #no ack, false - acks turned on, true - off.  send a proper acknowledgment once done with a task
            false, #exclusive - queues may only be accessed by the current connection
            false,  #no wait - TRUE: the server will not respond. The client should not wait for a reply method
            array($this, 'process') #callback
        );

        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }

        $this->channel->close();
        $this->connection->close();
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function process(AMQPMessage $message)
    {
        //echo ' [x] Received ', $message->body, "\n";

        DomainEventListener::instance()->publish(json_decode($message->body));
        /**
         * If a consumer dies without sending an acknowledgement the AMQP broker
         * will redeliver it to another consumer or, if none are available at the
         * time, the broker will wait until at least one consumer is registered
         * for the same queue before attempting redelivery
         */
        $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
    }
}
