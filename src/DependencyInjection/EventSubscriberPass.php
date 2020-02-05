<?php

namespace App\DependencyInjection;

use App\Domain\DomainEventPublisher;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

final class EventSubscriberPass implements CompilerPassInterface
{
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        // always first check if the primary service is defined
        if (!$container->has(DomainEventPublisher::class)) {
            return;
        }

        $definition = $container->findDefinition(DomainEventPublisher::class);
        // find all service IDs with the dh.event_subscribers tag
        $taggedServices = $container->findTaggedServiceIds('dh.event_subscribers');

        foreach ($taggedServices as $id => $tags) {
            // add the transport service to the TransportChain service
            $definition->addMethodCall('subscribe', [new Reference($id)]);
        }
    }
}
