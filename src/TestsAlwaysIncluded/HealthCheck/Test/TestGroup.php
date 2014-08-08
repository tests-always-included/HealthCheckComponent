<?php

namespace TestsAlwaysIncluded\HealthCheck\Test;

class TestGroup
{
    /** @var string */
    protected $name;


    /** @var Test[] */
    protected $tests = array();


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
     * @param array|mixed $tests
     */
    public function setTests($tests = array())
    {
        $this->tests = $tests;
    }


    /**
     * @param Test $test
     */
    public function addTest(Test $test)
    {
        $this->tests[] = $test;
    }


    /**
     * @return array|mixed
     */
    public function getTests()
    {
        return $this->tests;
    }
}
