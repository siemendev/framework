<?php

declare(strict_types=1);

namespace Framework\DependencyInjection;

/**
 * Not injectable interface
 * Used to identify classes that should never be injected into a service.
 * Implement this interface and the dependency injection will refuse to inject your class into any other service.
 */
interface NotInjectable
{
}
