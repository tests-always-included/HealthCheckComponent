<?php

namespace TestsAlwaysIncluded\HealthCheck\Tests\Strategy;

use TestsAlwaysIncluded\HealthCheck\Service\HealthCheck;
use TestsAlwaysIncluded\HealthCheck\Strategy\PassFailSuccessStrategy;
use TestsAlwaysIncluded\HealthCheck\Test\TestGroup;
use TestsAlwaysIncluded\HealthCheck\Test\TestSuite;

class PassFailSuccessStrategyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return PHPUnit_Mock_Object
     */
    protected function makeTest($callMethod)
    {
        $test = $this->getMockBuilder('TestsAlwaysIncluded\HealthCheck\Test\Test')
            ->setConstructorArgs(array('test'))
            ->setMethods(array('iNeedAMethodToMakeAMock'))
            ->getMockForAbstractClass();
        call_user_func_array(array($test, $callMethod), array());
        return $test;
    }


    public function dataExecute()
    {
        return array(
            '1 test, failed, expect false' => array(
                'tests' => array(
                    'fail',
                ),
                'treatSkipAsFail' => false,
                'expected' => false,
            ),
            '1 test, passed, expect true' => array(
                'tests' => array(
                    'pass',
                ),
                'treatSkipAsFail' => false,
                'expected' => true,
            ),
            '1 test, skipped, expect true' => array(
                'tests' => array(
                    'skip',
                ),
                'treatSkipAsFail' => false,
                'expected' => true,
            ),
            '1 test, error, expect false' => array(
                'tests' => array(
                    'error',
                ),
                'treatSkipAsFail' => false,
                'expected' => false,
            ),
            '2 tests, 1 fail, 1 pass, expect false' => array(
                'tests' => array(
                    'fail',
                    'pass',
                ),
                'treatSkipAsFail' => false,
                'expected' => false,
            ),
            '2 tests, 2 pass, expect true' => array(
                'tests' => array(
                    'pass',
                    'pass',
                ),
                'treatSkipAsFail' => false,
                'expected' => true,
            ),
            '2 tests, 2 fail, expect false' => array(
                'tests' => array(
                    'fail',
                    'fail',
                ),
                'treatSkipAsFail' => false,
                'expected' => false,
            ),
            '2 tests, 1 skip, 1 pass, expect true' => array(
               'tests' => array(
                    'skip',
                    'pass',
                ),
                'treatSkipAsFail' => false,
                'expected' => true,
            ),
            '2 tests, 1 error, 1 pass, expect false' => array(
               'tests' => array(
                    'error',
                    'pass',
                ),
                'treatSkipAsFail' => false,
                'expected' => false,
            ),
            '2 tests, 2 errors, expect false' => array(
               'tests' => array(
                    'error',
                    'error',
                ),
                'treatSkipAsFail' => false,
                'expected' => false,
            ),
            '1 test, skip as fail, skipped, expect false' => array(
               'tests' => array(
                    'skip',
                ),
                'treatSkipAsFail' => true,
                'expected' => false,
            ),
            '2 tests, skip as fail, pass, skipped, expect false' => array(
                'tests' => array(
                    'pass',
                    'skip',
                ),
                'treatSkipAsFail' => true,
                'expected' => false,
            ),
        );
    }


    /**
     * @dataProvider dataExecute
     */
    public function testExecute(array $tests, $treatSkipAsFail, $expected)
    {
       $testSuite = new TestSuite('TestSuite');
       $testGroup = new TestGroup('TestGroup');
       foreach ($tests as $forcedState) {
           $test = $this->makeTest($forcedState);
           $testGroup->addTest($test);
       }
       $testSuite->addTestGroup($testGroup);
       $strategy = new PassFailSuccessStrategy;
       $strategy->setTreatSkipAsFail($treatSkipAsFail);
       $healthCheck = new HealthCheck;
       $healthCheck->addTestSuite($testSuite);
       $result = $strategy->execute($healthCheck);
       $this->assertSame($expected, $result);
    }
}
