<?php

declare(strict_types=1);

namespace Framework\Web\Rendering\Renderer;

use Framework\Web\Request\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonRenderer implements RendererInterface
{
    public function boot(): void
    {
        // needs no boot
    }

    public function render(ResponseInterface $response): Response
    {
        return new JsonResponse($response);
    }
}
