<?php

declare(strict_types=1);

namespace Framework\Web\Kernel;

use Framework\Application;
use Framework\Web\Entrypoint;
use Framework\Web\Rendering\Engine;
use Framework\Web\Rendering\Renderer\RendererInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class HttpKernel implements HttpKernelInterface
{
    private Entrypoint $entrypoint;

    private Engine $engine;

    public function __construct(
        private readonly Application $application,
    ) {
        $this->engine = new Engine();
        $this->entrypoint = new Entrypoint();
    }

    public function boot(): static
    {
        $this->application
            ->addEntrypoint($this->entrypoint)
            ->boot()
        ;
        $this->engine->boot();

        return $this;
    }

    public function addRenderer(RendererInterface $renderer): static
    {
        $this->engine->addRenderer($renderer);

        return $this;
    }

    public function handle(Request $request, int $type = self::MAIN_REQUEST, bool $catch = true): Response
    {
        if (!$this->application->isBooted()) {
            // todo log information that the kernel executed a "handle" before being booted to inform about the poor
            //      performance of not booting the system properly
            $this->boot();
        }

        $controller = $this->entrypoint->getUrlMatcher()->getController($request);

        return $this->engine->render(
            $controller::getRenderer(),
            $controller->respond(
                $controller::getRequestType()::createFromRequest($request)
            ),
        );
    }
}
