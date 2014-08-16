<?php

namespace TestsAlwaysIncluded\HealthCheck\Strategy;

use TestsAlwaysIncluded\HealthCheck\Service\HealthCheck;

interface SuccessStrategyInterface
{
    /** @return boolean */
    public function execute(HealthCheck $healthCheck);
}
