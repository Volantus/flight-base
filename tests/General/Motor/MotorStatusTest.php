<?php
namespace Volantus\FlightBase\Tests\General\Motor\FlightControllerTest;

use Volantus\FlightBase\Src\General\Motor\Motor;
use Volantus\FlightBase\Src\General\Motor\MotorStatus;
use Volantus\FlightBase\Src\General\Network\BaseRawMessage;

/**
 * Class MotorStatusTest
 * @package Volantus\FlightBase\Tests\General\Motor\FlightControllerTest
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