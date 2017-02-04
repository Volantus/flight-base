<?php
namespace Volante\SkyBukkit\Common\Tests\General\Motor\FlightControllerTest;

use Volante\SkyBukkit\Common\Src\General\Motor\Motor;
use Volante\SkyBukkit\Common\Src\General\Motor\MotorStatus;
use Volante\SkyBukkit\Common\Src\General\Network\BaseRawMessage;

/**
 * Class MotorStatusTest
 * @package Volante\SkyBukkit\Common\Tests\General\Motor\FlightControllerTest
 */
class MotorStatusTest extends \PHPUnit_Framework_TestCase
{
    public function test_toRawMessage_correct()
    {
        $expected = [
            'motors' => [
                new Motor(1, Motor::ZERO_LEVEL, 22),
                new Motor(2, Motor::FULL_LEVEL, 25)
            ]
        ];
        $motorStatus = new MotorStatus($expected['motors']);
        $result = $motorStatus->toRawMessage();

        self::assertInstanceOf(BaseRawMessage::class, $result);
        self::assertEquals(MotorStatus::TYPE, $result->getType());
        self::assertEquals('Motor status', $result->getTitle());
        self::assertEquals($expected, $result->getData());
    }
}