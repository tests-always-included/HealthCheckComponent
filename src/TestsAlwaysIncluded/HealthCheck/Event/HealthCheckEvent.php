<?php

namespace TestsAlwaysIncluded\HealthCheck\Event;

use Symfony\Component\EventDispatcher\Event;
use TestsAlwaysIncluded\HealthCheck\Test\Test;
use TestsAlwaysIncluded\HealthCheck\Test\TestGroup;
use TestsAlwaysIncluded\HealthCheck\Test\TestSuite;

class HealthCheckEvent extends Event
{
    /** @var TestSuite */
    protected $testSuite;


    /** @var TestGroup */
    protected $testGroup;


    /** @var Test */
    protected $test;


    /**
     * @param TestSuite $suite
     */
    public function setTestSuite(TestSuite $testSuite)
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
    public function setTestGroup(TestGroup $testGroup)
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
    public function setTest(Test $test)
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
