<?php
namespace Volantus\FlightBase\Tests\General\FlightController;

use Volantus\FlightBase\Src\General\FlightController\PIDTuningStatus;
use Volantus\FlightBase\Src\General\FlightController\PIDTuningStatusCollection;
use Volantus\FlightBase\Src\General\Network\BaseRawMessage;

/**
 * Class PIDTuningStatusMessageTest
 *
 * @package Volantus\FlightBase\Tests\General\FlightController
 */
class PIDTuningStatusCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function test_toRawMessage_correct()
    {
        $expected = [
            'yaw'   => new PIDTuningStatus(1, 2, 3),
            'roll'  => new PIDTuningStatus(7, 8, 9),
            'pitch' => new PIDTuningStatus(4, 5, 6)
        ];

        $pidStatus = new PIDTuningStatusCollection($expected['yaw'], $expected['roll'], $expected['pitch']);
        $rawMessage = $pidStatus->toRawMessage();

        self::assertInstanceOf(BaseRawMessage::class, $rawMessage);
        self::assertEquals(PIDTuningStatusCollection::TYPE, $rawMessage->getType());
        self::assertEquals('PID tuning status', $rawMessage->getTitle());
        self::assertEquals($expected, $rawMessage->getData());
    }
}