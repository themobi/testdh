<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Infrastructure\EventBus\RabbitmqListener;
use App\Infrastructure\EventBus\DomainEventListener;

final class EventListenerCommand extends Command
{
    protected static $defaultName = 'dh:api:event-listener';

    protected $eventListener;

    public function __construct(RabbitmqListener $eventListener, DomainEventListener $domainEventListener)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->eventListener = $eventListener;

        parent::__construct();
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Listen dh events.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command listen dh events')
        ;
    }
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->eventListener->listen();
    }
}
