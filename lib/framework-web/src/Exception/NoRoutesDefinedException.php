<?php

declare(strict_types=1);

namespace Framework\Web\Exception;

use LogicException;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class NoRoutesDefinedException extends LogicException
{
    public function __construct(string $controllerClass, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            sprintf(
                'Controller "%s" does not provide any routes. ' .
                'Either implement the routes() method returning routes or add "%s" attributes.',
                $controllerClass,
                Route::class
            ),
            $code,
            $previous
        );
    }
}
