<?php

namespace Remdan\EasysysConnectorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('remdan_easysys_connector');

        $rootNode
            ->children()
                ->scalarNode('http_adapter')
                    ->treatNullLike('remdan.easysysconnector.http_adapter.curl')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('auth_adapter')
                    ->treatNullLike('remdan.easysysconnector.auth_adapter.token')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('auth')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->children()
                        ->arrayNode('token')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->children()
                                ->scalarNode('company')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('public_key')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('signature_key')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('user_id')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->arrayNode('resource_manager')
                ->useAttributeAsKey('id')
                ->isRequired()
                ->requiresAtLeastOneElement()
                ->prototype('array')
                    ->children()
                        ->scalarNode('class')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('converter')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}