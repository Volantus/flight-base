<?php
namespace  Volantus\FlightBase\Tests\General\Motor\FlightControllerTest;

use Volantus\FlightBase\Src\General\Motor\Motor;

/**
 * Class MotorTest
 *
 * @package Volante\SkyBukkit\FlightController\Tests\FlightControllerTest
 */
class MotorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage GPIO Pin for motor 9 needs to be configured
     */
    public function test_constructor_gpioPinNotConfigured()
    {
        putenv('MOTOR_9_PIN');
        new Motor(9, Motor::ZERO_LEVEL);
    }

    public function test_jsonSerialize_correct()
    {
        $expected = [
            'id'    => 5,
            'pin'   => 22,
            'power' => Motor::ZERO_LEVEL + 200
        ];
        $motor = new Motor(5, $expected['power'], 22);

        self::assertEquals($expected, $motor->jsonSerialize());
    }

    public function test_changePower_positiveChange()
    {
        $motor = new Motor(0, Motor::ZERO_LEVEL, 1);
        $motor->changePower(200);

        self::assertEquals(Motor::ZERO_LEVEL + 200, $motor->getPower());
    }

    public function test_changePower_negativeChange()
    {
        $motor = new Motor(0, Motor::FULL_LEVEL, 1);
        $motor->changePower(-200);

        self::assertEquals(Motor::FULL_LEVEL - 200, $motor->getPower());
    }

    public function test_changePower_minLimit()
    {
        $motor = new Motor(0, Motor::ZERO_LEVEL, 1);
        $motor->changePower(-200);

        self::assertEquals(Motor::ZERO_LEVEL, $motor->getPower());
    }

    public function test_changePower_maxLimit()
    {
        $motor = new Motor(0, Motor::FULL_LEVEL, 1);
        $motor->changePower(200);

        self::assertEquals(Motor::FULL_LEVEL, $motor->getPower());
    }

    public function test_setPower_correct()
    {
        $motor = new Motor(0, Motor::ZERO_LEVEL, 1);
        $motor->setPower(Motor::ZERO_LEVEL + 200);

        self::assertEquals(Motor::ZERO_LEVEL + 200, $motor->getPower());
    }

    public function test_setPower_minLimit()
    {
        $motor = new Motor(0, Motor::ZERO_LEVEL, 1);
        $motor->setPower(Motor::ZERO_LEVEL - 200);

        self::assertEquals(Motor::ZERO_LEVEL, $motor->getPower());
    }

    public function test_setPower_maxLimit()
    {
        $motor = new Motor(0, Motor::FULL_LEVEL, 1);
        $motor->setPower(Motor::FULL_LEVEL + 200);

        self::assertEquals(Motor::FULL_LEVEL, $motor->getPower());
    }

    protected function tearDown()
    {
        putenv('MOTOR_9_PIN=1');
    }
}