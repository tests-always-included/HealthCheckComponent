<?php

namespace TestsAlwaysIncluded\HealthCheck\Tests\Reporter;

use TestsAlwaysIncluded\HealthCheck\Event\HealthCheckEvent;
use TestsAlwaysIncluded\HealthCheck\Reporter\ConsoleTableReporter;
use TestsAlwaysIncluded\HealthCheck\Test\Test;
use TestsAlwaysIncluded\HealthCheck\Test\TestGroup;
use TestsAlwaysIncluded\HealthCheck\Test\TestSuite;

class ConsoleTableReporterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Constuct a HealthCheckEvent we can test with.
     *
     * @param string $testSuiteName
     * @param string $testGroupName
     * @param string $testName
     * @return HealthCheckEvent
     */
    protected function makeEvent($testSuiteName, $testGroupName, $testName)
    {
        $testSuite = new TestSuite;
        $testSuite->setName($testSuiteName);
        $testGroup = new TestGroup;
        $testGroup->setName($testGroupName);
        $test = new Test;
        $test->setName($testName);
        $event = new HealthCheckEvent;
        $event->setTestSuite($testSuite);
        $event->setTestGroup($testGroup);
        $event->setTest($test);
        return $event;
    }


    public function testTestStarted()
    {
        $testSuiteName = 'TestSuite';
        $testGroupName = 'TestGroup';
        $testName = 'Test';
        $event = $this->makeEvent($testSuiteName, $testGroupName, $testName);
        $reporter = new ConsoleTableReporter;
        $reporter->testStarted($event);
        $expected = array(
            $testSuiteName,
            $testGroupName,
            $testName,
        );
        $this->assertSame($expected, $reporter->getRow());
    }


    public function testTestPassed()
    {
        $testSuiteName = 'TestSuite';
        $testGroupName = 'TestGroup';
        $testName = 'Test';
        $event = $this->makeEvent($testSuiteName, $testGroupName, $testName);
        $reporter = new ConsoleTableReporter;
        $reporter->testPassed($event);
        $expected = array(
            '<info>' . Test::STATE_PASSED . '</info>',
        );
        $this->assertSame($expected, $reporter->getRow());
    }
    
   
    public function testTestFailed()
    {
        $testSuiteName = 'TestSuite';
        $testGroupName = 'TestGroup';
        $testName = 'Test';
        $event = $this->makeEvent($testSuiteName, $testGroupName, $testName);
        $reporter = new ConsoleTableReporter;
        $reporter->testFailed($event);
        $expected = array(
            '<error>' . Test::STATE_FAILED . '</error>',
        );
        $this->assertSame($expected, $reporter->getRow());
    }


    public function testTestSkipped()
    {
        $testSuiteName = 'TestSuite';
        $testGroupName = 'TestGroup';
        $testName = 'Test';
        $event = $this->makeEvent($testSuiteName, $testGroupName, $testName);
        $reporter = new ConsoleTableReporter;
        $reporter->testSkipped($event);
        $expected = array(
            '<comment>' . Test::STATE_SKIPPED . '</comment>',
        );
        $this->assertSame($expected, $reporter->getRow());
    }


    public function testTestError()
    {
        $testSuiteName = 'TestSuite';
        $testGroupName = 'TestGroup';
        $testName = 'Test';
        $event = $this->makeEvent($testSuiteName, $testGroupName, $testName);
        $reporter = new ConsoleTableReporter;
        $reporter->testError($event);
        $expected = array(
            '<error>' . Test::STATE_ERROR . '</error>',
        );
        $this->assertSame($expected, $reporter->getRow());
    }


    public function dataHealthCheckStarted()
    {
        return array(
            'normal output' => array(
                'isVerbose' => false,
                'expected' => array(
                    'Test Suite',
                    'Test Group',
                    'Test',
                    'Result',
                ),
            ),
            'verbose output' => array(
                'isVerbose' => true,
                'expected' => array(
                    'Test Suite',
                    'Test Group',
                    'Test',
                    'Result',
                    'Reason',
                ),
            ),
        );
    }


    /**
     * @param boolean $isVerbose
     * @param array $expected
     *
     * @dataProvider dataHealthCheckStarted
     */
    public function testHealthCheckStarted($isVerbose, array $expected)
    {
        $mockTableHelper = $this->getMockBuilder('Symfony\Component\Console\Helper\TableHelper')
            ->disableOriginalConstructor()
            ->setMethods((array) 'setHeaders')
            ->getMock();
        $mockConsoleOutput = $this->getMockBuilder('Symfony\Component\Console\Output\ConsoleOutput')
            ->disableOriginalConstructor()
            ->setMethods((array) 'isVerbose')
            ->getMock();
        $mockConsoleOutput->expects($this->once())
            ->method('isVerbose')
            ->will($this->returnValue($isVerbose));
        $mockTableHelper->expects($this->once())
            ->method('setHeaders')
            ->with($expected);
        $reporter = new ConsoleTableReporter;
        $reporter->setConsoleOutput($mockConsoleOutput);
        $reporter->setTableHelper($mockTableHelper);
        $event = new HealthCheckEvent;
        $reporter->healthCheckStarted($event);
    }


    public function testHealthCheckCompleted()
    {
        $mockTableHelper = $this->getMockBuilder('Symfony\Component\Console\Helper\TableHelper')
            ->disableOriginalConstructor()
            ->setMethods((array) 'render')
            ->getMock();
        $mockConsoleOutput = $this->getMockBuilder('Symfony\Component\Console\Output\ConsoleOutput')
            ->disableOriginalConstructor()
            ->setMethods((array) 'isVerbose')
            ->getMock();
        $mockConsoleOutput->expects($this->any())
            ->method('isVerbose')
            ->will($this->returnValue(false));
        $mockTableHelper->expects($this->once())
            ->method('render')
            ->with($mockConsoleOutput);
        $reporter = new ConsoleTableReporter;
        $reporter->setConsoleOutput($mockConsoleOutput);
        $reporter->setTableHelper($mockTableHelper);
        $event = new HealthCheckEvent;
        $reporter->healthCheckCompleted($event);
    }


    public function dataTestCompleted()
    {
        return array(
            'normal output' => array(
                'isVerbose' => false,
                'reason' => 'Reason',
                'expected' => array(
                    'TestSuite',
                    'TestGroup',
                    'Test',
                ),
            ),
            'verbose output' => array(
                'isVerbose' => true,
                'reason' => 'Reason',
                'expected' => array(
                    'TestSuite',
                    'TestGroup',
                    'Test',
                    'Reason',
                ),
            ),
        );
    }


    /**
     * @param boolean $isVerbose
     * @param string $reason
     * @param array $expected
     *
     * @dataProvider dataTestCompleted
     */
    public function testTestCompleted($isVerbose, $reason, array $expected)
    {
        $mockTableHelper = $this->getMockBuilder('Symfony\Component\Console\Helper\TableHelper')
            ->disableOriginalConstructor()
            ->setMethods((array) 'addRow')
            ->getMock();
        $mockConsoleOutput = $this->getMockBuilder('Symfony\Component\Console\Output\ConsoleOutput')
            ->disableOriginalConstructor()
            ->setMethods((array) 'isVerbose')
            ->getMock();
        $mockConsoleOutput->expects($this->any())
            ->method('isVerbose')
            ->will($this->returnValue($isVerbose));
        $mockTableHelper->expects($this->once())
            ->method('render')
            ->with($expected);
        $event = $this->makeEvent('TestSuite', 'TestGroup', 'Test');
        $reporter = new ConsoleTableReporter;
        $reporter->setConsoleOutput($mockConsoleOutput);
        $reporter->setTableHelper($mockTableHelper);
        $reporter->testStarted($event);
        $event->getTest()->setReason($reason);
        $reporter->testCompleted($event);
    }

}
