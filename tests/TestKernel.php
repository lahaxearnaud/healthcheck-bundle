<?php

namespace Alahaxe\HealthCheckBundle\Tests;

use Alahaxe\HealthCheckBundle\HealthCheckBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    public function registerBundles():array
    {
        return array(
            new FrameworkBundle(),
            new HealthCheckBundle(),
        );
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config.yaml');
    }
}
