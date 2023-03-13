<?php

declare(strict_types=1);

namespace Framework\Templating\Renderer;

use Framework\Templating\Exception\NoIntegrationsAvailableException;
use Framework\Templating\Exception\NoMatchingTemplateFoundException;
use Framework\Templating\Exception\ResponseWithoutTemplateIdentifierException;
use Framework\Templating\Integration\IntegrationInterface;
use Framework\Templating\Response\TemplatingResponseInterface;
use Framework\Web\Rendering\Renderer\RendererInterface;
use Framework\Web\Request\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class TemplateRenderer implements RendererInterface
{
    /** @var IntegrationInterface[] */
    private array $integrations = [];

    public function boot(): void
    {
        if (0 === count($this->integrations)) {
            throw new NoIntegrationsAvailableException();
        }

        foreach ($this->integrations as $integration) {
            $integration->boot();
        }
    }

    public function addIntegration(IntegrationInterface $integration): static
    {
        $this->integrations[] = $integration;

        return $this;
    }

    /**
     * @throws NoMatchingTemplateFoundException
     */
    public function render(ResponseInterface $response): Response
    {
        if (!$response instanceof TemplatingResponseInterface) {
            throw new ResponseWithoutTemplateIdentifierException($response);
        }

        foreach ($this->integrations as $integration) {
            if ($integration->provides($response::template())) {
                return $integration->render($response);
            }
        }

        throw new NoMatchingTemplateFoundException($response::template(), $this->integrations);
    }
}
