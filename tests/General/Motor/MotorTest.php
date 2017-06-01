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
}