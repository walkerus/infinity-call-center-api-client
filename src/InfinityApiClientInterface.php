<?php
namespace Walkerus\InfinityCallCenterApiClient;

use Walkerus\InfinityCallCenterApiClient\Exception\BadResponse;
use Walkerus\InfinityCallCenterApiClient\Exception\ConnectionNotFound;
use Walkerus\InfinityCallCenterApiClient\Exception\UserNotFound;
use Walkerus\InfinityCallCenterApiClient\Models\UserStateInterface;

interface InfinityApiClientInterface
{
    public function getUserState(int $userId): UserStateInterface;

    /**
     * @param int $userId
     * @param string $number
     * @param int|null $tag
     * @return int call id
     * @throws BadResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function makeCall(int $userId, string $number, int $tag = null): int;

    /**
     * @param int $callId
     * @return array array of connection ids
     * @throws BadResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getConnectionsByCallId(int $callId): array;

    /**
     * @param int $connectionId
     * @param string $codec gsm|pcm|mp3
     * @return string content of voice file
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws ConnectionNotFound
     */
    public function getRecord(int $connectionId, string $codec = null): string;
}
