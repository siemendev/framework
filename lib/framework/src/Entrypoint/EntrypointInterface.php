<?php

declare(strict_types=1);

namespace Framework\Entrypoint;

use ReflectionClass;

interface EntrypointInterface
{
    public function eligible(ReflectionClass $reflection): bool;

    public function add(object $instance): static;

    public function boot(): void;
}
