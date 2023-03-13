<?php

declare(strict_types=1);

namespace Framework\Templating\Exception;

use Framework\Templating\Response\TemplatingResponseInterface;
use Framework\Web\Request\ResponseInterface;
use LogicException;
use Throwable;

class ResponseWithoutTemplateIdentifierException extends LogicException
{
    public function __construct(ResponseInterface $response, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            sprintf(
                'Response "%s" needs to implement "%s" to provide a template identifier that can be matched.',
                $response::class,
                TemplatingResponseInterface::class
            ),
            $code,
            $previous
        );
    }
}
