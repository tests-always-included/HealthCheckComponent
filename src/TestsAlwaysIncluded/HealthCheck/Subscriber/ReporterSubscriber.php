<?php

namespace TestsAlwaysIncluded\HealthCheck\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use TestsAlwaysIncluded\HealthCheck\Event\HealthCheckEvent;
use TestsAlwaysIncluded\HealthCheck\HealthCheckEvents;

class ReporterSubscriber implements EventSubscriberInterface
{
    /** @const int */
    const PRIORITY = 0;


    /**
     * Notifies reporters that the health check is starting.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function onHealthCheckStarted(HealthCheckEvent $healthCheckEvent)
    {
        $reporters = $healthCheckEvent->getHealthCheck()->getReporters();
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
        $reporters = $healthCheckEvent->getHealthCheck()->getReporters();
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
        $reporters = $healthCheckEvent->getHealthCheck()->getReporters();
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
        $reporters = $healthCheckEvent->getHealthCheck()->getReporters();
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
        $reporters = $healthCheckEvent->getHealthCheck()->getReporters();
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
        $reporters = $healthCheckEvent->getHealthCheck()->getReporters();
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
        $reporters = $healthCheckEvent->getHealthCheck()->getReporters();
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
        $reporters = $healthCheckEvent->getHealthCheck()->getReporters();
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
        $reporters = $healthCheckEvent->getHealthCheck()->getReporters();
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
        $reporters = $healthCheckEvent->getHealthCheck()->getReporters();
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
        $reporters = $healthCheckEvent->getHealthCheck()->getReporters();
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
        $reporters = $healthCheckEvent->getHealthCheck()->getReporters();
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
            HealthCheckEvents::EVENT_HEALTH_CHECK_STARTED => array('onHealthCheckStarted', static::PRIORITY),
            HealthCheckEvents::EVENT_HEALTH_CHECK_COMPLETED => array('onHealthCheckCompleted', static::PRIORITY),
            HealthCheckEvents::EVENT_TEST_SUITE_STARTED => array('onTestSuiteStarted', static::PRIORITY),
            HealthCheckEvents::EVENT_TEST_SUITE_COMPLETED => array('onTestSuiteCompleted', static::PRIORITY),
            HealthCheckEvents::EVENT_TEST_GROUP_STARTED => array('onTestGroupStarted', static::PRIORITY),
            HealthCheckEvents::EVENT_TEST_GROUP_COMPLETED => array('onTestGroupCompleted', static::PRIORITY),
            HealthCheckEvents::EVENT_TEST_STARTED => array('onTestStarted', static::PRIORITY),
            HealthCheckEvents::EVENT_TEST_PASSED => array('onTestPassed', static::PRIORITY),
            HealthCheckEvents::EVENT_TEST_FAILED => array('onTestFailed', static::PRIORITY),
            HealthCheckEvents::EVENT_TEST_SKIPPED => array('onTestSkipped', static::PRIORITY),
            HealthCheckEvents::EVENT_TEST_ERROR => array('onTestError', static::PRIORITY),
            HealthCheckEvents::EVENT_TEST_COMPLETED => array('onTestCompleted', static::PRIORITY),
        );
    }
}
