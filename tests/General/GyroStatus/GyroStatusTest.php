<?php
namespace Volantus\FlightBase\Tests\General\GyroStatus;

use Volantus\FlightBase\Src\General\GyroStatus\GyroStatus;
use Volantus\FlightBase\Src\General\Network\BaseRawMessage;

/**
 * Class GyroStatusTest
 *
 * @package Volantus\FlightBase\Tests\General\GyroStatus
 */
class GyroStatusTest extends \PHPUnit_Framework_TestCase
{
    public function test_toRawMessage_correct()
    {
        $expected = [
            'yaw'   => 1.11,
            'pitch' => 2.22,
            'roll'  => 3.33
        ];
        $gyroStatus = new GyroStatus(1.11, 3.33, 2.22);
        $result = $gyroStatus->toRawMessage();

        self::assertInstanceOf(BaseRawMessage::class, $result);
        self::assertEquals('gyroStatus', $result->getType());
        self::assertEquals('Gyro Status', $result->getTitle());
        self::assertEquals($expected, $result->getData());
    }

    public function test_jsonSerialize_correct()
    {
        $expected = [
            'yaw'   => 1.11,
            'pitch' => 2.22,
            'roll'  => 3.33
        ];
        $gyroStatus = new GyroStatus(1.11, 3.33, 2.22);
        $result = $gyroStatus->jsonSerialize();

        self::assertEquals($expected, $result);
    }
}