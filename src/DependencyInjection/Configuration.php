<?php

namespace Alahaxe\HealthCheckBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder():TreeBuilder
    {
        $treeBuilder = new TreeBuilder('health_check');

        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->arrayNode('http')
                    ->children()
                        ->enumNode('format')
                            ->values(['full', 'minimal'])
                            ->defaultValue('minimal')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('cli')
                    ->children()
                        ->enumNode('format')
                        ->values(['full'])
                        ->defaultValue('full')
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
