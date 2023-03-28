<?php

declare(strict_types=1);

namespace Framework\Orchestrator;

use Framework\Orchestrator\Annotation\AnnotatedOrchestrator;
use Framework\Orchestrator\Exception\IncompatibleTypeException;

/**
 * @template T of object
 * @implements OrchestratorInterface<T>
 */
abstract class AbstractOrchestrator implements OrchestratorInterface
{
    use AnnotatedOrchestrator;

    /** @var array<int, T> */
    private array $services = [];

    final public function addService(object $service): static
    {
        if (!is_a($service, static::getServiceClass())) {
            throw new IncompatibleTypeException(__CLASS__ . '::' . __METHOD__, static::getServiceClass());
        }

        $this->services[] = $service;

        return $this;
    }

    /**
     * @return array<int, T>
     */
    protected function getServices(): array
    {
        return $this->services;
    }
}
