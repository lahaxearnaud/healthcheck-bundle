<?php
namespace Alahaxe\HealthCheckBundle\Tests\Event\Subscriber;

use Alahaxe\HealthCheckBundle\Event\Subscriber\LoggerSubscriber;
use Alahaxe\HealthCheckBundle\Service\HealthCheckService;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;
use Psr\Log\Test\TestLogger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LoggerSubscriberTest extends KernelTestCase
{
    public function testLoggerSubscriber()
    {
        self::bootKernel();

        $mockLogger = $this->getMockBuilder(NullLogger::class)->getMock();

        $mockLogger->expects($this->once())->method(LogLevel::NOTICE);

        $loggerSubscriber = self::getContainer()->get(LoggerSubscriber::class);
        $loggerSubscriber->setLogger($mockLogger);

        $healthCheckService = self::getContainer()->get(HealthCheckService::class);
        $healthCheckService->generateStatus();
    }
}
