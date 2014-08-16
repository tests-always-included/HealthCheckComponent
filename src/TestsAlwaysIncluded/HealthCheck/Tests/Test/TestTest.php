<?php

namespace TestsAlwaysIncluded\HealthCheck\Tests\Test;

use TestsAlwaysIncluded\HealthCheck\Test\Test;

class TestTest extends \PHPUnit_Framework_TestCase
{
    protected function makeTest($name)
    {
        return $this->getMockBuilder('TestsAlwaysIncluded\HealthCheck\Test\Test')
            ->setConstructorArgs(array($name))
            ->getMockForAbstractClass();
    }

    public function testSetGetName()
    {
        $name = 'hello';
        $test = $this->makeTest($name);
        $test->setName($name);
        $this->assertSame($name, $test->getName());
    }


    public function testPassed()
    {
        $reason = 'hello';
        $test = $this->makeTest('test');
        $test->pass($reason);
        $this->assertTrue($test->passed());
        $this->assertFalse($test->failed());
        $this->assertFalse($test->inError());
        $this->assertFalse($test->skipped());
        $this->assertSame($reason, $test->getReason());
    }


    public function testFailed()
    {
        $reason = 'hello';
        $test = $this->makeTest('test');
        $test->fail($reason);
        $this->assertTrue($test->failed());
        $this->assertFalse($test->passed());
        $this->assertFalse($test->inError());
        $this->assertFalse($test->skipped());
        $this->assertSame($reason, $test->getReason());
    }


    public function testSkipped()
    {
        $reason = 'hello';
        $test = $this->makeTest('test');
        $test->skip($reason);
        $this->assertTrue($test->skipped());
        $this->assertFalse($test->failed());
        $this->assertFalse($test->inError());
        $this->assertFalse($test->passed());
        $this->assertSame($reason, $test->getReason());
    }


    public function testError()
    {
        $reason = 'hello';
        $test = $this->makeTest('test');
        $test->error($reason);
        $this->assertTrue($test->inError());
        $this->assertFalse($test->failed());
        $this->assertFalse($test->passed());
        $this->assertFalse($test->skipped());
        $this->assertSame($reason, $test->getReason());
    }
}
