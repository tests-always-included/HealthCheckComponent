<?php

namespace TestsAlwaysIncluded\HealthCheck\Reporter;

use Symfony\Component\Console\Output\ConsoleOutput;

abstract class AbstractConsoleReporter extends Reporter implements ConsoleOutputReporterInterface
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
