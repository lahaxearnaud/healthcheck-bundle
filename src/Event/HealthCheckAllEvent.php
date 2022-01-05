<?php
namespace Alahaxe\HealthCheckBundle\Event;

use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;

class HealthCheckAllEvent
{
    /**
     * @param array<string, CheckStatusInterface> $checks
     */
    public function __construct(
        protected array $checks
    ) {
    }

    /**
     * @return array<string, CheckStatusInterface>
     */
    public function getChecks(): array
    {
        return $this->checks;
    }
}
