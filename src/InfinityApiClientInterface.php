<?php
namespace Walkerus\InfinityCallCenterApiClient;

interface InfinityApiClientInterface
{
    public function getUserState(int $userId): int;
    public function makeCall(int $userId, string $number, int $tag = null): int;
    public function getConnectionsByCallId(int $callId): array;
    public function getRecord(int $connectionId): string;
}
