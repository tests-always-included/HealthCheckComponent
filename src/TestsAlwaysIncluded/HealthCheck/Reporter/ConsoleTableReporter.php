<?php

namespace TestsAlwaysIncluded\HealthCheck\Reporter;

use Symfony\Component\Console\Helper\TableHelper;
use TestsAlwaysIncluded\HealthCheck\Event\HealthCheckEvent;

class ConsoleTableReporter extends AbstractConsoleReporter
{
    /** @var TableHelper */
    protected $tableHelper;


    /**
     * @param TableHelper $tableHelper
     */
    public function setTableHelper(TableHelper $tableHelper)
    {
        $this->tableHelper = $tableHelper;
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
     * Build a table row.
     *
     * @param HealthCheckEvent $healthCheckEvent
     * @return string[]
     */
    protected function buildTableRow(HealthCheckEvent $healthCheckEvent)
    {
        $row = array();
        $row[] = $healthCheckEvent->getTestSuite()->getName();
        $row[] = $healthCheckEvent->getTestGroup()->getName();

        $test = $healthCheckEvent->getTest();
        $state = $healthCheckEvent->getState();
        $row[] = $test->getName();

        if ($test->passed()) {
            $row[] = sprintf('<info>%s</info>', $state);
        } else if ($test->failed()) {
            $row[] = sprintf('<error>%s</error>', $state);
        } else if ($test->skipped()) {
            $row[] = sprintf('<comment>%s</comment>', $state);
        } else if ($test->inError()) {
            $row[] = sprintf('<error>%s</error>', $state);
        }

        if ($this->consoleOutput->isVerbose()) {
            $row[] = $test->getReason();
        }

        return $row;
    }


    /**
     * Do something when a test passes.
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function testCompleted(HealthCheckEvent $healthCheckEvent)
    {
        $row = $this->buildTableRow($healthCheckEvent);
        $this->tableHelper->addRow($row);
    }
}
