<?php

namespace Alahaxe\HealthCheckBundle\Controller;

use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Alahaxe\HealthCheckBundle\Service\HealthCheckService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HealthCheckController extends AbstractController
{
    public function __invoke(HealthCheckService $healthCheckService):JsonResponse
    {
        $result = $healthCheckService->generateStatus();

        $httpStatus = (int) max(array_map(static function (CheckStatusInterface $checkStatus):int {
            return $checkStatus->getHttpStatus();
        }, $result));

        $response = $this->json(
            [
                'context' => $healthCheckService->generateContext(),
                'health' => $httpStatus === JsonResponse::HTTP_OK,
                'checks' => $result,
            ],
            $httpStatus,
            [
                ''
            ]
        );

        $response->setCache([
            'no_cache' => true,
            'no_store' => true,
            'max_age' => 0,
            's_maxage' => 0,
        ]);

        return $response;
    }
}
