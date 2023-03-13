<?php

declare(strict_types=1);

namespace Framework\Web\Controller;

use Framework\Web\Exception\NoRoutesDefinedException;
use ReflectionClass;
use Symfony\Component\Routing\Annotation\Route as RouteAnnotation;
use Symfony\Component\Routing\Route;

trait AnnotatedController
{
    /**
     * @returns Route[]
     * @throws NoRoutesDefinedException
     */
    public function routes(): array
    {
        $routes = [];
        $reflection = new ReflectionClass($this);

        foreach ($reflection->getAttributes(RouteAnnotation::class) as $index => $routeAttribute) {
            /** @var RouteAnnotation $routeAnnotation */
            $routeAnnotation = $routeAttribute->newInstance();

            $routes[$routeAnnotation->getName() ?? $this::class . '_' . $index] = new Route(
                $routeAnnotation->getPath(),
                $routeAnnotation->getDefaults(),
                $routeAnnotation->getRequirements(),
                $routeAnnotation->getOptions(),
                $routeAnnotation->getHost(),
                $routeAnnotation->getSchemes(),
                $routeAnnotation->getMethods(),
                $routeAnnotation->getCondition(),
            );
        }

        if (0 === count($routes)) {
            throw new NoRoutesDefinedException($this::class);
        }

        return $routes;
    }
}
