<?php

namespace App\DependencyInjection;

use App\Infrastructure\EventBus\DomainEventListener;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

final class EventListenerPass implements CompilerPassInterface
{
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        // always first check if the primary service is defined
        if (!$container->has(DomainEventListener::class)) {
            return;
        }

        $definition = $container->findDefinition(DomainEventListener::class);
        // find all service IDs with the dh.event_listeners tag
        $taggedServices = $container->findTaggedServiceIds('h.event_listeners');

        foreach ($taggedServices as $id => $tags) {
            // add the transport service to the TransportChain service
            $definition->addMethodCall('subscribe', [new Reference($id)]);
        }
    }
}
