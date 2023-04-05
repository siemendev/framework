<?php

declare(strict_types=1);

namespace App\Controller\Blade;

use App\Orchestrator\MyOrchestrator;
use Framework\Templating\Controller\TemplateController;
use Framework\Web\Request\RequestInterface;
use Framework\Web\Request\ResponseInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/blade")]
final class BladeController extends TemplateController
{
    public function __construct(
        private readonly MyOrchestrator $factory,
    ) {
    }

    public function respond(RequestInterface $request): ResponseInterface
    {
        $response = new BladeResponse();
        $response->title = 'home page';
        $response->data = $this->factory->get();

        return $response;
    }
}
