<?php

declare(strict_types=1);

namespace Framework\DependencyInjection\Exception;

use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;

class ServiceNotFoundException extends RuntimeException implements NotFoundExceptionInterface
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Could not find service with id "%s"', $id));
    }
}
