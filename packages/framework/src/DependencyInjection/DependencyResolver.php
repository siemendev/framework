<?php

declare(strict_types=1);

namespace Framework\DependencyInjection;

use Framework\DependencyInjection\Exception\ArgumentClassNotFoundException;
use Framework\DependencyInjection\Exception\ArgumentWithoutTypeException;
use Framework\DependencyInjection\Exception\NotInjectableClassException;
use ReflectionClass;
use ReflectionNamedType;

class DependencyResolver implements NotInjectable
{
    private readonly Container $container;

    public function __construct(
        ?Container $container = null,
    ) {
        $this->container = $container ?? new Container();
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @throws ArgumentWithoutTypeException
     * @throws ArgumentClassNotFoundException
     * @throws NotInjectableClassException
     */
    public function instantiateService(ReflectionClass $reflection): object
    {
        // todo add a backtrace for debugging in exceptions
        $arguments = [];

        if ($reflection->implementsInterface(NotInjectable::class)) {
            throw new NotInjectableClassException($reflection->getName());
        }

        foreach ($reflection->getConstructor()?->getParameters() ?? [] as $parameter) {
            $parameterType = $parameter->getType();
            if (!$parameterType instanceof ReflectionNamedType) {
                throw new ArgumentWithoutTypeException($parameter->getName(), $reflection->getName());
            }

            if (!class_exists($parameterType->getName())) {
                throw new ArgumentClassNotFoundException($parameter->getName(), $reflection->getName());
            }

            if (!$this->container->has($parameterType->getName())) {
                $argument = $this->instantiateService(new ReflectionClass($parameterType->getName()));
                $this->container->set($parameterType->getName(), $argument);
                $arguments[] = $argument;
                continue;
            }
            $arguments[] = $this->container->get($parameterType->getName());
        }

        return $reflection->newInstanceArgs($arguments);
    }
}
