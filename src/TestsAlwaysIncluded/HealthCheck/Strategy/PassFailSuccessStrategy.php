<?php

namespace TestsAlwaysIncluded\HealthCheck\Strategy;

use TestsAlwaysIncluded\HealthCheck\Service\HealthCheck;

class PassFailSuccessStrategy implements SuccessStrategyInterface
{
    /** @var boolean */
    protected $treatSkipAsFail = false;


    /**
     * @param boolean $treatSkipAsFail
     */
    public function setTreatSkipAsFail($treatSkipAsFail)
    {
        $this->treatSkipAsFail = $treatSkipAsFail;
    }


    /**
     * @param HealthCheck $healthCheck
     * @return boolean
     */
    public function execute(HealthCheck $healthCheck)
    {
        $passing = true;
        foreach ($healthCheck->getTestSuites() as $testSuite) {
            foreach ($testSuite->getTestGroups() as $testGroup) {
                foreach ($testGroup->getTests() as $test) {
                    // Dont count skipped tests against us.
                    if ($test->skipped() && $this->treatSkipAsFail === false) continue;
                    $passing = $passing && $test->passed();
                }
            }
        }

        return $passing;
    }
}
