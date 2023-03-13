<?php

declare(strict_types=1);

namespace Framework\Extension;

use Framework\Configuration;
use Framework\DependencyInjection\Container;
use Framework\DependencyInjection\DependencyResolver;

/**
 * Abstract extension
 * Used to bootstrap all methods of the extension interface, so you can focus on only the methods needed for your
 * use case. This basically only provides an extension that does nothing.
 */
abstract class AbstractExtension implements ExtensionInterface
{
    protected Configuration $configuration;

    public function setConfiguration(Configuration $configuration): static
    {
        $this->configuration = $configuration;

        return $this;
    }

    public function manipulateContainer(DependencyResolver $dependencyResolver): void
    {
    }

    public function prepareContainer(DependencyResolver $dependencyResolver): void
    {
    }
}
