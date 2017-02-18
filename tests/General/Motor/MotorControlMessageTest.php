<?php
namespace Volante\SkyBukkit\Common\Tests\General\Motor\FlightControllerTest;

use Volante\SkyBukkit\Common\Src\General\GyroStatus\GyroStatus;
use Volante\SkyBukkit\Common\Src\General\Motor\MotorControlMessage;
use Volante\SkyBukkit\Common\Src\General\Network\BaseRawMessage;

/**
 * Class MotorControlMessageTest
 *
 * @package Volante\SkyBukkit\Common\Tests\General\Motor\FlightControllerTest
 */
class MotorControlMessageTest extends \PHPUnit_Framework_TestCase
{
    public function test_toRawMessage_correct()
    {
        $expected = [
            'desiredPosition' => new GyroStatus(1, 2, 3),
            'horizontalThrottle'  => 0.5,
            'verticalThrottle'    => 0.3
        ];
        $motorStatus = new MotorControlMessage($expected['desiredPosition'], $expected['horizontalThrottle'], $expected['verticalThrottle']);
        $result = $motorStatus->toRawMessage();

        self::assertInstanceOf(BaseRawMessage::class, $result);
        self::assertEquals(MotorControlMessage::TYPE, $result->getType());
        self::assertEquals('Motor control', $result->getTitle());
        self::assertEquals($expected, $result->getData());
    }
}