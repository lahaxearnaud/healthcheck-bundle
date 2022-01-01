<?php

namespace Alahaxe\HealthCheckBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HelloWorldTest extends KernelTestCase
{
    public function testThatBundleCanBeLoaded()
    {
        self::bootKernel();

        $this->assertTrue(true);
    }
}
