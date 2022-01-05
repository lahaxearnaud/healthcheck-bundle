<?php
namespace Alahaxe\HealthCheckBundle\Service\Reporter;

use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Alahaxe\HealthCheckBundle\Service\HealthCheckService;

interface ReporterInterface
{
    /**
     * @param CheckStatusInterface[] $checkStatuses
     * @param array<string, mixed> $context
     *
     * @return array<string, mixed>
     */
    public function format(array $checkStatuses, array $context):array;

    /**
     * @param CheckStatusInterface[] $checkStatuses
     * @return int
     */
    public function calculateHttpCode(array $checkStatuses):int;
}
