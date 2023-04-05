<?php

declare(strict_types=1);

namespace Framework\Templating\Integration;

use Framework\Templating\Response\TemplatingResponseInterface;
use Symfony\Component\HttpFoundation\Response;

interface IntegrationInterface
{
    public function boot(): void;

    /**
     * @return array<int, string> the key is the identifier and the value the file path relative to the project root
     */
    public function templates(): array;

    public function provides(string $identifier): bool;

    public function render(TemplatingResponseInterface $response): Response;
}
