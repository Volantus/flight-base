<?php
namespace Volante\SkyBukkit\Common\Tests\General\FlightController;

use Volante\SkyBukkit\Common\Src\General\FlightController\PIDFrequencyStatus;
use Volante\SkyBukkit\Common\Src\General\Network\BaseRawMessage;

/**
 * Class PIDFrequencyStatusTest
 *
 * @package Volante\SkyBukkit\Common\Tests\General\FlightController
 */
class PIDFrequencyStatusTest extends \PHPUnit_Framework_TestCase
{
    public function test_toRawMessage_correct()
    {
        $expected = [
            'desired' => 1000,
            'current' => 955.12
        ];

        $geoPosition = new PIDFrequencyStatus($expected['desired'], $expected['current']);
        $rawMessage = $geoPosition->toRawMessage();

        self::assertInstanceOf(BaseRawMessage::class, $rawMessage);
        self::assertEquals('Current PID frequency', $rawMessage->getTitle());
        self::assertEquals('PIDFrequencyStatus', $rawMessage->getType());
        self::assertEquals($expected, $rawMessage->getData());
    }
}