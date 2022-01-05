<?php

namespace Alahaxe\HealthCheckBundle\Service\Reporter;

use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Alahaxe\HealthCheckBundle\Service\HealthCheckService;
use Symfony\Component\HttpFoundation\JsonResponse;

class HttpFullReporter extends HttpMinimalReporter
{
    /**
     * @inheritDoc
     */
    public function format(array $checkStatuses, array $context):array
    {
        return [
            'context' => $context,
            'health' => $this->calculateHttpCode($checkStatuses) === JsonResponse::HTTP_OK,
            'checks' => $checkStatuses,
        ];
    }
}
