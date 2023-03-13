<?php

declare(strict_types=1);

namespace App\Controller\Home;

use App\Factory\MyOrchestrator;
use Framework\Templating\Controller\TemplateController;
use Framework\Web\Request\RequestInterface;
use Framework\Web\Request\ResponseInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/")]
final class HomeController extends TemplateController
{
    public function __construct(
        private readonly MyOrchestrator $factory,
    ) {
    }

    public function respond(RequestInterface $request): ResponseInterface
    {
        $response = new HomeResponse();
        $response->title = 'home page';
        $response->data = $this->factory->get();

        return $response;
    }
}
