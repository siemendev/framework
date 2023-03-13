<?php

declare(strict_types=1);

namespace App\Orchestrator;

class ServiceA implements ServiceInterface
{
    public function get(): string
    {
        return 'Service A';
    }
}
