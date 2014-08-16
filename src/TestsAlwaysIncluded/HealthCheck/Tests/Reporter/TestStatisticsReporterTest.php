<?php

namespace TestsAlwaysIncludedd\HealthCheck\Tests\Reporter;

use TestsAlwaysIncluded\HealthCheck\Test\Test;
use TestsAlwaysIncluded\HealthCheck\Event\HealthCheckEvent;
use TestsAlwaysIncluded\HealthCheck\Reporter\TestStatisticsReporter;

class TestStatisticsReporterTest extends \PHPUnit_Framework_TestCase
{
    protected function makeTest()
    {
        return $this->getMockBuilder('TestsAlwaysIncluded\HealthCheck\Test\Test')
            ->setConstructorArgs(array('test'))
            ->getMockForAbstractClass();
    }

    public function testGetFailed()
    {
        $test = $this->makeTest();
        $test->fail();
        $event = new HealthCheckEvent();
        $event->setTest($test);
        $reporter = new TestStatisticsReporter;
        $reporter->testFailed($event);
        $this->assertSame(1, $reporter->getFailed());
        $this->assertSame(0, $reporter->getPassed());
        $this->assertSame(0, $reporter->getSkipped());
        $this->assertSame(0, $reporter->getErrors());
        $this->assertSame(0, $reporter->getRun());
    }


    public function testGetPassed()
    {
        $test = $this->makeTest();
        $test->pass();
        $event = new HealthCheckEvent();
        $event->setTest($test);
        $reporter = new TestStatisticsReporter;
        $reporter->testPassed($event);
        $this->assertSame(1, $reporter->getPassed());
        $this->assertSame(0, $reporter->getFailed());
        $this->assertSame(0, $reporter->getSkipped());
        $this->assertSame(0, $reporter->getErrors());
        $this->assertSame(0, $reporter->getRun());
    }


    public function testGetSkipped()
    {
        $test = $this->makeTest();
        $test->skip();
        $event = new HealthCheckEvent();
        $event->setTest($test);
        $reporter = new TestStatisticsReporter;
        $reporter->testSkipped($event);
        $this->assertSame(1, $reporter->getSkipped());
        $this->assertSame(0, $reporter->getFailed());
        $this->assertSame(0, $reporter->getPassed());
        $this->assertSame(0, $reporter->getErrors());
        $this->assertSame(0, $reporter->getRun());
    }


    public function testGetErrors()
    {
        $test = $this->makeTest();
        $test->error();
        $event = new HealthCheckEvent();
        $event->setTest($test);
        $reporter = new TestStatisticsReporter;
        $reporter->testError($event);
        $this->assertSame(1, $reporter->getErrors());
        $this->assertSame(0, $reporter->getFailed());
        $this->assertSame(0, $reporter->getSkipped());
        $this->assertSame(0, $reporter->getPassed());
        $this->assertSame(0, $reporter->getRun());
    }


    public function testGetRun()
    {
        $test = $this->makeTest();
        $event = new HealthCheckEvent();
        $event->setTest($test);
        $reporter = new TestStatisticsReporter;
        $reporter->testStarted($event);
        $this->assertSame(1, $reporter->getRun());
        $this->assertSame(0, $reporter->getErrors());
        $this->assertSame(0, $reporter->getFailed());
        $this->assertSame(0, $reporter->getSkipped());
        $this->assertSame(0, $reporter->getPassed());
    }

}
