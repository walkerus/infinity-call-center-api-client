<?php
namespace Walkerus\InfinityCallCenterApiClient\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class Helper
{
    public static function makeMockGuzzle(string $message, int $status, string $requestExceptionClass = null): Client
    {
        $mockHandler = $requestExceptionClass === null
            ? $mockHandler = new MockHandler([new Response($status, [], $message)])
            : $mockHandler = new MockHandler([new $requestExceptionClass($message, new Request('get', '/'), new Response($status))]);

        return new Client([
            'handler' => $mockHandler
        ]);
    }
}
