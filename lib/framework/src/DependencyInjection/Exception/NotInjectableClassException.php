<?php

declare(strict_types=1);

namespace Framework\DependencyInjection\Exception;

use Framework\DependencyInjection\NotInjectable;
use LogicException;
use Throwable;

class NotInjectableClassException extends LogicException
{
    public function __construct(string $class, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf(
            'Class %s cannot be injected into a service (implements %s).',
            $class,
            NotInjectable::class
        ), $code, $previous);
    }
}
