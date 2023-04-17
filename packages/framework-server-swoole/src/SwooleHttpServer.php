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
    private const DEFAULT_CONFIG = [
        'hook_flags' => SWOOLE_HOOK_ALL,
    ];

    /**
     * @param string $host the host (ip) the server should listen to. Usually 0.0.0.0 to listen on all interfaces.
     * @param int $port The port the server should listen on.
     * @param array<string, scalar> $config The swoole server configuration, see https://openswoole.com/docs/modules/swoole-server/configuration
     */
    public function __construct(
        private readonly string $host = '0.0.0.0',
        private readonly int $port = 8000,
        private readonly array $config = [],
        private readonly int $mode = SWOOLE_BASE,
        private readonly int $sockType = SWOOLE_SOCK_TCP,
    ) {
    }

    /** @param callable(SymfonyRequest): SymfonyResponse $requestHandler */
    public function run(callable $requestHandler): void
    {
        $http = new Server($this->host, $this->port, $this->mode, $this->sockType);
        $http->set(array_merge($this->config, self::DEFAULT_CONFIG));
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
