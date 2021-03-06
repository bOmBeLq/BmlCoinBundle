<?php

namespace Bml\CoinBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bml_coin');

        $rootNode
            ->children()
                ->arrayNode('coins') ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('rpc_user')->isRequired()->end()
                            ->scalarNode('rpc_password')->isRequired()->end()
                            ->scalarNode('rpc_port')->isRequired()->end()
                            ->scalarNode('rpc_host')->isRequired()->end()
                            ->scalarNode('rpc_path')->end()
                            ->scalarNode('rpc_protocol')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
