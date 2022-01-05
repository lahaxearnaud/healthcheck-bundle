<?php
namespace Alahaxe\HealthCheckBundle\Event\Subscriber;

use Alahaxe\HealthCheckBundle\Event\HealthCheckAllEvent;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LoggerSubscriber implements EventSubscriberInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public static function getSubscribedEvents(): array
    {
        return [
            HealthCheckAllEvent::class => [
                ['onHealthCheckAllEvent'],
            ],
        ];
    }

    public function onHealthCheckAllEvent(HealthCheckAllEvent $event): void
    {
        if ($this->logger !== null) {
            $this->logger->notice((string) json_encode($event->getChecks()));
        }
    }
}
