<?php

namespace TestsAlwaysIncluded\HealthCheck\Reporter;

use TestsAlwaysIncluded\HealthCheck\Event\HealthCheckEvent;

class ConsoleReporter extends AbstractConsoleReporter
{
    /**
     * Do something when a test passes.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testPassed(HealthCheckEvent $healthCheckEvent)
    {
        $this->consoleOutput->write('<info>.</info>');
    }


    /**
     * Do something when a test fails.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testFailed(HealthCheckEvent $healthCheckEvent)
    {
        $this->consoleOutput->write('<error>F</error>');
    }


    /**
     * Do something when a test is skipped.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testSkipped(HealthCheckEvent $healthCheckEvent)
    {
        $this->consoleOutput->write('<comment>S</comment');
    }


    /**
     * Do something when a test triggers an error.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testError(HealthCheckEvent $healthCheckEvent)
    {
        $this->consoleOutput->write('<error>E</error>');
    }
}
