<?php

namespace Alahaxe\HealthCheckBundle\Service\Reporter;

use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractReporter implements ReporterInterface
{
    /**
     * @inheritDoc
     */
    public function calculateHttpCode(array $checkStatuses):int
    {
        if ($checkStatuses === []) {
            return Response::HTTP_OK;
        }

        return (int) max(array_map(static function (CheckStatusInterface $checkStatus):int {
            return $checkStatus->getHttpStatus();
        }, $checkStatuses));
    }
}
