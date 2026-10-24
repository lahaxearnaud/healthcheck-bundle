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

        $httpNode = $rootNode->children()->arrayNode('http');
        $httpNode->children()
            ->enumNode('format')
            ->values(['full', 'minimal'])
            ->defaultValue('minimal');

        $cliNode = $rootNode->children()->arrayNode('cli');
        $cliNode->children()
            ->enumNode('format')
            ->values(['full'])
            ->defaultValue('full');

        return $treeBuilder;
    }
}
