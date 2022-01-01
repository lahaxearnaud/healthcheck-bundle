<?php

namespace Alahaxe\HealthCheckBundle\Tests\Fixture;

use Alahaxe\HealthCheck\Contracts\CheckInterface;
use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;

class ExceptionCheck implements CheckInterface
{
    public function check(): CheckStatusInterface
    {
        throw new \RuntimeException();
    }
}
