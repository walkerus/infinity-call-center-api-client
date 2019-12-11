<?php
namespace Walkerus\InfinityCallCenterApiClient\Models;

interface UserStateInterface
{
    public function getCode(): int;
    public function getDescription(): string;
}
