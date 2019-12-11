<?php
namespace Walkerus\InfinityCallCenterApiClient\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class Helper
{
    public static function makeMockHttpGuzzleClient(string $message, int $status, string $requestExceptionClass = null): Client
    {
        if (!is_null($requestExceptionClass)) {
            $mockHandler = new MockHandler([
                    new $requestExceptionClass($message, new Request('get', '/'), new Response($status)),
                ]
            );
        } else {
            $mockHandler = new MockHandler([
                new Response($status, [], $message)
            ]);
        }

        return new Client([
            'handler' => $mockHandler
        ]);
    }
}
