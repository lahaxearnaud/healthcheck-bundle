<?php

namespace Alahaxe\HealthCheckBundle\Service;

use Alahaxe\HealthCheckBundle\CheckStatus;
use Alahaxe\HealthCheckBundle\Contract\CheckInterface;

class HealthCheckService
{
    public function __construct(
        protected iterable $checks
    ) {
    }

    /**
     * @return CheckStatus[]
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
