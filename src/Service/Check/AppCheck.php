<?php

namespace Alahaxe\HealthCheckBundle\Service\Check;

use Alahaxe\HealthCheck\Contracts\CheckInterface;
use Alahaxe\HealthCheck\Contracts\CheckStatus;
use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;

class AppCheck implements CheckInterface
{
    public function check(): CheckStatusInterface
    {
        return new CheckStatus(
            'app',
            __CLASS__,
            CheckStatus::STATUS_OK
        );
    }
}
