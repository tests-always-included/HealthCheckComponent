<?php

namespace TestsAlwaysIncluded\HealthCheck\Subscriber;

use TestsAlwaysIncluded\HealthCheck\Exception\HealthCheckErrorException;
use TestsAlwaysIncluded\HealthCheck\HealthCheckEvents;
use TestsAlwaysIncluded\HealthCheck\Services\HealthCheck;

class TestErrorSubscriber implements EventSubscriberInterface
{
    /** @const int */
    const PRIORITY = 100;


    /** @var boolean */
    protected $trapErrors;


    /**
     * @param boolean $trapErrors
     */
    public function setTrapErrors($trapErrors)
    {
        $this->trapErrors = $trapErrors;
    }


    /**
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function onHealthCheckStarted(HealthCheckEvent $healthCheckEvent)
    {
        if ($this->trapErrors) {
            set_error_handler(array($this, 'errorHandler'));
        }
    }


    /**
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function onHealthCheckCompleted(HealthCheckEvent $healthChechEvent)
    {
        if ($this->trapErrors) {
            restore_error_handler();
        }
    }


    /**
     * Custom error handler.
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @param array $errcontext
     * @throws HealthCheckException
     */
    private function errorHandler($errno, $errstr, $errfile, $errline, array $errcontext = null)
    {
        // Our error level isn't including this error.
        if (!(error_reporting() & $errno)) {
            return;
        }

        throw new HealthCheckErrorException($errstr, $errno, 1, $errfile, $errline);
    }


    /**
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return array(
            HealthCheckEvents::EVENT_HEALTH_CHECK_STARTED => array('onHealthCheckStarted', static::PRIORITY),
            HealthCheckEvents::EVENT_HEALTH_CHECK_COMPLETED => array('onHealthCheckCompleted', static::PRIORITY),
        );
    }
} 
