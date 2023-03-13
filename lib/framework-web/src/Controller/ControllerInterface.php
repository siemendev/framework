<?php

declare(strict_types=1);

namespace Framework\Web\Controller;

use Framework\Web\Rendering\Renderer\RendererInterface;
use Framework\Web\Request\RequestInterface;
use Framework\Web\Request\ResponseInterface;
use Symfony\Component\Routing\Route;

interface ControllerInterface
{
    /** @return Route[] */
    public function routes(): array;

    /** @return class-string<RequestInterface> */
    public static function getRequestType(): string;

    /** @return class-string<RendererInterface> */
    public static function getRenderer(): string;

    public function respond(RequestInterface $request): ResponseInterface;
}
