<?php
namespace Walkerus\InfinityCallCenterApiClient\Test\Unit;

use PHPUnit\Framework\TestCase;
use Walkerus\InfinityCallCenterApiClient\Models\UserState;

class UserStateTest extends TestCase
{
    public function testCommon()
    {
        $expectedCode = 300;
        $expectedDescription = 'Ready';
        $state = new UserState(300);

        $this->assertEquals($expectedCode, $state->getCode());
        $this->assertEquals($expectedDescription, $state->getDescription());

        $expectedCode = 1;
        $expectedDescription = 'Undefined state';
        $state = new UserState(1);

        $this->assertEquals($expectedCode, $state->getCode());
        $this->assertEquals($expectedDescription, $state->getDescription());
    }
}
