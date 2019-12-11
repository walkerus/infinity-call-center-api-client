<?php
namespace Walkerus\InfinityCallCenterApiClient\Models;

class UserState implements UserStateInterface
{
    protected $code;

    public function __construct(int $code)
    {
        $this->code = $code;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getDescription(): string
    {
        $dictionary = [
            300 => 'Ready',
            301 => 'Break',
            302 => 'Gone away',
            303 => 'Unavailable',
            304 => 'Busy',
            399 => 'Offline',
        ];

        return $dictionary[$this->code] ?? 'Undefined state';
    }
}
