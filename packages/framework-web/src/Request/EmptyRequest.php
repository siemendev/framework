<?php

declare(strict_types=1);

namespace Framework\Web\Request;

use Symfony\Component\HttpFoundation\Request;

final class EmptyRequest implements RequestInterface
{
    public static function createFromRequest(Request $request): static
    {
        return new self();
    }
}
