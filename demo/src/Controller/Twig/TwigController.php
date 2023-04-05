<?php

declare(strict_types=1);

namespace App\Controller\Twig;

use App\Orchestrator\MyOrchestrator;
use Framework\Templating\Controller\TemplateController;
use Framework\Web\Request\RequestInterface;
use Framework\Web\Request\ResponseInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/twig")]
final class TwigController extends TemplateController
{
    public function __construct(
        private readonly MyOrchestrator $factory,
    ) {
    }

    public function respond(RequestInterface $request): ResponseInterface
    {
        $response = new TwigResponse();
        $response->title = 'home page';
        $response->data = $this->factory->get();

        return $response;
    }
}
