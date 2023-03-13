<?php

declare(strict_types=1);

namespace Framework\Console;

use Framework\Entrypoint\AbstractEntrypoint;
use ReflectionClass;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

/**
 * @property Command[] $instances
 */
class Entrypoint extends AbstractEntrypoint
{
    public function eligible(ReflectionClass $reflection): bool
    {
        return !$reflection->isAbstract() && $reflection->isSubclassOf(Command::class);
    }

    public function getConsole(): Application
    {
        $console = new Application();
        $console->addCommands($this->instances);

        return $console;
    }
}
