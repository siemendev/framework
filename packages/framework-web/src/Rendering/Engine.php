<?php

declare(strict_types=1);

namespace Framework\Web\Rendering;

use Framework\Web\Rendering\Exception\RendererNotFoundException;
use Framework\Web\Rendering\Renderer\JsonRenderer;
use Framework\Web\Rendering\Renderer\RendererInterface;
use Framework\Web\Request\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class Engine
{
    /** @var array<class-string<RendererInterface>, RendererInterface> */
    private array $renderers = [];

    public function boot(): void
    {
        $this->renderers[JsonRenderer::class] = new JsonRenderer();

        foreach ($this->renderers as $renderer) {
            $renderer->boot();
        }
    }

    public function addRenderer(RendererInterface $renderer): static
    {
        $this->renderers[$renderer::class] = $renderer;

        return $this;
    }

    public function render(string $renderer, ResponseInterface $response): Response
    {
        if (!isset($this->renderers[$renderer])) {
            throw new RendererNotFoundException($renderer);
        }

        return $this->renderers[$renderer]->render($response);
    }
}
