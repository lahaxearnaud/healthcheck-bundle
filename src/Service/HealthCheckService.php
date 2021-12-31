<?php

namespace Alahaxe\HealthCheckBundle\Service;

use Alahaxe\HealthCheck\Contracts\CheckInterface;
use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Alahaxe\HealthCheckBundle\Contract\ContextProviderInterface;

class HealthCheckService
{
    /**
     * @param iterable<CheckInterface> $checks
     * @param iterable<ContextProviderInterface> $contextProviders
     */
    public function __construct(
        protected iterable $checks,
        protected iterable $contextProviders,
    ) {
    }

    /**
     * @return array<string, string|array|int|float|\JsonSerializable>
     */
    public function generateContext():array
    {
        $result = [];

        /** @var ContextProviderInterface $contextProviders */
        foreach ($this->contextProviders as $contextProviders) {
            $result[$contextProviders->getName()] = $contextProviders->getValue();
        }

        return $result;
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
