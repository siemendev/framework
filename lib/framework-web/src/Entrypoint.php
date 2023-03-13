<?php

declare(strict_types=1);

namespace Framework\Web;

use Framework\Entrypoint\AbstractEntrypoint;
use Framework\Web\Controller\ControllerInterface;
use Framework\Web\Router\UrlMatcher;
use ReflectionClass;

/**
 * @property ControllerInterface[] $instances
 */
class Entrypoint extends AbstractEntrypoint
{
    private UrlMatcher $urlMatcher;

    public function eligible(ReflectionClass $reflection): bool
    {
        return !$reflection->isAbstract()
            && $reflection->implementsInterface(ControllerInterface::class);
    }

    public function boot(): void
    {
        $this->urlMatcher = new UrlMatcher();
        foreach ($this->instances as $controller) {
            $this->urlMatcher->addController($controller);
        }
    }

    public function getUrlMatcher(): UrlMatcher
    {
        return $this->urlMatcher;
    }
}
