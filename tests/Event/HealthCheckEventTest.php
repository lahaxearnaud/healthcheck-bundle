<?php
namespace Alahaxe\HealthCheckBundle\Tests\Event;

use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Alahaxe\HealthCheckBundle\Event\HealthCheckEvent;
use Alahaxe\HealthCheckBundle\Service\Check\AppCheck;
use Alahaxe\HealthCheckBundle\Service\HealthCheckService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;

class HealthCheckEventTest extends TestCase
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
        $dispatcher->addListener(HealthCheckEvent::class, function (HealthCheckEvent $event) use (&$eventTriggered) {
            $eventTriggered = true;
            $this->assertInstanceOf(CheckStatusInterface::class, $event->getCheck());
        });

        $service->generateStatus();
        
        $this->assertTrue($eventTriggered);
    }
}
