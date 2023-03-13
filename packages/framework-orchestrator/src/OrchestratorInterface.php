<?php

declare(strict_types=1);

namespace Framework\Orchestrator;

/**
 * @template T of object
 */
interface OrchestratorInterface
{
    /** @return class-string<T> */
    public static function getServiceClass(): string;

    /** @param T $service */
    public function addService(object $service): static;
}
