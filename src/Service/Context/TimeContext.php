<?php
namespace Alahaxe\HealthCheckBundle\Service\Context;


use Alahaxe\HealthCheck\Contracts\ContextProviderInterface;

class TimeContext implements ContextProviderInterface
{
    public function getValue(): string|array|int|float|\JsonSerializable
    {
        return (new \DateTime())->format(DATE_ATOM);
    }

    public function getName(): string
    {
        return 'datetime';
    }
}
