<?php

declare(strict_types=1);

namespace Framework\DependencyInjection\Exception;

use LogicException;
use Throwable;

class IncompatibleServiceNameException extends LogicException
{
    /** @param class-string $id */
    public function __construct(string $id, object $service, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf(
            "Service of type %s cannot use class %s as identifier without inheriting from it (implementing/extending).",
            $service::class,
            $id,
        ), $code, $previous);
    }
}
