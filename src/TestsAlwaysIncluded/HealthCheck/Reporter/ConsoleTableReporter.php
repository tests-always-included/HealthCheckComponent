<?php

namespace TestsAlwaysIncluded\HealthCheck\Reporter;

use Symfony\Component\Console\Helper\TableHelper;
use TestsAlwaysIncluded\HealthCheck\Event\HealthCheckEvent;

class ConsoleTableReporter extends AbstractConsoleReporter
{
    /** @var TableHelper */
    protected $tableHelper;


    /** @var array */
    protected $row;


    /**
     * @param TableHelper $tableHelper
     */
    public function setTableHelper(TableHelper $tableHelper)
    {
        $this->tableHelper = $tableHelper;
    }


    /**
     * @return array
     */
    public function getRow()
    {
        return $this->row;
    }


    /**
     * Generate an array of table headers.
     *
     * @param HealthCheckEvent $healthCheckEvent
     * @return string[]
     */
    protected function buildTableHeaders(HealthCheckEvent $healthCheckEvent)
    {
        $headers = array(
            'Test Suite',
            'Test Group',
            'Test',
            'Result',
        );

        if ($this->consoleOutput->isVerbose()) {
            $headers[] = 'Reason';
        }

        return $headers;
    }


    /**
     * Do something when the health check starts.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function healthCheckStarted(HealthCheckEvent $healthCheckEvent)
    {
        $headers = $this->buildTableHeaders($healthCheckEvent);
        $this->tableHelper->setHeaders($headers);
    }


    /**
     * Do something when the health check is complete.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function healthCheckCompleted(HealthCheckEvent $healthCheckEvent)
    {
        $this->tableHelper->render($this->consoleOutput);
    }


    /**
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testPassed(HealthCheckEvent $healthCheckEvent)
    {
        $state = $healthCheckEvent->getTest()->getState();
        $this->row[] = sprintf('<info>%s</info>', $state);
    }


    /**
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testFailed(HealthCheckEvent $healthCheckEvent)
    {
        $state = $healthCheckEvent->getTest()->getState();
        $this->row[] = sprintf('<error>%s</error>', $state);
    }


    /**
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testSkipped(HealthCheckEvent $healthCheckEvent)
    {
        $state = $healthCheckEvent->getTest()->getState();
        $this->row[] = sprintf('<comment>%s</comment>', $state);
    }


    /**
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testError(HealthCheckEvent $healthCheckEvent)
    {
        $state = $healthCheckEvent->getTest()->getState();
        $this->row[] = sprintf('<error>%s</error>', $state);
    }


    /**
     * Do something when a test begins.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testStarted(HealthCheckEvent $healthCheckEvent)
    {
        $row = array();
        $row[] = $healthCheckEvent->getTestSuite()->getName();
        $row[] = $healthCheckEvent->getTestGroup()->getName();
        $row[] = $healthCheckEvent->getTest()->getName();
        $this->row = $row;
    }


    /**
     * Do something when a test passes.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testCompleted(HealthCheckEvent $healthCheckEvent)
    {
        if ($this->consoleOutput->isVerbose()) {
            $this->row[] = $test->getReason();
        }

        $this->tableHelper->addRow($this->row);
    }
}
