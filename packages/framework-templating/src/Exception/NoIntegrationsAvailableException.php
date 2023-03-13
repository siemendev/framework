<?php

declare(strict_types=1);

namespace Framework\Templating\Exception;

use Framework\Templating\Renderer\TemplateRenderer;
use LogicException;
use Throwable;

class NoIntegrationsAvailableException extends LogicException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            sprintf(
                'There are no integrations registered at the templating engine. " .
                "Please add one using "%s:addIntegration()".',
                TemplateRenderer::class
            ),
            $code,
            $previous,
        );
    }
}
