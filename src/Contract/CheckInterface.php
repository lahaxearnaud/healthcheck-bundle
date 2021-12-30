<?php

namespace Alahaxe\HealthCheckBundle\Contract;

use Alahaxe\HealthCheckBundle\CheckStatus;

interface CheckInterface
{
    public function check():CheckStatus;
}
