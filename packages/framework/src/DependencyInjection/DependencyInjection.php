<?php

declare(strict_types=1);

namespace Framework\DependencyInjection;

use Framework\DependencyInjection\Exception\ArgumentClassNotFoundException;
use Framework\DependencyInjection\Exception\ArgumentWithoutTypeException;
use Framework\Entrypoint\EntrypointInterface;
use Framework\Extension\ExtensionInterface;
use ReflectionClass;

class DependencyInjection implements NotInjectable
{
    public readonly DependencyResolver $dependencyResolver;

    public function __construct()
    {
        $this->dependencyResolver = new DependencyResolver();
    }

    /**
     * @param array<EntrypointInterface> $entrypoints
     * @param array<ExtensionInterface> $extensions
     * @throws ArgumentWithoutTypeException
     * @throws ArgumentClassNotFoundException
     */
    public function setup(array $entrypoints, array $extensions): void
    {
        foreach ($extensions as $extension) {
            $extension->prepareContainer($this->dependencyResolver);
        }

        $this->resolveEntrypoints($entrypoints);

        foreach ($extensions as $extension) {
            $extension->manipulateContainer($this->dependencyResolver);
        }
    }

    /**
     * @param array<EntrypointInterface> $entrypoints
     * @throws ArgumentWithoutTypeException
     * @throws ArgumentClassNotFoundException
     */
    private function resolveEntrypoints(array $entrypoints): void
    {
        foreach (get_declared_classes() as $className) {
            $reflection = new ReflectionClass($className);

            foreach ($entrypoints as $entrypoint) {
                if ($entrypoint->eligible($reflection)) {
                    $entrypoint->add(
                        $this->dependencyResolver->instantiateService($reflection)
                    );
                }
            }
        }
    }
}
