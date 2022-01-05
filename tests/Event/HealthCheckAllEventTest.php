<?php
namespace Alahaxe\HealthCheckBundle\Tests\Event;

use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Alahaxe\HealthCheckBundle\Event\HealthCheckAllEvent;
use Alahaxe\HealthCheckBundle\Event\HealthCheckEvent;
use Alahaxe\HealthCheckBundle\Service\Check\AppCheck;
use Alahaxe\HealthCheckBundle\Service\HealthCheckService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;

class HealthCheckAllEventTest extends TestCase
{
    public function testThatEventIsTriggered()
    {
        $dispatcher = new EventDispatcher();
        $service = new HealthCheckService(
            [new AppCheck()],
            [],
            $dispatcher
        );

        $eventTriggered = false;
        $dispatcher->addListener(HealthCheckAllEvent::class, function (HealthCheckAllEvent $event) use (&$eventTriggered) {
            $eventTriggered = true;
            $checks = $event->getChecks();
            $this->assertIsArray($checks);
            $this->assertNotEmpty($checks);
            $this->assertCount(1, $checks);
            foreach ($checks as $check) {
                $this->assertInstanceOf(CheckStatusInterface::class, $check);
            }
        });

        $service->generateStatus();

        $this->assertTrue($eventTriggered);
    }
}
