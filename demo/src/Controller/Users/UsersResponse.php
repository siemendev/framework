<?php

declare(strict_types=1);

namespace App\Controller\Users;

use Framework\Web\Request\ResponseInterface;

class UsersResponse implements ResponseInterface
{
    public string $data;
}
