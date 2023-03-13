<?php

declare(strict_types=1);

namespace Framework\Server\Swoole;

use Framework\Web\Server\HttpServerInterface;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class SwooleHttpServer implements HttpServerInterface
{
    /** @param callable(SymfonyRequest): SymfonyResponse $requestHandler */
    public function run(callable $requestHandler): void
    {
        $http = new Server('0.0.0.0', 8000);
        $http->set(['hook_flags' => SWOOLE_HOOK_ALL]);
        $http->on(
            'request',
            function (Request $swooleRequest, Response $swooleResponse) use ($requestHandler) {
                SymfonyHttpBridge::reflectSymfonyResponse(
                    $requestHandler(
                        SymfonyHttpBridge::convertSwooleRequest($swooleRequest)
                    ),
                    $swooleResponse,
                );
            }
        );

        $http->start();
    }
}
