<?php

declare(strict_types=1);

namespace Framework\Web\Router;

use Framework\Web\Controller\ControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher as SymfonyUrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class UrlMatcher
{
    private const CONTROLLER_OPTION_NAME = 'controller';

    private RouteCollection $routeCollection;

    public function __construct()
    {
        $this->routeCollection = new RouteCollection();
    }

    public function addController(ControllerInterface $controller): static
    {
        foreach ($controller->routes() as $name => $route) {
            $route->setOption($this::CONTROLLER_OPTION_NAME, $controller);
            $this->routeCollection->add($name, $route);
        }

        return $this;
    }

    // todo implement proper error handling
    public function getController(Request $request): ControllerInterface
    {
        $matcher = new SymfonyUrlMatcher($this->routeCollection, (new RequestContext())->fromRequest($request));
        $attributes = $matcher->matchRequest($request);
        /** @var Route $route */
        $route = $this->routeCollection->get($attributes['_route']);
        /** @var ControllerInterface $controller */
        $controller = $route->getOption($this::CONTROLLER_OPTION_NAME);

        return $controller;
    }
}
