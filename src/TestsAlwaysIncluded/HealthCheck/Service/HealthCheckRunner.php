<?php

namespace TestsAlwaysIncluded\HealthCheck\Services;

use Symfony\Component\EventDispatcher\EventDispatcher;
use TestsAlwaysIncluded\HealthCheck\Exception\HealthCheckExceptionInterface;
use TestsAlwaysIncluded\HealthCheck\HealthCheckEvents;
use TestsAlwaysIncluded\HealthCheck\Test\TestSuite;

class HealthCheckRunner
{
    /** @var EventDispatcher */
    protected $eventDispatcher;


    /**
     * @param EventDispatcher $eventDispatcher
     */
    public function setEventDispatcher(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }


    /**
     * Dispatches the desired event.
     *
     * @param string $eventName
     * @parma HealthCheck $healthCheck
     * @param TestSuite $testSuite
     * @param TestGroup $testGroup
     * @param Test $test
     */
    private function fire($eventName, HealthCheck $healthCheck, TestSuite $testSuite = null, TestGroup $testGroup = null, Test $test = null)
    {
        $event = new HealthCheckEvent();
        $event->setHealthCheck($healthCheck);
        $event->setTestSuite($testSuite);
        $event->setTestGroup($testGroup);
        $event->setTest($test); 
        $this->eventDispatcher->dispatch($eventName, $event);
    }


    /**
     * Executes the HealthCheck.
     * 
     * @param HealthCheck $healthCheck
     */
    public function run(HealthCheck $healthCheck)
    {
        $this->fire(HealthCheckEvent::EVENT_HEALTH_CHECK_STARTED, $healthCheck);

        foreach ($healthCheck->getTestSuites() as $testSuite) {
            $this->fire(HealthCheckEvent::EVENT_TEST_SUITE_STARTED, $healthCheck, $testSuite);

            foreach ($testSuite->getTestGroups() as $testGroup) {
                $this->fire(HealthCheckEvent::EVENT_TEST_GROUP_STARTED, $healthCheck, $testSuite, $testGroup);

                foreach ($group->getTests() as $test) {
                    $this->fire(HealthCheckEvent::EVENT_TEST_STARTED, $healthCheck, $testSuite, $testGroup, $test);

                    try {
                        $test->execute();
                    } catch (HealthCheckExceptionInterface $exception) {
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

                    $this->fire($eventName, $healthCheck, $testSuite, $testGroup, $test);
                    $this->fire(HealthCheckEvent::EVENT_TEST_COMPLETED, $healthCheck, $testSuite, $testGroup, $test);
                }

                $this->fire(HealthCheckEvent::EVENT_TEST_GROUP_COMPLETED, $healthCheck, $testSuite, $testGroup);
            }

            $this->fire(HealthCheckEvent::EVENT_TEST_SUITE_COMPLETED, $healthCheck, $testSuite);
        }

        $this->fire(HealthCheckEvent::EVENT_HEALTH_CHECK_COMPLETED, $healthCheck);
    } 
}
