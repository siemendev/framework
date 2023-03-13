<?php

declare(strict_types=1);

namespace Framework\Web\Rendering\Renderer;

use Framework\Web\Request\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

interface RendererInterface
{
    public function boot(): void;

    public function render(ResponseInterface $response): Response;
}
