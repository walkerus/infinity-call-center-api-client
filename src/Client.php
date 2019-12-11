<?php
namespace Walkerus\InfinityCallCenterApiClient;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use Walkerus\InfinityCallCenterApiClient\Exception\BadResponse;
use Walkerus\InfinityCallCenterApiClient\Exception\ConnectionNotFound;
use Walkerus\InfinityCallCenterApiClient\Exception\UserNotFound;

class Client implements InfinityApiClientInterface
{
    protected $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param int $userId
     * @return int
     * @throws UserNotFound
     * @throws BadResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserState(int $userId): int
    {
        try {
            $response = $this->client->request('get', '/user/getstate', [
                'query' => [
                    'IDUser' => $userId
                ]
            ]);
        } catch (GuzzleClientException $ex) {
            if ($ex->getCode() == 406) {
                throw new UserNotFound($ex->getMessage(), 406);
            }

            throw $ex;
        }

        $content = $response->getBody()->getContents();
        $userState = json_decode($content)->result->IDUserState ?? null;

        if (is_null($userState)) {
            throw new BadResponse($content);
        }

        return $userState;
    }

    /**
     * @param int $userId
     * @param string $number
     * @param int|null $tag
     * @return int
     * @throws BadResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function makeCall(int $userId, string $number, int $tag = null): int
    {
        $query = [
            'IDUser' => $userId,
            'Number' => $number,
        ];

        if (!is_null($tag)) {
            $query['Tag'] = $tag;
        }

        $response = $this->client->request('get', '/call/make', [
            'query' => $query,
        ]);

        $content = $response->getBody()->getContents();
        $callId = json_decode($content)->result->IDCall ?? null;

        if (is_null($callId)) {
            throw new BadResponse($content);
        }

        return $callId;
    }

    /**
     * @param int $callId
     * @return array
     * @throws BadResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getConnectionsByCallId(int $callId): array
    {
        $response = $this->client->request('get', '/stat/connectionsbycall', [
            'query' => [
                'IDCall' => $callId,
            ],
        ]);

        $content = $response->getBody()->getContents();
        $connections = json_decode($content)->result->Connections ?? null;

        if (!is_array($connections)) {
            throw new BadResponse($content);
        }

        return $connections;
    }

    /**
     * @param int $connectionId
     * @param string $codec
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws ConnectionNotFound
     */
    public function getRecord(int $connectionId, string $codec = null): string
    {
        $query = [
            'IDConnection' => $connectionId,
        ];

        if (!is_null($codec)) {
            $query['codec'] = $codec;
        }

        try {
            $response = $this->client->request('get', '/stat/getrecordedfile', [
                'query' => $query
            ]);
        } catch (GuzzleClientException $ex) {
            if ($ex->getCode() == 406) {
                throw new ConnectionNotFound($ex->getMessage(), 406);
            }

            throw $ex;
        }


        return $response->getBody()->getContents();
    }

    static public function make(string $baseUri, int $timeout = 10, int $connectTimeout = 5): self
    {
        $guzzle = new \GuzzleHttp\Client([
            'base_uri' => $baseUri,
            'timeout' => $timeout,
            'connect_timeout' => $connectTimeout,
        ]);

        return new self($guzzle);
    }
}
