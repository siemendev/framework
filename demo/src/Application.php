<?php

declare(strict_types=1);

namespace App;

use Framework\Application as FrameworkApplication;
use Framework\Environment\ConfigExtension;
use Framework\Configuration;
use Framework\Orchestrator\OrchestratorExtension;

class Application extends FrameworkApplication
{
    public function __construct(string $projectRoot)
    {
        parent::__construct((new Configuration())->setProjectRoot($projectRoot));

        $this
            ->addExtension(new ConfigExtension())
            ->addExtension(new OrchestratorExtension())
        ;
    }
}
