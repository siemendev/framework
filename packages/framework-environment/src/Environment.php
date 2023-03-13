<?php

declare(strict_types=1);

namespace Framework\Environment;

use Framework\Configuration;
use Symfony\Component\Dotenv\Dotenv;

class Environment implements EnvironmentInterface
{
    /** @var array<scalar, scalar> */
    private array $variables = [];

    private bool $loaded = false;

    private const ENV_FILES = [
        '%s/.env',
        '%s/.env.local',
    ];

    public function __construct(
        private readonly Configuration $configuration,
    ) {
    }

    public function getVariable(string $name): string
    {
        if (!$this->loaded) {
            $this->load();
        }
        return $_SERVER[$name] ?? $_ENV[$name] ?? $this->variables[$name] ?? '';
    }

    public function load(): static
    {
        static $dotenv = new Dotenv();
        $paths = array_map(
            fn(string $path) => sprintf($path, $this->configuration->getProjectRoot()),
            $this::ENV_FILES
        );
        foreach ($paths as $path) {
            if (!file_exists($path)) {
                continue;
            }
            foreach ($dotenv->parse(file_get_contents($path), $path) as $name => $value) {
                $this->variables[$name] = $value;
            }
        }
        $this->loaded = true;

        return $this;
    }
}
