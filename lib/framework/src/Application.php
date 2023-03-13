<?php

declare(strict_types=1);

namespace Framework;

use Framework\DependencyInjection\DependencyInjection;
use Framework\DependencyInjection\NotInjectable;
use Framework\Entrypoint\EntrypointInterface;
use Framework\Extension\ExtensionInterface;
use Symfony\Component\Finder\Finder;

class Application implements NotInjectable
{
    /** @var EntrypointInterface[] */
    private array $entrypoints = [];

    /** @var ExtensionInterface[] */
    private array $extensions = [];

    private bool $bootFlag = false;

    public function __construct(
        private readonly Configuration $configuration,
    ) {
    }

    public function isBooted(): bool
    {
        return $this->bootFlag;
    }

    public function boot(): static
    {
        if ($this->bootFlag) {
            return $this;
        }

        $this->loadSourceFiles();
        (new DependencyInjection())->setup(
            $this->entrypoints,
            $this->extensions,
        );

        foreach ($this->entrypoints as $entrypoint) {
            $entrypoint->boot();
        }

        $this->bootFlag = true;

        return $this;
    }

    public function addEntrypoint(EntrypointInterface $entrypoint): static
    {
        $this->entrypoints[] = $entrypoint;

        return $this;
    }

    public function addExtension(ExtensionInterface $extension): static
    {
        $this->extensions[] = $extension->setConfiguration($this->configuration);

        return $this;
    }

    private function loadSourceFiles(): void
    {
        $sourceFiles = (new Finder())
            ->in($this->configuration->getSourcesRoot())
            ->files()
            ->name('*.php');

        foreach ($sourceFiles as $filename => $file) {
            require_once $filename;
        }
    }
}
