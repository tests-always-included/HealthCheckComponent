<?php

namespace TestsAlwaysIncluded\HealthCheck\Exception;

class HealthCheckException extends \Exception
{

    /**
     * @param \string $message
     * @param \int $code
     * @param Exception $previous
     */
    public function __construct($message = null, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }


    /**
     * @param \string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }


    /**
     * @param \int $line
     */
    public function setLine($line)
    {
        $this->line = $line;
    }
}
