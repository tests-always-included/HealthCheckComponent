<?php

namespace TestsAlwaysIncluded\HealthCheck\Tests\Service;

use TestsAlwaysIncluded\HealthCheck\Event\HealthCheckEvent;
use TestsAlwaysIncluded\HealthCheck\Exception\HealthCheckException;
use TestsAlwaysIncluded\HealthCheck\HealthCheckEvents;
use TestsAlwaysIncluded\HealthCheck\Service\HealthCheck;
use TestsAlwaysIncluded\HealthCheck\Test\Test;
use TestsAlwaysIncluded\HealthCheck\Test\TestGroup;
use TestsAlwaysIncluded\HealthCheck\Test\TestSuite;
use TestsAlwaysIncluded\HealthCheck\Reporter\Reporter;

class HealthCheckTest extends \PHPUnit_Framework_TestCase
{
    public function testRegisterReporter()
    {
        $reporter = new Reporter;
        $healthCheck = new HealthCheck;
        $healthCheck->registerReporter($reporter);
        $expected = array(
            'TestsAlwaysIncluded\HealthCheck\Reporter\Reporter' => $reporter
        );
        $reporters = $healthCheck->getReporters();
        $this->assertSame(1, count($reporters));
        foreach ($expected as $alias => $object) {
            $this->assertTrue(array_key_exists($alias, $reporters));
            $this->assertSame($object, $reporters[$alias]);
        }
    }


    public function testRegisterReporterWithDuplicate()
    {
        $reporter = new Reporter;
        $healthCheck = new HealthCheck;
        $healthCheck->registerReporter($reporter);
        $healthCheck->registerReporter($reporter);
        $expected = array(
            'TestsAlwaysIncluded\HealthCheck\Reporter\Reporter' => $reporter
        );
        $reporters = $healthCheck->getReporters();
        $this->assertSame(1, count($reporters));
        foreach ($expected as $alias => $object) {
            $this->assertTrue(array_key_exists($alias, $reporters));
            $this->assertSame($object, $reporters[$alias]);
        }
    }


    public function testRegisterReporterWithAliasedDuplicate()
    {
        $reporter = new Reporter;
        $healthCheck = new HealthCheck;
        $healthCheck->registerReporter($reporter);
        $healthCheck->registerReporter($reporter, 'hello');
        $expected = array(
            'TestsAlwaysIncluded\HealthCheck\Reporter\Reporter' => $reporter,
            'hello' => $reporter
        );
        $reporters = $healthCheck->getReporters();
        $this->assertSame(count($expected), count($reporters));
        foreach ($expected as $alias => $object) {
            $this->assertTrue(array_key_exists($alias, $reporters));
            $this->assertSame($object, $reporters[$alias]);
        }
    }


    public function dataRun()
    {
        return array(
            '1 suite, 1 group, 1 test, passed' => array(
                'testCalls' => array(
                    'passed' => array(
                        'args' => null,
                        'return' => true,
                    ),
                ),
                'exceptionData' => null,
                'catchException' => null,
                'expectedCalls' => array(
                    HealthCheckEvent::EVENT_HEALTH_CHECK_STARTED => array(),
                    HealthCheckEvent::EVENT_TEST_SUITE_STARTED => array(true, null, null),
                    HealthCheckEvent::EVENT_TEST_GROUP_STARTED => array(true, true, null),
                    HealthCheckEvent::EVENT_TEST_STARTED => array(true, true, true),
                    HealthCheckEvent::EVENT_TEST_PASSED => array(true, true, true),
                    HealthCheckEvent::EVENT_TEST_COMPLETED => array(true, true, true),
                    HealthCheckEvent::EVENT_TEST_GROUP_COMPLETED => array(true, true, null),
                    HealthCheckEvent::EVENT_TEST_SUITE_COMPLETED => array(true, null, null),
                    HealthCheckEvent::EVENT_HEALTH_CHECK_COMPLETED => array(),
                ),
            ),
            '1 suite, 1 group, 1 test, failed' => array(
                'testCalls' => array(
                    'failed' => array(
                        'args' => null,
                        'return' => true,
                    ),
                ),
                'exceptionData' => null,
                'catchException' => null,
                'expectedCalls' => array(
                    HealthCheckEvent::EVENT_HEALTH_CHECK_STARTED => array(),
                    HealthCheckEvent::EVENT_TEST_SUITE_STARTED => array(true, null, null),
                    HealthCheckEvent::EVENT_TEST_GROUP_STARTED => array(true, true, null),
                    HealthCheckEvent::EVENT_TEST_STARTED => array(true, true, true),
                    HealthCheckEvent::EVENT_TEST_FAILED => array(true, true, true),
                    HealthCheckEvent::EVENT_TEST_COMPLETED => array(true, true, true),
                    HealthCheckEvent::EVENT_TEST_GROUP_COMPLETED => array(true, true, null),
                    HealthCheckEvent::EVENT_TEST_SUITE_COMPLETED => array(true, null, null),
                    HealthCheckEvent::EVENT_HEALTH_CHECK_COMPLETED => array(),
                ),

            ),
            '1 suite, 1 group, 1 test, skipped' => array(
                'testCalls' => array(
                    'skipped' => array(
                        'args' => null,
                        'return' => true,
                    ),
                ),
                'exceptionData' => null,
                'catchException' => null,
                'expectedCalls' => array(
                    HealthCheckEvent::EVENT_HEALTH_CHECK_STARTED => array(),
                    HealthCheckEvent::EVENT_TEST_SUITE_STARTED => array(true, null, null),
                    HealthCheckEvent::EVENT_TEST_GROUP_STARTED => array(true, true, null),
                    HealthCheckEvent::EVENT_TEST_STARTED => array(true, true, true),
                    HealthCheckEvent::EVENT_TEST_SKIPPED => array(true, true, true),
                    HealthCheckEvent::EVENT_TEST_COMPLETED => array(true, true, true),
                    HealthCheckEvent::EVENT_TEST_GROUP_COMPLETED => array(true, true, null),
                    HealthCheckEvent::EVENT_TEST_SUITE_COMPLETED => array(true, null, null),
                    HealthCheckEvent::EVENT_HEALTH_CHECK_COMPLETED => array(),
                ),
            ),
            '1 suite, 1 group, 1 test, error' => array(
                'testCalls' => array(
                    'inError' => array(
                        'args' => null,
                        'return' => true,
                    ),
                ),
                'exceptionData' => null,
                'catchException' => null,
                'expectedCalls' => array(
                    HealthCheckEvent::EVENT_HEALTH_CHECK_STARTED => array(),
                    HealthCheckEvent::EVENT_TEST_SUITE_STARTED => array(true, null, null),
                    HealthCheckEvent::EVENT_TEST_GROUP_STARTED => array(true, true, null),
                    HealthCheckEvent::EVENT_TEST_STARTED => array(true, true, true),
                    HealthCheckEvent::EVENT_TEST_ERROR => array(true, true, true),
                    HealthCheckEvent::EVENT_TEST_COMPLETED => array(true, true, true),
                    HealthCheckEvent::EVENT_TEST_GROUP_COMPLETED => array(true, true, null),
                    HealthCheckEvent::EVENT_TEST_SUITE_COMPLETED => array(true, null, null),
                    HealthCheckEvent::EVENT_HEALTH_CHECK_COMPLETED => array(),
                ),
            ),
            '1 suite, 1 group, 1 test, uncaught exception' => array(
                'testCalls' => array(),
                'exceptionData' => array(
                    'class' => 'ErrorException',
                    'message' => 'Cant Catch Me',
                ),
                'catchException' => false,
                'expectedCalls' => array(
                    HealthCheckEvent::EVENT_HEALTH_CHECK_STARTED => array(),
                    HealthCheckEvent::EVENT_TEST_SUITE_STARTED => array(true, null, null),
                    HealthCheckEvent::EVENT_TEST_GROUP_STARTED => array(true, true, null),
                    HealthCheckEvent::EVENT_TEST_STARTED => array(true, true, true),
                ),
            ),
            '1 suite, 1 group, 1 test, caught exception' => array(
                'testCalls' => array(
                    'error' => array(
                        'args' => 'You caught me',
                        'return' => null,
                    ),
                    'inError' => array(
                        'args' => null,
                        'return' => true,
                    ),
                ),
                'exceptionData' => array(
                    'class' => 'TestsAlwaysIncluded\HealthCheck\Exception\HealthCheckException',
                    'message' => 'You caught me',
                ),
                'catchException' => true,
                'expectedCalls' => array(
                    HealthCheckEvent::EVENT_HEALTH_CHECK_STARTED => array(),
                    HealthCheckEvent::EVENT_TEST_SUITE_STARTED => array(true, null, null),
                    HealthCheckEvent::EVENT_TEST_GROUP_STARTED => array(true, true, null),
                    HealthCheckEvent::EVENT_TEST_STARTED => array(true, true, true),
                    HealthCheckEvent::EVENT_TEST_ERROR => array(true, true, true),
                    HealthCheckEvent::EVENT_TEST_COMPLETED => array(true, true, true),
                    HealthCheckEvent::EVENT_TEST_GROUP_COMPLETED => array(true, true, null),
                    HealthCheckEvent::EVENT_TEST_SUITE_COMPLETED => array(true, null, null),
                    HealthCheckEvent::EVENT_HEALTH_CHECK_COMPLETED => array(),
                ),
            ),
        );
    }


    /**
     * @dataProvider dataRun
     */
    public function testRun($testCalls, $exceptionData, $catchException, $expectedCalls)
    {
        $healthCheck = new HealthCheck;
        $testSuite = new TestSuite;
        $testGroup = new TestGroup;
        $mockTest = $this->getMockBuilder('TestsAlwaysIncluded\HealthCheck\Test\Test')
            ->setMethods(array_keys($test))
            ->getMock();
        $chain = $mockTest->expects($this->once())
            ->method('execute');
        if ($exceptionData) {
            $exception = new $exceptionData['class']($exceptionData['message']);
            $chain->will($this->throwException($exception));
        }
        foreach ($testCalls as $methodName => $options) {
            $chain = $mockTest->expects($this->once())
                ->method($methodName)
                ->with($options['args'])
                ->will($this->returnValue($options['return']));
        }
        $mockDispatcher = $this->getMockBuilder('Symfony\Component\EventDispatcher\EventDispatcher')
            ->disableOriginalConstructor()
            ->setMethods((array) 'dispatch')
            ->getMock();
        $nextEvent = function () use (&$expectedCalls, $testSuite, $testGroup, $test) {
            $eventName = key($expectedCalls);
            $eventArgs = array_shift($expectedCalls);
            $event = new HealthCheckEvent;
            if ($eventArgs[0]) {
                $event->setTestSuite($testSuite);
            }
            if ($eventArgs[1]) {
                $event->setTestGroup($testGroup);
            }
            if ($eventArgs[2]) {
                $event->setTest($test);
            }
            return array(
                $eventName,
                $event
            );
        };
        $mockDispatcher->expects($this->exactly(count($expectedCalls)))
            ->method('dispatch')
            ->with($this->returnCallback($nextEvent));
        $testSuite->addTestGroup($testGroup);
        $testGroup->addTest($test);
        $healthCheck->registerTestSuite($testSuite);
        if ($catchException === false) {
            $this->setExpectedException($exceptionData['class'], $exceptionData['message']);
        }
        $healthCheck->run();
    }
}
