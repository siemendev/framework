<?php

declare(strict_types=1);

namespace Framework\DependencyInjection\Exception;

use Psr\Container\ContainerExceptionInterface;
use RuntimeException;

class ArgumentClassNotFoundException extends RuntimeException implements ContainerExceptionInterface
{
    public function __construct(string $argument, string $class)
    {
        parent::__construct(sprintf(
            'The type of constructor argument "%s" (%s) refers to a non-existing class.',
            $argument,
            $class,
        ));
    }
}
