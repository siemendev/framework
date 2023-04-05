<?php

declare(strict_types=1);

namespace App\Controller\Twig;

use Framework\Templating\Response\TemplatingResponseInterface;
use Framework\Web\Request\ResponseInterface;

class TwigResponse implements ResponseInterface, TemplatingResponseInterface
{
    public string $title;

    public string $data;

    public static function template(): string
    {
        return 'twig/index';
    }
}
