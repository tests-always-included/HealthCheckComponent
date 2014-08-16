<?php

namespace TestsAlwaysIncluded\HealthCheck\Reporter;

use Psr\Log\LoggerInterface;

abstract class LoggerAwareReporter extends Reporter implements \Psr\Log\LoggerAwareInterface
{
    /** @var LoggerInterface */
    protected $logger;


    /**
     * Sets a logger instance on the object
     *
     * @param LoggerInterface $logger
     * @return null
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger
    }
}
