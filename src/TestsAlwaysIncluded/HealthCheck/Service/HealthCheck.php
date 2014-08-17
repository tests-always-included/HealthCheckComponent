<?php

namespace TestsAlwaysIncluded\HealthCheck\Service;

use Symfony\Component\EventDispatcher\EventDispatcher;
use TestsAlwaysIncluded\HealthCheck\Reporter\Reporter;
use TestsAlwaysIncluded\HealthCheck\Strategy\SuccessStrategyInterface;
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
     * @param TestSuite[] $testSuites
     */
    public function setTestSuites($testSuites) 
    {
        $this->testSuites = $testSuites;
    }


    /**
     * @return TestSuite[]
     */
    public function getTestSuites()
    {
        return $this->testSuites;
    }


    /**
     * @param SuccessStrategyInterface $successStrategy
     * @return boolean
     */
    public function passed(SuccessStrategyInterface $successStrategy)
    {
        return $successStrategy->execute($this);
    }
}
