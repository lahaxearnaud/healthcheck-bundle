<?php

namespace Alahaxe\HealthCheckBundle\Tests\DependencyInjection;

use Alahaxe\HealthCheckBundle\DependencyInjection\Configuration;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\NodeInterface;

class ConfigurationTest extends KernelTestCase
{

    public function testThatConfigurationTreeIsValid()
    {
        $configuration = new Configuration();
        $treeBuilder = $configuration->getConfigTreeBuilder();
        $this->assertInstanceOf(TreeBuilder::class, $treeBuilder);
        $tree = $treeBuilder->buildTree();
        $this->assertInstanceOf(NodeInterface::class, $tree);
    }
}
