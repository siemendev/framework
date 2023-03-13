<?php

declare(strict_types=1);

namespace Framework\Orchestrator;

use Framework\DependencyInjection\DependencyResolver;
use Framework\Extension\AbstractExtension;
use ReflectionClass;

class OrchestratorExtension extends AbstractExtension
{
    public function manipulateContainer(DependencyResolver $dependencyResolver): void
    {
        /** @var array<class-string, array<OrchestratorInterface>> $orchestrators */
        $orchestrators = [];

        foreach ($dependencyResolver->getContainer()->all() as $orchestrator) {
            if (!$orchestrator instanceof OrchestratorInterface) {
                continue;
            }

            if (!array_key_exists($orchestrator::getServiceClass(), $orchestrators)) {
                $orchestrators[$orchestrator::getServiceClass()] = [];
            }
            $orchestrators[$orchestrator::getServiceClass()][] = $orchestrator;
        }

        foreach (get_declared_classes() as $className) {
            $serviceOrchestrators = $this->getServiceOrchestrators($orchestrators, $className);

            if (0 === count($serviceOrchestrators)) {
                continue;
            }

            if ($dependencyResolver->getContainer()->has($className)) {
                $service = $dependencyResolver->getContainer()->get($className);
            } else {
                $service = $dependencyResolver->instantiateService(new ReflectionClass($className));
            }

            foreach ($serviceOrchestrators as $orchestrator) {
                $orchestrator->addService($service);
            }
        }
    }

    /**
     * @param array<class-string, array<OrchestratorInterface>> $orchestrators
     * @param class-string $serviceClassName
     * @return array<OrchestratorInterface>
     */
    private function getServiceOrchestrators(array $orchestrators, string $serviceClassName): array
    {
        // todo this can be optimized!
        foreach ($orchestrators as $serviceClass => $serviceFactories) {
            if (is_a($serviceClassName, $serviceClass)) { // @phpstan-ignore-line
                return $serviceFactories;
            }
            $implements = class_implements($serviceClassName);
            if (isset($implements[$serviceClass])) {
                return $serviceFactories;
            }
        }

        return [];
    }
}
