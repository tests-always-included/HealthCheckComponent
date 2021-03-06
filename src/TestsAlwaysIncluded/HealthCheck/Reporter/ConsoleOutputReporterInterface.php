<?php

namespace TestsAlwaysIncluded\HealthCheck\Reporter;

use Symfony\Component\Console\Output\ConsoleOutput;

interface ConsoleOutputReporterInterface
{
    /** @param ConsoleOutput $consoleOutput */
    public function setConsoleOutput(ConsoleOutput $consoleOutput);
}
