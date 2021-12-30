<?php

namespace Alahaxe\HealthCheckBundle\Service\Check;

use Alahaxe\HealthCheckBundle\CheckStatus;
use Alahaxe\HealthCheckBundle\Contract\CheckInterface;

class AppCheck implements CheckInterface
{
    public function check(): CheckStatus
    {
        return new CheckStatus(
            'app',
            __CLASS__,
            CheckStatus::STATUS_OK
        );
    }
}
