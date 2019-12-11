<?php
namespace Walkerus\InfinityCallCenterApiClient\Test\Unit;

use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;
use Walkerus\InfinityCallCenterApiClient\Client;
use Walkerus\InfinityCallCenterApiClient\Exception\BadResponse;
use Walkerus\InfinityCallCenterApiClient\Exception\ConnectionNotFound;
use Walkerus\InfinityCallCenterApiClient\Exception\UserNotFound;
use Walkerus\InfinityCallCenterApiClient\Test\Helper;

class ClientTest extends TestCase
{
    public function testGetUserState(): void
    {
        $expectedState = 399;
        $guzzle = Helper::makeMockHttpGuzzleClient(
            json_encode([
                'result' => [
                    'IDUserState' => $expectedState
                ]
            ]),
            200
        );
        $client = new Client($guzzle);

        $this->assertEquals($expectedState, $client->getUserState(1));
    }

    public function testGetUserStateUserNotFoundException(): void
    {
        $this->expectException(UserNotFound::class);

        $guzzle = Helper::makeMockHttpGuzzleClient(
            json_encode([
                'result' => [
                    'ErrorMessage' => 'User not found'
                ]
            ]),
            406,
            ClientException::class
        );
        $client = new Client($guzzle);
        $client->getUserState(1);
    }

    public function testGetUserStateClientException(): void
    {
        $this->expectException(ClientException::class);

        $guzzle = Helper::makeMockHttpGuzzleClient(
            json_encode([
                'result' => [
                    'ErrorMessage' => 'Some error'
                ]
            ]),
            407,
            ClientException::class
        );
        $client = new Client($guzzle);
        $client->getUserState(1);
    }

    public function testGetUserStateBadResponseFormat(): void
    {
        $this->expectException(BadResponse::class);

        $guzzle = Helper::makeMockHttpGuzzleClient(
            json_encode([
                'result' => [
                    'IDUserStatee' => 1
                ]
            ]),
            407
        );
        $client = new Client($guzzle);
        $client->getUserState(1);
    }

    public function testMakeCall(): void
    {
        $expectedCallId = 123;
        $guzzle = Helper::makeMockHttpGuzzleClient(
            json_encode([
                'result' => [
                    'IDCall' => $expectedCallId
                ]
            ]),
            200
        );
        $client = new Client($guzzle);

        $this->assertEquals($expectedCallId, $client->makeCall(1, 1));
    }

    public function testMakeCallBadResponseException(): void
    {
        $this->expectException(BadResponse::class);

        $guzzle = Helper::makeMockHttpGuzzleClient(
            json_encode([
                'result' => [
                    'IDCalll' => 123
                ]
            ]),
            200
        );
        $client = new Client($guzzle);
        $client->makeCall(1, 1);
    }

    public function testGetConnectionsByCallId(): void
    {
        $expectedConnections = [1, 2, 3];

        $guzzle = Helper::makeMockHttpGuzzleClient(
            json_encode([
                'result' => [
                    'Connections' => $expectedConnections
                ]
            ]),
            200
        );
        $client = new Client($guzzle);

        $this->assertEquals($expectedConnections, $client->getConnectionsByCallId(1));
    }

    public function testGetConnectionsByCallIdBadResponse(): void
    {
        $this->expectException(BadResponse::class);

        $expectedMessage = json_encode([
            'result' => [
                'Connections' => 1
            ]
        ]);

        $this->expectExceptionMessage($expectedMessage);

        $guzzle = Helper::makeMockHttpGuzzleClient(
            $expectedMessage,
            200
        );
        $client = new Client($guzzle);
        $client->getConnectionsByCallId(1);
    }

    public function testGetRecord(): void
    {
        $expectedString = 'some string';
        $guzzle = Helper::makeMockHttpGuzzleClient(
            $expectedString,
            200
        );
        $client = new Client($guzzle);

        $this->assertEquals($expectedString, $client->getRecord(1));
    }

    public function testGetRecordConnectionNotFound(): void
    {
        $this->expectException(ConnectionNotFound::class);

        $guzzle = Helper::makeMockHttpGuzzleClient(
            'some string',
            406,
            ClientException::class
        );
        $client = new Client($guzzle);
        $client->getRecord(1);
    }
}
