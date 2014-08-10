<?php

namespace TestsAlwaysIncludedd\HealthCheck\Tests\Reporter;

use TestsAlwaysIncludd\HealthCheck\Test\Test;
use TestsAlwaysIncluded\HealthCheck\Event\HealthCheckEvent;
use TestsAlwaysIncluded\HealthCheck\Reporter\TestStatisticsReporter;

class TestStatisticsReporterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFailed()
    {
        $test = new Test;
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
        $test = new Test;
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
        $test = new Test;
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
        $test = new Test;
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
        $test = new Test;
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
