<?php

declare(strict_types=1);

namespace App\Orchestrator;

use Framework\Orchestrator\Annotation\AnnotatedOrchestrator;
use Framework\Orchestrator\Annotation\Orchestrator;
use Framework\Orchestrator\OrchestratorInterface;

/** @implements OrchestratorInterface<ServiceInterface> */
#[Orchestrator(serviceClass: ServiceInterface::class)]
class MyOrchestrator implements OrchestratorInterface
{
    use AnnotatedOrchestrator;

    /** @var ServiceInterface[] */
    private array $services = [];

    public function addService(object $service): static
    {
        $this->services[] = $service;

        return $this;
    }

    public function get(): string
    {
        return implode(';', array_map(static fn(ServiceInterface $service) => $service->get(), $this->services));
    }
}
