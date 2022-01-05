<?php

namespace Alahaxe\HealthCheckBundle\Controller;

use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Alahaxe\HealthCheckBundle\Service\HealthCheckService;
use Alahaxe\HealthCheckBundle\Service\Reporter\ReporterFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HealthCheckController extends AbstractController
{
    public function __construct(
        protected ReporterFactory $reporterFactory,
        protected HealthCheckService $healthCheckService
    ) {
    }

    public function __invoke():JsonResponse
    {
        $result = $this->healthCheckService->generateStatus();
        $reporter = $this->reporterFactory->forge();

        $response = $this->json(
            $reporter->format($result, $this->healthCheckService->generateContext()),
            $reporter->calculateHttpCode($result)
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
