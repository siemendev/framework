<?php

declare(strict_types=1);

namespace Framework\Console;

use Framework\Application;

class ConsoleFrontend
{
    public function __construct(
        private readonly Application $application,
    ) {
    }

    public function run(): void
    {
        $entrypoint = new Entrypoint();

        $this->application
            ->addEntrypoint($entrypoint)
            ->boot()
        ;

        exit(
            $entrypoint->getConsole()->run()
        );
    }
}
