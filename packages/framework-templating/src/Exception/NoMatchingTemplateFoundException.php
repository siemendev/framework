<?php

declare(strict_types=1);

namespace Framework\Templating\Exception;

use Framework\Templating\Integration\IntegrationInterface;
use LogicException;
use Throwable;

class NoMatchingTemplateFoundException extends LogicException
{
    /** @param IntegrationInterface[] $integrations */
    public function __construct(string $identifier, array $integrations, int $code = 0, ?Throwable $previous = null)
    {
        $templates = [];
        foreach ($integrations as $integration) {
            foreach ($integration->templates() as $templateIdentifier) {
                $templates[] = $templateIdentifier;
            }
        }

        parent::__construct(
            sprintf(
                'Unable to find a template that matches the identifier "%s". Available templates: %s',
                $identifier,
                implode(',', $templates)
            ),
            $code,
            $previous,
        );
    }
}
