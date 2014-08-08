<?php

namespace TestsAlwaysIncluded\HealthCheck\Reporter;

use Symfony\Component\Console\Output\ConsoleOutput;

abstract class AbstractConsoleReporter implements ConsoleOutputReporterInterface
{
    /** @var ConsoleOutput */
    protected $consoleOutput;


    /**
     * @param Output $output
     */
    public function setConsoleOutput(ConsoleOutput $consoleOutput)
    {
        $this->consoleOutput = $consoleOutput;
    }
}
