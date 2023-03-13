<?php

declare(strict_types=1);

namespace Framework\Web\Controller;

use Framework\Web\Rendering\Renderer\JsonRenderer;
use Framework\Web\Request\EmptyRequest;

abstract class AbstractController implements ControllerInterface
{
    use AnnotatedController;

    public static function getRequestType(): string
    {
        return EmptyRequest::class;
    }

    public static function getRenderer(): string
    {
        return JsonRenderer::class;
    }
}
