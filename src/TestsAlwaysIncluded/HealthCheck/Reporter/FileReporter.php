<?php

namespace TestsAlwaysIncluded\HealthCheck\Reporter;

abstract class FileReporter extends Reporter implements FileReporterInterface
{
    /** @var Resource */
    protected $handle;


    /** @var string */
    protected $filename;


    /** @var string */
    protected $fileMode = 'w';


    /** @var boolean */
    protected $isTemporary = false;


    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }


    /**
     * @param string $filename
     */
    public function setFileMode($fileMode)
    {
        $this->fileMode = $fileMode;
    }


    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }


    /**
     * @param boolean $isTemporary
     */
    public function setIsTemporary($isTemporary)
    {
        $this->isTemporary = $isTemporary;
    }


    /**
     * @return boolean
     */
    public function getIsTemporary()
    {
        return $this->isTemporary;
    }


    /**
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function healthCheckStarted(HealthCheckEvent $healthCheckEvent)
    {
        $filename = $this->getFilename();
        $this->handle = fopen($filename, $this->fileMode);
    }


    /**
     * @param HealthCheckEvent $healthCheckEvent
     */
    public function healthCheckCompleted(HealthCheckEvent $healthCheckEvent)
    {
        fclose($this->handle);
    }
}
