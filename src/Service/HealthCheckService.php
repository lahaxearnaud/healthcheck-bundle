<?php

namespace Alahaxe\HealthCheckBundle\Service;

use Alahaxe\HealthCheck\Contracts\CheckInterface;
use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Alahaxe\HealthCheckBundle\CheckStatus;

class HealthCheckService
{
    /**
     * @param iterable<CheckStatus> $checks
     */
    public function __construct(
        protected iterable $checks
    ) {
    }

    /**
     * @return CheckStatusInterface[]
     */
    public function generateStatus():array
    {
        $result = [];

        /** @var CheckInterface $check */
        foreach ($this->checks as $check) {
            $status = $check->check();
            $result[$status->getAttributeName()] = $status;
        }

        return $result;
    }
}
