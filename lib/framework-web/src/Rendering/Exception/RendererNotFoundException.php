<?php

declare(strict_types=1);

namespace Framework\Web\Rendering\Exception;

use LogicException;
use Throwable;

class RendererNotFoundException extends LogicException
{
    public function __construct(string $rendererClass, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            sprintf(
                // todo improve exception message with information how to add renderers
                'Renderer "%s" not found.',
                $rendererClass
            ),
            $code,
            $previous,
        );
    }
}
