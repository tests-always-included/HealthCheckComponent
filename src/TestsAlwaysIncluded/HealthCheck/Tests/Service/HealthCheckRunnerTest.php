<?php

namespace TestsAlwaysIncluded\HealthCheck\Tests\Service;

use TestsAlwaysIncluded\HealthCheck\Event\HealthCheckEvent;
use TestsAlwaysIncluded\HealthCheck\Exception\HealthCheckException;
use TestsAlwaysIncluded\HealthCheck\HealthCheckEvents;
use TestsAlwaysIncluded\HealthCheck\Reporter\Reporter;
use TestsAlwaysIncluded\HealthCheck\Service\HealthCheck;
use TestsAlwaysIncluded\HealthCheck\Service\HealthCheckRunner;
use TestsAlwaysIncluded\HealthCheck\Test\Test;
use TestsAlwaysIncluded\HealthCheck\Test\TestGroup;
use TestsAlwaysIncluded\HealthCheck\Test\TestSuite;

class HealthCheckRunnerTest extends \PHPUnit_Framework_TestCase
{
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
                    HealthCheckEvents::EVENT_HEALTH_CHECK_STARTED => array(),
                    HealthCheckEvents::EVENT_TEST_SUITE_STARTED => array(true, null, null),
                    HealthCheckEvents::EVENT_TEST_GROUP_STARTED => array(true, true, null),
                    HealthCheckEvents::EVENT_TEST_STARTED => array(true, true, true),
                    HealthCheckEvents::EVENT_TEST_PASSED => array(true, true, true),
                    HealthCheckEvents::EVENT_TEST_COMPLETED => array(true, true, true),
                    HealthCheckEvents::EVENT_TEST_GROUP_COMPLETED => array(true, true, null),
                    HealthCheckEvents::EVENT_TEST_SUITE_COMPLETED => array(true, null, null),
                    HealthCheckEvents::EVENT_HEALTH_CHECK_COMPLETED => array(),
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
                    HealthCheckEvents::EVENT_HEALTH_CHECK_STARTED => array(),
                    HealthCheckEvents::EVENT_TEST_SUITE_STARTED => array(true, null, null),
                    HealthCheckEvents::EVENT_TEST_GROUP_STARTED => array(true, true, null),
                    HealthCheckEvents::EVENT_TEST_STARTED => array(true, true, true),
                    HealthCheckEvents::EVENT_TEST_FAILED => array(true, true, true),
                    HealthCheckEvents::EVENT_TEST_COMPLETED => array(true, true, true),
                    HealthCheckEvents::EVENT_TEST_GROUP_COMPLETED => array(true, true, null),
                    HealthCheckEvents::EVENT_TEST_SUITE_COMPLETED => array(true, null, null),
                    HealthCheckEvents::EVENT_HEALTH_CHECK_COMPLETED => array(),
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
                    HealthCheckEvents::EVENT_HEALTH_CHECK_STARTED => array(),
                    HealthCheckEvents::EVENT_TEST_SUITE_STARTED => array(true, null, null),
                    HealthCheckEvents::EVENT_TEST_GROUP_STARTED => array(true, true, null),
                    HealthCheckEvents::EVENT_TEST_STARTED => array(true, true, true),
                    HealthCheckEvents::EVENT_TEST_SKIPPED => array(true, true, true),
                    HealthCheckEvents::EVENT_TEST_COMPLETED => array(true, true, true),
                    HealthCheckEvents::EVENT_TEST_GROUP_COMPLETED => array(true, true, null),
                    HealthCheckEvents::EVENT_TEST_SUITE_COMPLETED => array(true, null, null),
                    HealthCheckEvents::EVENT_HEALTH_CHECK_COMPLETED => array(),
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
                    HealthCheckEvents::EVENT_HEALTH_CHECK_STARTED => array(),
                    HealthCheckEvents::EVENT_TEST_SUITE_STARTED => array(true, null, null),
                    HealthCheckEvents::EVENT_TEST_GROUP_STARTED => array(true, true, null),
                    HealthCheckEvents::EVENT_TEST_STARTED => array(true, true, true),
                    HealthCheckEvents::EVENT_TEST_ERROR => array(true, true, true),
                    HealthCheckEvents::EVENT_TEST_COMPLETED => array(true, true, true),
                    HealthCheckEvents::EVENT_TEST_GROUP_COMPLETED => array(true, true, null),
                    HealthCheckEvents::EVENT_TEST_SUITE_COMPLETED => array(true, null, null),
                    HealthCheckEvents::EVENT_HEALTH_CHECK_COMPLETED => array(),
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
                    HealthCheckEvents::EVENT_HEALTH_CHECK_STARTED => array(),
                    HealthCheckEvents::EVENT_TEST_SUITE_STARTED => array(true, null, null),
                    HealthCheckEvents::EVENT_TEST_GROUP_STARTED => array(true, true, null),
                    HealthCheckEvents::EVENT_TEST_STARTED => array(true, true, true),
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
                    HealthCheckEvents::EVENT_HEALTH_CHECK_STARTED => array(),
                    HealthCheckEvents::EVENT_TEST_SUITE_STARTED => array(true, null, null),
                    HealthCheckEvents::EVENT_TEST_GROUP_STARTED => array(true, true, null),
                    HealthCheckEvents::EVENT_TEST_STARTED => array(true, true, true),
                    HealthCheckEvents::EVENT_TEST_ERROR => array(true, true, true),
                    HealthCheckEvents::EVENT_TEST_COMPLETED => array(true, true, true),
                    HealthCheckEvents::EVENT_TEST_GROUP_COMPLETED => array(true, true, null),
                    HealthCheckEvents::EVENT_TEST_SUITE_COMPLETED => array(true, null, null),
                    HealthCheckEvents::EVENT_HEALTH_CHECK_COMPLETED => array(),
                ),
            ),
        );
    }


    /**
     * @dataProvider dataRun
     */
    public function testRun($testCalls, $exceptionData, $catchException, $expectedCalls)
    {
        $testSuite = new TestSuite;
        $testGroup = new TestGroup;
        $mockTest = $this->getMockBuilder('TestsAlwaysIncluded\HealthCheck\Test\Test')
            ->setConstructorArgs(array('test'))
            ->setMethods(array_merge(array('execute'), array_keys($testCalls)))
            ->getMockForAbstractClass();
        $chain = $mockTest->expects($this->once())
            ->method('execute');
        if ($exceptionData) {
            $exception = new $exceptionData['class']($exceptionData['message']);
            $chain->will($this->throwException($exception));
        }
        foreach ($testCalls as $methodName => $options) {
            $chain = $mockTest->expects($this->once())
                ->method($methodName);
            if (! empty($options['args'])) {
                $chain->with($options['args']);
            }
            $chain->will($this->returnValue($options['return']));
        }
        $mockDispatcher = $this->getMockBuilder('Symfony\Component\EventDispatcher\EventDispatcher')
            ->disableOriginalConstructor()
            ->setMethods((array) 'dispatch')
            ->getMock();
        $healthCheck = new HealthCheck;
        $nextEvent = function () use (&$expectedCalls, $healthCheck, $testSuite, $testGroup, $mockTest) {
            $eventName = key($expectedCalls);
            $eventArgs = array_shift($expectedCalls);
            $event = new HealthCheckEvent;
            $event->setHealthCheck($healthCheck);
            if (! empty($eventArgs[0])) {
                $event->setTestSuite($testSuite);
            }
            if (! empty($eventArgs[1])) {
                $event->setTestGroup($testGroup);
            }
            if (! empty($eventArgs[2])) {
                $event->setTest($mockTest);
            }
            return array($eventName, $event);
        };
        $mockDispatcher->expects($this->exactly(count($expectedCalls)))
            ->method('dispatch')
            ->with($this->callback($nextEvent));
        $testSuite->addTestGroup($testGroup);
        $testGroup->addTest($mockTest);
        $healthCheck->addTestSuite($testSuite);
        if ($catchException === false) {
            $this->setExpectedException($exceptionData['class'], $exceptionData['message']);
        }
        $runner = new HealthCheckRunner();
        $runner->setEventDispatcher($mockDispatcher);
        $runner->run($healthCheck);
    }
}
