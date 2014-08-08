<?php

namespace TestsAlwaysIncluded\HealthCheck\Reporter;

use TestsAlwaysIncluded\HealthCheck\Event\HealthCheckEvent;

class Reporter
{
    /**
     * Do something when the health check begins.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function healthCheckStarted(HealthCheckEvent $healthCheckEvent)
    {
    }


    /**
     * Do something when the health check ends.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function healthCheckCompleted(HealthCheckEvent $healthCheckEvent)
    {
    }


    /**
     * Do something when a test suite begins.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testSuiteStarted(HealthCheckEvent $healthCheckEvent)
    {
    }


    /**
     * Do something when a test suite ends.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testSuiteCompleted(HealthCheckEvent $healthCheckEvent)
    {
    }


    /**
     * Do something when a test group begins.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testGroupStarted(HealthCheckEvent $healthCheckEvent)
    {
    }


    /**
     * Do something when a test group ends.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testGroupCompleted(HealthCheckEvent $healthCheckEvent)
    {
    }


    /**
     * Do something when a test begins.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testStarted(HealthCheckEvent $healthCheckEvent)
    {
    }


    /**
     * Do something when a test passes.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testPassed(HealthCheckEvent $healthCheckEvent)
    {
    }


    /**
     * Do something when a test fails.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testFailed(HealthCheckEvent $healthCheckEvent)
    {
    }


    /**
     * Do something when a test is skipped.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testSkipped(HealthCheckEvent $healthCheckEvent)
    {
    }


    /**
     * Do something when a test triggers an error.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testError(HealthCheckEvent $healthCheckEvent)
    {
    }
}
