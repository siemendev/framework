<?php

declare(strict_types=1);

namespace Framework\Templating\Response;

interface TemplatingResponseInterface
{
    /**
     * Template
     * Returns the template identifier (path) that will be used to render this response.
     */
    public static function template(): string;
}
