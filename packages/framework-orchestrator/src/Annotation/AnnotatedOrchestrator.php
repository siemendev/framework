<?php

declare(strict_types=1);

namespace Framework\Orchestrator\Annotation;

use Framework\Orchestrator\Annotation\Exception\AnnotationMissingException;
use ReflectionClass;

trait AnnotatedOrchestrator
{
    /**
     * @return class-string
     * @throws AnnotationMissingException
     */
    public static function getServiceClass(): string
    {
        $reflection = new ReflectionClass(static::class);

        foreach ($reflection->getAttributes(Orchestrator::class) as $attribute) {
            /** @var Orchestrator $annotation */
            $annotation = $attribute->newInstance();

            return $annotation->serviceClass;
        }

        throw new AnnotationMissingException($reflection->getName());
    }
}
