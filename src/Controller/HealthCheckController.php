<?php

namespace Alahaxe\HealthCheckBundle\Controller;

use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Alahaxe\HealthCheckBundle\Service\HealthCheckService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class HealthCheckController extends AbstractController
{
    public function __invoke(HealthCheckService $healthCheckService):JsonResponse
    {
        $result = $healthCheckService->generateStatus();

        $httpStatus = (int) max(array_map(static function (CheckStatusInterface $checkStatus):int {
            return $checkStatus->getHttpStatus();
        }, $result));

        return $this->json($result, $httpStatus);
    }
}
