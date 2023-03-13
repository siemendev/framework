<?php

declare(strict_types=1);

namespace Framework\Web\Server;

interface HttpServerInterface
{
    public function run(callable $requestHandler): void;
}
