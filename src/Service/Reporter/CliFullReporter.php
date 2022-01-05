<?php

namespace Alahaxe\HealthCheckBundle\Service\Reporter;

use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Alahaxe\HealthCheckBundle\Service\HealthCheckService;
use Symfony\Component\HttpFoundation\JsonResponse;

class CliFullReporter extends AbstractReporter
{
    /**
     * @inheritDoc
     */
    public function format(array $checkStatuses, array $context):array
    {
        return array_map(
            static function (CheckStatusInterface $checkStatus):array {
                return [
                    $checkStatus->getAttributeName(),
                    $checkStatus->getStatus(),
                    $checkStatus->getHttpStatus(),
                    $checkStatus->getCheckerClass(),
                    $checkStatus->getPayload(),
                ];
            },
            $checkStatuses
        );
    }
}
