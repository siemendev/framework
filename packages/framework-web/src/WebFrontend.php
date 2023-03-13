<?php

declare(strict_types=1);

namespace Framework\Web;

use Framework\Application;
use Framework\Web\Kernel\HttpKernel;
use Framework\Web\Rendering\Renderer\RendererInterface;
use Framework\Web\Server\HttpServerInterface;
use Symfony\Component\HttpFoundation\Request;

class WebFrontend
{
    private readonly HttpKernel $kernel;

    public function __construct(
        Application $application,
        private readonly HttpServerInterface $server,
    ) {
        $this->kernel = new HttpKernel($application);
    }

    public function addRenderer(RendererInterface $renderer): static
    {
        $this->kernel->addRenderer($renderer);

        return $this;
    }

    public function run(): static
    {
        $this->kernel->boot();
        $this->server->run(function (Request $request) {
            return $this->kernel->handle($request);
        });

        return $this;
    }
}
