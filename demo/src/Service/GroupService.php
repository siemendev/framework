<?php

declare(strict_types=1);

namespace App\Service;

class GroupService
{
    public function __construct(
        private readonly UserService $userService,
    ) {
    }

    public function get(): string
    {
        return 'group (' . $this->userService->get() . ')';
    }
}
