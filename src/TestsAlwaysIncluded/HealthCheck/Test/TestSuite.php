<?php

namespace TestsAlwaysIncluded\HealthCheck\Test;

class TestSuite
{
    /** @var string */
    protected $name;


    /** @var TestGroup[] */
    protected $testGroups = array();


    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param array|mixed $testGroups
     */
    public function setTestGroups($testGroups = array())
    {
        $this->testGroups = $testGroups;
    }


    /**
     * @param TestGroup $test
     */
    public function addTestGroup(TestGroup $testGroup)
    {
        $this->testGroups[] = $testGroup;
    }


    /**
     * @return array|mixed
     */
    public function getTestGroups()
    {
        return $this->testGroups;
    }
}
