<?php

declare(strict_types=1);

namespace Framework\DependencyInjection;

use Framework\DependencyInjection\Exception\IncompatibleServiceNameException;
use Framework\DependencyInjection\Exception\ServiceNotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface, NotInjectable
{
    /** @var array<class-string, object> */
    private array $services = [];

    /** @param class-string $id */
    public function get(string $id): object
    {
        if ($this->has($id)) {
            return $this->services[$id];
        }

        throw new ServiceNotFoundException($id);
    }

    /** @param class-string $id */
    public function has(string $id): bool
    {
        if (array_key_exists($id, $this->services)) {
            return true;
        }

        return false;
    }

    /**
     * @return array<class-string, object>
     */
    public function all(): array
    {
        return $this->services;
    }

    /** @param class-string $id */
    public function set(string $id, object $service): static
    {
        if (!$service instanceof $id) {
            throw new IncompatibleServiceNameException($id, $service);
        }

        $this->services[$id] = $service;

        return $this;
    }
}
