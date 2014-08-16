<?php

namespace TestsAlwaysIncluded\HealthCheck\Event;

use Symfony\Component\EventDispatcher\Event;
use TestsAlwaysIncluded\HealthCheck\Services\HealthCheck;
use TestsAlwaysIncluded\HealthCheck\Test\Test;
use TestsAlwaysIncluded\HealthCheck\Test\TestGroup;
use TestsAlwaysIncluded\HealthCheck\Test\TestSuite;

class HealthCheckEvent extends Event
{
    /** @var HealthCheck */
    protected $healthCheck;


    /** @var TestSuite */
    protected $testSuite;


    /** @var TestGroup */
    protected $testGroup;


    /** @var Test */
    protected $test;


    /**
     * @param HealthCheck $healthCheck
     */
    public function setHealthCheck(HealthCheck $healthCheck)
    {
        $this->healthCheck = $healthCheck;
    }


    /**
     * @return HealthCheck
     */
    public function getHealthCheck()
    {
        return $this->healthCheck;
    }


    /**
     * @param TestSuite $suite
     */
    public function setTestSuite(TestSuite $testSuite = null)
    {
        $this->suite = $testSuite;
    }


    /**
     * @return TestSuite
     */
    public function getTestSuite()
    {
        return $this->testSuite;
    }


    /**
     * @param TestGroup $testGroup
     */
    public function setTestGroup(TestGroup $testGroup = null)
    {
        $this->testGroup = $testGroup;
    }


    /**
     * @return TestGroup
     */
    public function getTestGroup()
    {
        return $this->testGroup;
    }


    /**
     * @param Test $test
     */
    public function setTest(Test $test = null)
    {
        $this->test = $test;
    }


    /**
     * @return Test
     */
    public function getTest()
    {
        return $this->test;
    }
}
