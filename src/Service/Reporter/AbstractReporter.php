<?php

namespace Alahaxe\HealthCheckBundle\Service\Reporter;

use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;

abstract class AbstractReporter implements ReporterInterface
{
    /**
     * @inheritDoc
     */
    public function calculateHttpCode(array $checkStatuses):int
    {
        return (int) max(array_map(static function (CheckStatusInterface $checkStatus):int {
            return $checkStatus->getHttpStatus();
        }, $checkStatuses));
    }
}
