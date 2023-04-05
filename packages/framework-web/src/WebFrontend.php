<?php

declare(strict_types=1);

namespace Framework\Web;

use Framework\Application;
use Framework\Web\Kernel\HttpKernel;
use Framework\Web\Rendering\Renderer\RendererInterface;
use Framework\Web\Server\HttpServerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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
            try {
                return $this->kernel->handle($request);
            } catch (Throwable $e) {
                // todo improve error handling (different status codes on different exceptions, nice error pages, etc.)
                return new Response('<h1>Something went wrong.</h1>', 500);
            }
        });

        return $this;
    }
}
