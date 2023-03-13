<?php

declare(strict_types=1);

namespace Framework\Entrypoint;

abstract class AbstractEntrypoint implements EntrypointInterface
{
    /** @var object[] */
    protected array $instances = [];

    public function add(object $instance): static
    {
        $this->instances[] = $instance;

        return $this;
    }

    public function boot(): void
    {
    }
}
