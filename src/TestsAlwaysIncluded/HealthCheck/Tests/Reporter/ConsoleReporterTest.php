<?php

namespace TestsAlwaysIncluded\HealthCheck\Tests\Reporter;

use TestsAlwaysIncluded\HealthCheck\Event\HealthCheckEvent;
use TestsAlwaysIncluded\HealthCheck\Reporter\ConsoleReporter;

class ConsoleReporterTest extends \PHPUnit_Framework_TestCase
{
    public function testTestPassed()
    {
        $mockConsoleOutput = $this->getMockBuilder('Symfony\Component\Console\Output\ConsoleOutput')
            ->disableOriginalConstructor()
            ->setMethods((array) 'write')
            ->getMock();
        $mockConsoleOutput->expects($this->once())
            ->method('write')
            ->with('<info>.</info>');
        $reporter = new ConsoleReporter;
        $reporter->setConsoleOutput($mockConsoleOutput);
        $reporter->testPassed(new HealthCheckEvent);
    }


    public function testTestFailed()
    {
        $mockConsoleOutput = $this->getMockBuilder('Symfony\Component\Console\Output\ConsoleOutput')
            ->disableOriginalConstructor()
            ->setMethods((array) 'write')
            ->getMock();
        $mockConsoleOutput->expects($this->once())
            ->method('write')
            ->with('<error>F</error>');
        $reporter = new ConsoleReporter;
        $reporter->setConsoleOutput($mockConsoleOutput);
        $reporter->testFailed(new HealthCheckEvent);
    }


    public function testTestSkipped()
    {
        $mockConsoleOutput = $this->getMockBuilder('Symfony\Component\Console\Output\ConsoleOutput')
            ->disableOriginalConstructor()
            ->setMethods((array) 'write')
            ->getMock();
        $mockConsoleOutput->expects($this->once())
            ->method('write')
            ->with('<comment>S</comment>');
        $reporter = new ConsoleReporter;
        $reporter->setConsoleOutput($mockConsoleOutput);
        $reporter->testSkipped(new HealthCheckEvent);
    }


    public function testTestError()
    {
        $mockConsoleOutput = $this->getMockBuilder('Symfony\Component\Console\Output\ConsoleOutput')
            ->disableOriginalConstructor()
            ->setMethods((array) 'write')
            ->getMock();
        $mockConsoleOutput->expects($this->once())
            ->method('write')
            ->with('<error>E</error>');
        $reporter = new ConsoleReporter;
        $reporter->setConsoleOutput($mockConsoleOutput);
        $reporter->testError(new HealthCheckEvent);
    }


}
