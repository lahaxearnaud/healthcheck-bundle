<?php

namespace Alahaxe\HealthCheckBundle\Tests\Service;

use Alahaxe\HealthCheck\Contracts\CheckStatus;
use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Alahaxe\HealthCheckBundle\Service\HealthCheckService;
use Alahaxe\HealthCheckBundle\Tests\Fixture\ExceptionCheck;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HealthCheckServiceTest extends KernelTestCase
{
    protected ?HealthCheckService $healthCheckService = null;

    protected function setUp():void
    {
        parent::setUp();

        self::bootKernel();
        $this->healthCheckService = self::getContainer()->get(HealthCheckService::class);
    }

    public function testServiceIsAvailable()
    {
        $this->assertInstanceOf(HealthCheckService::class, $this->healthCheckService);
        $this->assertNotNull($this->healthCheckService);
    }

    public function testGenerateContext()
    {
        $result = $this->healthCheckService->generateContext();
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('environment', $result);
        $this->assertArrayHasKey('datetime', $result);
        $this->assertIsString($result['environment']);
        $this->assertIsString($result['datetime']);
        $this->assertIsInt(strtotime($result['datetime']));
    }

    public function testGenerateStatus()
    {
        $result = $this->healthCheckService->generateStatus();
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        // dummy check that is always OK
        $this->assertArrayHasKey('app', $result);
        $this->assertInstanceOf(CheckStatus::class, $result['app']);
        $this->assertEquals(CheckStatusInterface::STATUS_OK, $result['app']->getStatus());

    }

    public function testGenerateStatusWithException()
    {
        $healthCheckService = new HealthCheckService(
            [new ExceptionCheck()],
            []
        );
        $result = $healthCheckService->generateStatus();
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);

        // dummy check that is always OK
        $this->assertArrayHasKey('global', $result);
        $this->assertInstanceOf(CheckStatus::class, $result['global']);
        $this->assertEquals(CheckStatusInterface::STATUS_INCIDENT, $result['global']->getStatus());

    }
}
