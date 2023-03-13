<?php

declare(strict_types=1);

namespace App\Controller\Users;

use App\Service\UserService;
use Framework\Web\Controller\AbstractController;
use Framework\Web\Request\RequestInterface;
use Framework\Web\Request\ResponseInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/users")]
final class UsersController extends AbstractController
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    public function respond(RequestInterface $request): ResponseInterface
    {
        $response = new UsersResponse();
        $response->data = $this->userService->get();

        return $response;
    }
}
