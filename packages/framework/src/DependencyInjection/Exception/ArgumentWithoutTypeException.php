<?php

declare(strict_types=1);

namespace Framework\DependencyInjection\Exception;

use Psr\Container\ContainerExceptionInterface;
use RuntimeException;

class ArgumentWithoutTypeException extends RuntimeException implements ContainerExceptionInterface
{
    public function __construct(string $argument, string $class)
    {
        parent::__construct(sprintf(
            'Constructor argument "%s" (%s) needs a type for the dependency to be resolved.',
            $argument,
            $class,
        ));
    }
}
