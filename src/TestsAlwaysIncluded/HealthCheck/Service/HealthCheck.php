<?php

namespace TestsAlwaysIncluded\HealthCheck\Services;

use Symfony\Component\EventDispatcher\EventDispatcher;
use TestsAlwaysIncluded\HealthCheck\Exception\HealthCheckException;
use TestsAlwaysIncluded\HealthCheck\HealthCheckEvents;
use TestsAlwaysIncluded\HealthCheck\Reporter\Reporter;
use TestsAlwaysIncluded\HealthCheck\Test\TestSuite;

class HealthCheck
{
    /** @var EventDispatcher */
    protected $eventDispatcher;


    /** @var TestSuite[] */
    protected $testSuites = array();


    /** @var Reporter[] */
    protected $reporters = array();


    /**
     * @param EventDispatcher $eventDispatcher
     */
    public function setEventDispatcher(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }


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
    public function registerTestSuite(TestSuite $testSuite)
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


    /**
     * @param string $eventName
     * @param TestSuite $testSuite
     * @param TestGroup $testGroup
     * @param Test $test
     */
    private function fire($eventName, TestSuite $testSuite = null, TestGroup $testGroup = null, Test $test = null)
    {
        $event = new HealthCheckEvent();
        $event->setTestSuite($testSuite);
        $event->setTestGroup($testGroup);
        $event->setTest($test); 
        $this->eventDispatcher->dispatch($eventName, $event);
    }


    /**
     * Executes the HealthCheck.
     */
    public function run()
    {
        $this->fire(HealthCheckEvent::EVENT_HEALTH_CHECK_STARTED);

        foreach ($this->testSuites as $testSuite) {
            $this->fire(HealthCheckEvent::EVENT_TEST_SUITE_STARTED, $testSuite);

            foreach ($testSuite->getTestGroups() as $testGroup) {
                $this->fire(HealthCheckEvent::EVENT_TEST_GROUP_STARTED, $testSuite, $testGroup);

                foreach ($group->getTests() as $test) {
                    $this->fire(HealthCheckEvent::EVENT_TEST_STARTED, $testSuite, $testGroup, $test);

                    try {
                        $test->execute();
                    } catch (HealthCheckException $exception) {
                        $test->error($exception->getMessage());
                    }

                    if ($test->passed()) {
                        $eventName = HealthCheckEvent::EVENT_TEST_PASSED;
                    } else if ($test->failed()) {
                        $eventName = HealthCheckEvent::EVENT_TEST_FAILED;
                    } else if ($test->inError()) {
                        $eventName = HealthCheckEvent::EVENT_TEST_ERROR;
                    } else if ($test->skipped()) {
                        $eventName = HealthCheckEvent::EVENT_TEST_SKIPPED;
                    }

                    $this->fire($eventName, $testSuite, $testGroup, $test);
                    $this->fire(HealthCheckEvent::EVENT_TEST_COMPLETED, $testSuite, $testGroup, $test);
                }

                $this->fire(HealthCheckEvent::EVENT_TEST_GROUP_COMPLETED, $testSuite, $testGroup);
            }

            $this->fire(HealthCheckEvent::EVENT_TEST_SUITE_COMPLETED, $testSuite);
        }

        $this->fire(HealthCheckEvent::EVENT_HEALTH_CHECK_COMPLETED);
    }
}
