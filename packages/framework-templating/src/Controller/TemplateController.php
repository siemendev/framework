<?php

declare(strict_types=1);

namespace Framework\Templating\Controller;

use Framework\Templating\Renderer\TemplateRenderer;
use Framework\Web\Controller\AbstractController;

abstract class TemplateController extends AbstractController
{
    public static function getRenderer(): string
    {
        return TemplateRenderer::class;
    }
}
