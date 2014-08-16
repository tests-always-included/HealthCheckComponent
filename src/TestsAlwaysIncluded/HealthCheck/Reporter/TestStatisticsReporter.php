<?php

namespace TestsAlwaysIncluded\HealthCheck\Reporter;

use TestsAlwaysIncluded\HealthCheck\Event\HealthCheckEvent;

class TestStatisticsReporter extends Reporter
{
    /** @var int */
    protected $failed = 0;

    /** @var int */
    protected $passed = 0;

    /** @var int */
    protected $errors = 0;

    /** @var int */
    protected $skipped = 0;

    /** @var int */
    protected $run = 0;


    /**
     * @return int
     */
    public function getFailed()
    {
        return $this->failed;
    }


    /**
     * @return int
     */
    public function getPassed()
    {
        return $this->passed;
    }


    /**
     * @return int
     */
    public function getErrors()
    {
        return $this->errors;
    }


    /**
     * @return int
     */
    public function getSkipped()
    {
        return $this->skipped;
    }


    /**
     * @return int
     */
    public function getRun()
    {
        return $this->run;
    }


    /**
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testStarted(HealthCheckEvent $event)
    {
        $this->run ++;
    }


    /**
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testFailed(HealthCheckEvent $event)
    {
        $this->failed ++;
    }


    /**
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testPassed(HealthCheckEvent $event)
    {
        $this->passed ++;
    }


    /**
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testError(HealthCheckEvent $event)
    {
        $this->errors ++;
    }


    /**
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testSkipped(HealthCheckEvent $event)
    {
        $this->skipped ++;
    }
}
