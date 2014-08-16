<?php

namespace TestsAlwaysIncluded\HealthCheck\Test;

abstract class Test
{
    /** @const string */
    const STATE_PASSED = 'PASS';


    /** @const string */
    const STATE_FAILED = 'FAIL';


    /** @const string */
    const STATE_SKIPPED = 'SKIP';


    /** @const string */
    const STATE_ERROR = 'ERROR';


    /** @var string */
    protected $state;


    /** @var string */
    protected $name;


    /** @var string */
    protected $reason;


    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }


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
     * @param string $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }


    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }


    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }


    /**
     * @return boolean
     */
    public function inError()
    {
        return $this->state === static::STATE_ERROR;
    }


    /**
     * @return boolean
     */
    public function failed()
    {
        return $this->state === static::STATE_FAILED;
    }


    /**
     * @return boolean
     */
    public function passed()
    {
        return $this->state === static::STATE_PASSED;
    }


    /**
     * @return boolean
     */
    public function skipped()
    {
        return $this->state === static::STATE_SKIPPED;
    }


    /**
     * @param string $reason
     */
    public function pass($reason = null)
    {
        $this->setReason($reason);
        $this->state = static::STATE_PASSED;
    }


    /**
     * @param string $reason
     */
    public function fail($reason = null)
    {
        $this->setReason($reason);
        $this->state = static::STATE_FAILED;
    }


    /**
     * @param string $reason
     */
    public function error($reason = null)
    {
        $this->setReason($reason);
        $this->state = static::STATE_ERROR;
    }


    /**
     * @param string $reason
     */
    public function skip($reason = null)
    {
        $this->setReason($reason);
        $this->state = static::STATE_SKIPPED;
    }


    /**
     * Executes the test.
     * Implementations MUST pass/fail/skip/error.
     */
    abstract public function execute();
}
