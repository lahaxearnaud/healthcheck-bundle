<?php
namespace Alahaxe\HealthCheckBundle\Event;

use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;

class HealthCheckEvent
{
    public function __construct(
        protected CheckStatusInterface $check
    ) {
    }

    public function getCheck(): CheckStatusInterface
    {
        return $this->check;
    }
}
