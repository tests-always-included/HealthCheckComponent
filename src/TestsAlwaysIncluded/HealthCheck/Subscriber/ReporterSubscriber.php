<?php

namespace TestsAlwaysIncluded\HealthCheck\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use TestsAlwaysIncluded\HealthCheck\Event\HealthCheckEvent;
use TestsAlwaysIncluded\HealthCheck\HealthCheckEvents;
use TestsAlwaysIncluded\HealthCheck\Service\HealthCheck;

class ReporterSubscriber implements EventSubscriberInterface
{
    /** @var HealthCheck */
    protected $healthCheck;


    /**
     * @param HealthCheck $healthCheck
     */
    public function setHealthCheck(HealthCheck $healthCheck)
    {
        $this->healthCheck = $healthCheck;
    }


    /**
     * Notifies reporters that the health check is starting.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function onHealthCheckStarted(HealthCheckEvent $healthCheckEvent)
    {
        $reporters = $this->healthCheck->getReporters();
        foreach ($reporters as $reporter) {
            $reporter->healthCheckStarted($healthCheckEvent);
        }
    }


    /**
     * Notifies reporters that the health check has ended.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function onHealthCheckCompleted(HealthCheckEvent $healthCheckEvent)
    {
        $reporters = $this->healthCheck->getReporters();
        foreach ($reporters as $reporter) {
            $reporter->healthCheckCompleted($healthCheckEvent);
        }
    }


    /**
     * Notifies reporters that a new test suite is starting.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function onTestSuiteStarted(HealthCheckEvent $healthCheckEvent)
    {
        $reporters = $this->healthCheck->getReporters();
        foreach ($reporters as $reporter) {
            $reporter->testSuiteStarted($healthCheckEvent);
        }
    }


    /**
     * Notifies reporters that the test suite has ended.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function onTestSuiteCompleted(HealthCheckEvent $healthCheckEvent)
    {
        $reporters = $this->healthCheck->getReporters();
        foreach ($reporters as $reporter) {
            $reporter->testSuiteCompleted($healthCheckEvent);
        }
    }


    /**
     * Notifies reporters that a new test group is starting.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function onTestGroupStarted(HealthCheckEvent $healthCheckEvent)
    {
        $reporters = $this->healthCheck->getReporters();
        foreach ($reporters as $reporter) {
            $reporter->testGroupStarted($healthCheckEvent);
        }
    }


    /**
     * Notifies reporters that the test group has ended.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function onTestGroupCompleted(HealthCheckEvent $healthCheckEvent)
    {
        $reporters = $this->healthCheck->getReporters();
        foreach ($reporters as $reporter) {
            $reporter->testGroupCompleted($healthCheckEvent);
        }
    }


    /**
     * Notifies reporters that a new test is starting.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function onTestStarted(HealthCheckEvent $healthCheckEvent)
    {
        $reporters = $this->healthCheck->getReporters();
        foreach ($reporters as $reporter) {
            $reporter->testStarted($healthCheckEvent);
        }
    }


    /**
     * Notifies reporters that the test has passed.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function onTestPassed(HealthCheckEvent $healthCheckEvent)
    {
        $reporters = $this->healthCheck->getReporters();
        foreach ($reporters as $reporter) {
            $reporter->testPassed($healthCheckEvent);
        }
    }


    /**
     * Notifies reporters that the test has failed.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function onTestFailed(HealthCheckEvent $healthCheckEvent)
    {
        $reporters = $this->healthCheck->getReporters();
        foreach ($reporters as $reporter) {
            $reporter->testFailed($healthCheckEvent);
        }
    }


    /**
     * Notifies reporters that the test has been skipped.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function onTestSkipped(HealthCheckEvent $healthCheckEvent)
    {
        $reporters = $this->healthCheck->getReporters();
        foreach ($reporters as $reporter) {
            $reporter->testSkipped($healthCheckEvent);
        }
    }
   
   
    /**
     * Notifies reporters that the test has an error.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function onTestError(HealthCheckEvent $healthCheckEvent)
    {
        $reporters = $this->healthCheck->getReporters();
        foreach ($reporters as $reporter) {
            $reporter->testError($healthCheckEvent);
        }
    }


    /**
     * Notifies reporters that the test has finished.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function onTestCompleted(HealthCheckEvent $healthCheckEvent)
    {
        $reporters = $this->healthCheck->getReporters();
        foreach ($reporters as $reporter) {
            $reporter->testComplete($healthCheckEvent);
        }
    }


    /**
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return array(
            HealthCheckEvents::EVENT_HEALTH_CHECK_STARTED => 'onHealthCheckStarted',
            HealthCheckEvents::EVENT_HEALTH_CHECK_COMPLETED => 'onHealthCheckCompleted',
            HealthCheckEvents::EVENT_TEST_SUITE_STARTED => 'onTestSuiteStarted',
            HealthCheckEvents::EVENT_TEST_SUITE_COMPLETED => 'onTestSuiteCompleted',
            HealthCheckEvents::EVENT_TEST_GROUP_STARTED => 'onTestGroupStarted',
            HealthCheckEvents::EVENT_TEST_GROUP_COMPLETED => 'onTestGroupCompleted',
            HealthCheckEvents::EVENT_TEST_STARTED => 'onTestStarted',
            HealthCheckEvents::EVENT_TEST_PASSED => 'onTestPassed',
            HealthCheckEvents::EVENT_TEST_FAILED => 'onTestFailed',
            HealthCheckEvents::EVENT_TEST_SKIPPED => 'onTestSkipped',
            HealthCheckEvents::EVENT_TEST_ERROR => 'onTestError',
            HealthCheckEvents::EVENT_TEST_COMPLETED => 'onTestCompleted',
        );
    }
}
