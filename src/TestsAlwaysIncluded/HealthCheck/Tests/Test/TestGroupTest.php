<?php

namespace TestsAlwaysIncluded\HealthCheck\Tests\Test;

use TestsAlwaysIncluded\HealthCheck\Test\Test;
use TestsAlwaysIncluded\HealthCheck\Test\TestGroup;

class TestGroupTest extends \PHPUnit_Framework_TestCase
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
        $testGroup = new TestGroup();
        $testGroup->setName($name);
        $this->assertSame($name, $testGroup->getName());
    }


    public function testSetGetTests()
    {
        $test = $this->makeTest('TEST#1');
        $test2 = $this->makeTest('TEST#2');
        $testGroup = new TestGroup();
        $tests = array(
            $test,
            $test2
        );
        $testGroup->setTests($tests);
        $this->assertSame($tests, $testGroup->getTests());
    }


    public function testAddTest()
    {
        $test = $this->makeTest('TEST');
        $testGroup = new TestGroup();
        $testGroup->addTest($test);
        $expected = array(
            $test,
        );
        $this->assertSame($expected, $testGroup->getTests());
    }
}
