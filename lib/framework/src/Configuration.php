<?php

declare(strict_types=1);

namespace Framework;

use Framework\DependencyInjection\NotInjectable;

class Configuration implements NotInjectable
{
    private string $projectRoot;

    private string $sourcesRoot;

    public function setProjectRoot(string $projectRoot): static
    {
        $this->projectRoot = $projectRoot;

        return $this;
    }

    public function getProjectRoot(): string
    {
        if (!isset($this->projectRoot)) {
            // todo use debug_backtrace to determine the root
        }

        return $this->projectRoot;
    }

    public function setSourcesRoot(string $sourcesRoot): void
    {
        $this->sourcesRoot = $sourcesRoot;
    }

    public function getSourcesRoot(): string
    {
        // todo check if this is a directory, otherwise throw error that the config has to be set
        return $this->sourcesRoot ?? $this->getProjectRoot() . '/src';
    }
}
