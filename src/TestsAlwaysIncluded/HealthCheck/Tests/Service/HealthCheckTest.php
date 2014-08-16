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
}
