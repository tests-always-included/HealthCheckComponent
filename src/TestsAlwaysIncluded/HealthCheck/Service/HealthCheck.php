<?php

namespace TestsAlwaysIncluded\HealthCheck\Services;

use Symfony\Component\EventDispatcher\EventDispatcher;
use TestsAlwaysIncluded\HealthCheck\Reporter\Reporter;
use TestsAlwaysIncluded\HealthCheck\Test\TestSuite;

class HealthCheck
{
    /** @var TestSuite[] */
    protected $testSuites = array();


    /** @var Reporter[] */
    protected $reporters = array();


    /**
     * @param Reporter $reporter
     * @param string $alias Optional alias if for some reason you decide to provide similar reporter(s).
     */
    public function registerReporter(Reporter $reporter, $alias = null)
    {
        $alias = $alias ?: get_class($reporter);
        $this->reporters[$alias] = $reporter;
    }


    /**
     * @return Reporter[]
     */
    public function getReporters()
    {
        return $this->reporters;
    }


    /**
     * @param TestSuite $testSuite
     */
    public function addTestSuite(TestSuite $testSuite)
    {
        $this->testSuites[] = $testSuite;
    }


    /**
     * @return TestSuite[]
     */
    public function getTestSuites()
    {
        return $this->testSuites;
    }
}
