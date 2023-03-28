<?php

declare(strict_types=1);

namespace Framework\Orchestrator\Exception;

use LogicException;

class IncompatibleTypeException extends LogicException
{
    /**
     * @param string $method
     * @param class-string $type
     */
    public function __construct(string $method, string $type)
    {
        parent::__construct(sprintf('The method "%s" only allows objects of type "%s"', $method, $type));
    }
}
