<?php

namespace Remdan\EasysysConnectorBundle\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ResourceManagerCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('remdan.easysysconnector')) {
            return;
        }

        $resourceManagers = array();

        $taggedServices = $container->findTaggedServiceIds('remdan.easysysconnector.resource_manager');
        foreach ($taggedServices as $id => $attributes) {
            $resourceManagers[] = new Reference($id);
        }

        $definition = $container->getDefinition('remdan.easysysconnector');
        $definition->replaceArgument(2, $resourceManagers);
    }
}