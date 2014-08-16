<?php

namespace TestsAlwaysIncluded\HealthCheck\Service;

use Symfony\Component\EventDispatcher\EventDispatcher;
use TestsAlwaysIncluded\HealthCheck\Event\HealthCheckEvent;
use TestsAlwaysIncluded\HealthCheck\Exception\HealthCheckExceptionInterface;
use TestsAlwaysIncluded\HealthCheck\HealthCheckEvents;
use TestsAlwaysIncluded\HealthCheck\Test\Test;
use TestsAlwaysIncluded\HealthCheck\Test\TestGroup;
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
        $this->fire(HealthCheckEvents::EVENT_HEALTH_CHECK_STARTED, $healthCheck);

        foreach ($healthCheck->getTestSuites() as $testSuite) {
            $this->fire(HealthCheckEvents::EVENT_TEST_SUITE_STARTED, $healthCheck, $testSuite);

            foreach ($testSuite->getTestGroups() as $testGroup) {
                $this->fire(HealthCheckEvents::EVENT_TEST_GROUP_STARTED, $healthCheck, $testSuite, $testGroup);

                foreach ($testGroup->getTests() as $test) {
                    $this->fire(HealthCheckEvents::EVENT_TEST_STARTED, $healthCheck, $testSuite, $testGroup, $test);

                    try {
                        $test->execute();
                    } catch (HealthCheckExceptionInterface $exception) {
                        $test->error($exception->getMessage());
                    }

                    if ($test->passed()) {
                        $eventName = HealthCheckEvents::EVENT_TEST_PASSED;
                    } else if ($test->failed()) {
                        $eventName = HealthCheckEvents::EVENT_TEST_FAILED;
                    } else if ($test->inError()) {
                        $eventName = HealthCheckEvents::EVENT_TEST_ERROR;
                    } else if ($test->skipped()) {
                        $eventName = HealthCheckEvents::EVENT_TEST_SKIPPED;
                    }

                    $this->fire($eventName, $healthCheck, $testSuite, $testGroup, $test);
                    $this->fire(HealthCheckEvents::EVENT_TEST_COMPLETED, $healthCheck, $testSuite, $testGroup, $test);
                }

                $this->fire(HealthCheckEvents::EVENT_TEST_GROUP_COMPLETED, $healthCheck, $testSuite, $testGroup);
            }

            $this->fire(HealthCheckEvents::EVENT_TEST_SUITE_COMPLETED, $healthCheck, $testSuite);
        }

        $this->fire(HealthCheckEvents::EVENT_HEALTH_CHECK_COMPLETED, $healthCheck);
    } 
}
