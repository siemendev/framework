<?php

declare(strict_types=1);

namespace App\Orchestrator;

class ServiceB implements ServiceInterface
{
    public function get(): string
    {
        return 'Service B';
    }
}
