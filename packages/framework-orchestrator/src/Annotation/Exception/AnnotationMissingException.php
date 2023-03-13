<?php

declare(strict_types=1);

namespace Framework\Orchestrator\Annotation\Exception;

use Framework\Orchestrator\Annotation\Orchestrator;
use LogicException;

class AnnotationMissingException extends LogicException
{
    public function __construct(string $class)
    {
        parent::__construct(sprintf(
            'Class "%s" is missing the attribute "%s" to automatically configure the orchestrator.',
            $class,
            Orchestrator::class,
        ));
    }
}
