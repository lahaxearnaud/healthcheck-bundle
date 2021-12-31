<?php
namespace Alahaxe\HealthCheckBundle\Service\Context;


use Alahaxe\HealthCheck\Contracts\ContextProviderInterface;

class EnvironmentContext implements ContextProviderInterface
{
    public function __construct(
        protected string $env
    ) {
    }

    public function getValue(): string|array|int|float|\JsonSerializable
    {
        return $this->env;
    }

    public function getName(): string
    {
        return 'environment';
    }
}
