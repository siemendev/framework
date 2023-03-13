<?php

declare(strict_types=1);

namespace App\Orchestrator;

interface ServiceInterface
{
    public function get(): string;
}
