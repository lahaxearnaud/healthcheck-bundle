<?php

namespace Alahaxe\HealthCheckBundle\Service;

use Alahaxe\HealthCheck\Contracts\CheckInterface;
use Alahaxe\HealthCheck\Contracts\CheckStatus;
use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Alahaxe\HealthCheck\Contracts\ContextProviderInterface;
use JsonSerializable;

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
     * @return array<string, mixed>
     */
    public function generateContext():array
    {
        $result = [];

        /** @var ContextProviderInterface $contextProvider */
        foreach ($this->contextProviders as $contextProvider) {
            $result[$contextProvider->getName()] = $contextProvider->getValue();
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
            try {
                $status = $check->check();
                $result[$status->getAttributeName()] = $status;
            } catch (\Throwable $throwable) {
                $result['global'] = new CheckStatus(
                    'global',
                    get_class($check),
                    CheckStatus::STATUS_INCIDENT,
                    'Fail to execute check'
                );
            }
        }

        return $result;
    }
}
