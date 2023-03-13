<?php

declare(strict_types=1);

namespace Framework\Extension;

use Framework\Configuration;
use Framework\DependencyInjection\DependencyResolver;

interface ExtensionInterface
{
    public function setConfiguration(Configuration $configuration): static;

    public function prepareContainer(DependencyResolver $dependencyResolver): void;

    public function manipulateContainer(DependencyResolver $dependencyResolver): void;
}
