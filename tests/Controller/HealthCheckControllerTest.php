<?php

namespace Alahaxe\HealthCheckBundle\Tests\Controller;

use Alahaxe\HealthCheckBundle\Controller\HealthCheckController;
use Alahaxe\HealthCheckBundle\Service\HealthCheckService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HealthCheckControllerTest extends WebTestCase
{
    protected ?HealthCheckController $healthCheckController;

    protected function setUp():void
    {
        parent::setUp();

        self::bootKernel();
        $this->healthCheckController = self::getContainer()->get(HealthCheckController::class);
    }

    public function testHealthCheck():void
    {
        /** @var HealthCheckService $healthCheckService */
        $healthCheckService = self::getContainer()->get(HealthCheckService::class);
        $response = $this->healthCheckController->__invoke($healthCheckService);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
        $result = json_decode($response->getContent(), true);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('context', $result);
        $this->assertIsArray($result['context']);
        $this->assertArrayHasKey('health', $result);
        $this->assertIsBool($result['health']);
        $this->assertArrayHasKey('checks', $result);
        $this->assertIsArray($result['checks']);

    }
}
