<?php

declare(strict_types=1);

namespace Framework\Orchestrator\Annotation;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Orchestrator
{
    /**
     * @param class-string $serviceClass
     */
    public function __construct(
        public string $serviceClass,
    ) {
    }
}
