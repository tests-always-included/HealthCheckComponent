<?php

namespace TestsAlwaysIncluded\HealthCheck\Tests\Test;

use TestsAlwaysIncluded\HealthCheck\Test\TestGroup;
use TestsAlwaysIncluded\HealthCheck\Test\TestSuite;

class TestSuiteTest extends \PHPUnit_Framework_TestCase
{
    public function testSetGetName()
    {
        $name = 'hello';
        $testSuite = new TestSuite();
        $testSuite->setName($name);
        $this->assertSame($name, $testSuite->getName());
    }


    public function testSetGetTestGroups()
    {
        $testGroup1 = new TestGroup;
        $testGroup1->setName('TESTGROUP#1');
        $testGroup2 = new TestGroup;
        $testGroup2->setName('TEST#2');
        $testSuite = new TestSuite();
        $testGroups = array(
            $testGroup1,
            $testGroup2
        );
        $testSuite->setGroups($testGroups);
        $this->assertSame($testGroups, $testSuite->getTestGroups());
    }


    public function testAddTestGroup()
    {
        $testGroup = new TestGroup;
        $testSuite = new TestSuite();
        $testSuite->addTestGroup($testGroup);
        $expected = array(
            $testGroup,
        );
        $this->assertSame($expected, $testSuite->getTestGroups());
    }
}
