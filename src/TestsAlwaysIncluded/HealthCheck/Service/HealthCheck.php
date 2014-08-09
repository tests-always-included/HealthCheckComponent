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
     * Executes the HealthCheck.
     */
    public function run()
    {
        $this->eventDispatcher->dispatch(HealthCheckEvent::EVENT_HEALTH_CHECK_STARTED, new HealthCheckEvent);
        // N
        foreach ($this->testSuites as $testSuite) {
            $event = new HealthCheckEvent;
            $event->setTestSuite($testSuite);
            $this->eventDispatcher->dispatch(HealthCheckEvent::EVENT_TEST_SUITE_STARTED, $event);
            // N^2
            foreach ($testSuite->getTestGroups() as $group) {
                $event->setTestGroup($group);
                $this->eventDispatcher->dispatch(HealthCheckEvent::EVENT_TEST_GROUP_STARTED, $event);
                // N^3 ... ohmuhgawdicandobettah.
                foreach ($group->getTests() as $test) {
                    $event->setTest($test);
                    $this->eventDispatcher->dispatch(HealthCheckEvent::EVENT_TEST_STARTED, $event);
                    try {
                        $test->execute();
                        $eventName = $test->skipped() ? 
                            HealthCheckEvent::EVENT_TEST_SKIPPED :
                            $test->passed() ? 
                                HealthCheckEvent::EVENT_TEST_PASSED : HealthCheckEvent::EVENT_TEST_FAILED;
                        $this->eventDispatcher->dispatch($eventName, $event);
                    } catch (HealthCheckException $exception) {
                        $test->error($exception->getMessage());
                        $this->eventDispatcher->dispatch(HealthCheckEvent::EVENT_TEST_ERROR, $event);
                    }
                    $this->eventDispatcher->dispatch(HealthCheckEvent::EVENT_TEST_COMPLETED, $event);
                }
                $this->eventDispatcher->dispatch(HealthCheckEvent::EVENT_TEST_GROUP_COMPLETED, $event);
            }
            $this->eventDispatcher->dispatch(HealthCheckEvent::EVENT_TEST_SUITE_COMPLETED, $event);
        }
        $this->eventDispatcher->dispatch(HealthCheckEvent::EVENT_HEALTH_CHECK_COMPLETED, new HealthCheckEvent);
    }
}
