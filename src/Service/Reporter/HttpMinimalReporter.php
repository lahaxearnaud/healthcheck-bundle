<?php

namespace Alahaxe\HealthCheckBundle\Service\Reporter;

use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Alahaxe\HealthCheckBundle\Service\HealthCheckService;
use Symfony\Component\HttpFoundation\JsonResponse;

class HttpMinimalReporter extends AbstractReporter
{
    /**
     * @inheritDoc
     */
    public function format(array $checkStatuses, array $context):array
    {
        return [
            'health' => $this->calculateHttpCode($checkStatuses) === JsonResponse::HTTP_OK,
        ];
    }
}
