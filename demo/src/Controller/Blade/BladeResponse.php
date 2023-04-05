<?php

declare(strict_types=1);

namespace App\Controller\Blade;

use Framework\Templating\Response\TemplatingResponseInterface;
use Framework\Web\Request\ResponseInterface;

class BladeResponse implements ResponseInterface, TemplatingResponseInterface
{
    public string $title;

    public string $data;

    public static function template(): string
    {
        return 'blade.index';
    }
}
