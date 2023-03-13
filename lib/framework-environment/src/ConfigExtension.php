<?php

declare(strict_types=1);

namespace Framework\Environment;

use Framework\DependencyInjection\Container;
use Framework\DependencyInjection\DependencyResolver;
use Framework\Extension\AbstractExtension;

class ConfigExtension extends AbstractExtension
{
    public function prepareContainer(DependencyResolver $dependencyResolver): void
    {
        // todo use interface instead of implementation
        $dependencyResolver->getContainer()->set(Environment::class, (new Environment($this->configuration))->load());
    }
}
