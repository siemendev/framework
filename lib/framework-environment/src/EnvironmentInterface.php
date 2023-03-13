<?php

declare(strict_types=1);

namespace Framework\Environment;

interface EnvironmentInterface
{
    public function getVariable(string $name): string;
}
