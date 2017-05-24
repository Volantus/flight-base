<?php
namespace Volantus\FlightBase\Tests\General\Motor\FlightControllerTest;

use Volantus\FlightBase\Src\General\GyroStatus\GyroStatus;
use Volantus\FlightBase\Src\General\Motor\MotorControlMessage;
use Volantus\FlightBase\Src\General\Network\BaseRawMessage;

/**
 * Class MotorControlMessageTest
 *
 * @package Volantus\FlightBase\Tests\General\Motor\FlightControllerTest
 */
class MotorControlMessageTest extends \PHPUnit_Framework_TestCase
{
    public function test_toRawMessage_correct()
    {
        $expected = [
            'desiredPosition'    => new GyroStatus(1, 2, 3),
            'horizontalThrottle' => 0.5,
            'verticalThrottle'   => 0.3,
            'motorsStarted'      => true
        ];
        $motorStatus = new MotorControlMessage($expected['desiredPosition'], $expected['horizontalThrottle'], $expected['verticalThrottle'], true);
        $result = $motorStatus->toRawMessage();

        self::assertInstanceOf(BaseRawMessage::class, $result);
        self::assertEquals(MotorControlMessage::TYPE, $result->getType());
        self::assertEquals('Motor control', $result->getTitle());
        self::assertEquals($expected, $result->getData());
    }
}