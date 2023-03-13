<?php

declare(strict_types=1);

namespace Framework\Templating\Twig;

use Twig\Error\LoaderError;
use Twig\Loader\LoaderInterface;
use Twig\Source;

/**
 * Template storage
 * Contains all templates to keep them in memory. Derivate of \Twig\Loader\ArrayLoader
 */
class TemplateStorage implements LoaderInterface
{
    /** @var array<string, string> */
    private array $templates = [];

    public function setTemplate(string $name, string $template): void
    {
        $this->templates[$name] = $template;
    }

    /** @return array<string, string> */
    public function getTemplates(): array
    {
        return $this->templates;
    }

    public function getSourceContext(string $name): Source
    {
        if (!isset($this->templates[$name])) {
            throw new LoaderError(sprintf('Template "%s" is not defined.', $name));
        }

        return new Source($this->templates[$name], $name, $name . '.twig');
    }

    public function exists(string $name): bool
    {
        return isset($this->templates[$name]);
    }

    public function getCacheKey(string $name): string
    {
        if (!isset($this->templates[$name])) {
            throw new LoaderError(sprintf('Template "%s" is not defined.', $name));
        }

        return $name;
    }

    public function isFresh(string $name, int $time): bool
    {
        if (!isset($this->templates[$name])) {
            throw new LoaderError(sprintf('Template "%s" is not defined.', $name));
        }

        return true;
    }
}
