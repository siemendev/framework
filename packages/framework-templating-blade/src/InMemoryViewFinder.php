<?php

declare(strict_types=1);

namespace Framework\Templating\Blade;

use Illuminate\View\ViewFinderInterface;
use InvalidArgumentException;

class InMemoryViewFinder implements ViewFinderInterface
{
    /**
     * @var array<string, string>
     */
    private array $views = [];

    public function addView(string $name, string $path): static
    {
        $this->views[$name] = $path;

        return $this;
    }

    /**
     * Find view path
     * Returns the (virtual) path of the file for a view by it's name.
     * @param string $view
     */
    public function find($view): string
    {
        if (isset($this->views[$view])) {
            return $this->views[$view];
        }

        throw new InvalidArgumentException("View [{$view}] not found.");
    }

    /**
     * @return array<int, string>
     */
    public function all(): array
    {
        return array_keys($this->views);
    }

    /**
     * @param string $location
     */
    public function addLocation($location): void
    {
    }

    /**
     * @param string $namespace
     * @param string|array<string> $hints
     */
    public function addNamespace($namespace, $hints): void
    {
    }

    /**
     * @param string $namespace
     * @param string|array<string> $hints
     */
    public function prependNamespace($namespace, $hints): void
    {
    }

    /**
     * @param string $namespace
     * @param string|array<string> $hints
     */
    public function replaceNamespace($namespace, $hints): void
    {
    }

    /**
     * @param string $extension
     */
    public function addExtension($extension): void
    {
    }

    public function flush(): void
    {
        $this->views = [];
    }
}
