<?php

namespace Alahaxe\HealthCheckBundle\Tests\Fixture;

use Alahaxe\HealthCheck\Contracts\CheckInterface;
use Alahaxe\HealthCheck\Contracts\CheckStatus;
use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;

class WarningCheck implements CheckInterface
{
    public function check(): CheckStatusInterface
    {
        return new CheckStatus('warning', self::class,CheckStatusInterface::STATUS_WARNING);
    }
}
